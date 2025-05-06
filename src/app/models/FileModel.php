<?php
class FileModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'files';
    }

    public function getList()
    {
        $sql = "SELECT * FROM $this->_table";
        $result = $this->db->execute($sql);
        return $result['data'];
    }

    public function addFile($data)
    {
        $sql = "INSERT INTO $this->_table (name, fkey, url, size, type) 
                VALUES (:name, :fkey, :url, :size, :type)";

        $params = [
            ':name' => $data['name'],
            ':fkey' => $data['fkey'],
            ':url' => $data['path'],
            ':size' => $data['size'],
            ':type' => $data['type']
        ];

        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }

    public function getFile($filter = [])
    {
        $conditions = [];
        $params = [];

        foreach ($filter as $key => $value) {
            if (!empty($value)) {
                $conditions[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }

        if (empty($conditions)) {
            return null;
        }

        $where = implode(' AND ', $conditions);
        $sql = "SELECT * FROM $this->_table WHERE $where";
        $result = $this->db->execute($sql, $params, true);
        return $result['data'];
    }

    public function uploadFileToCarAsset($car_id)
    {
        $media = $_FILES['media'];
        $aws = new AwsS3Service();
        $uploadFile = $aws->uploadFile($media, 'cars');
        if ($uploadFile) {
            $this->addFile([
                'name' => $media['name'],
                'fkey' => $uploadFile['fileKey'],
                'path' => $uploadFile['fileUrl'],
                'size' => $media['size'],
                'type' => $media['type']
            ]);
            $file = $this->getFile(['fkey' => $uploadFile['fileKey']]);
            $sql = "INSERT INTO car_assets (car_id, file_id) VALUES (:car_id, :file_id)";
            $params = [
                ':car_id' => $car_id,
                ':file_id' => $file['id']
            ];
            $result = $this->db->execute($sql, $params);
            return $result['success'];
        }
        return false;
    }

    public function deleteFileFromCarAsset($car_id, $file_id)
    {
        $file = $this->getFileFromCarAssets($car_id, $file_id);
        if (empty($file)) {
            return false; // File không tồn tại
        }
        $aws = new AwsS3Service();
        $fileInAws = $aws->getFileUrl($file['fkey']);
        if ($fileInAws) {
            $aws->deleteFile($file['fkey']);
        }
        $sql = "DELETE FROM files WHERE id = :file_id";
        $params = [
            ':file_id' => $file_id
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }

    public function getFileFromCarAssets($car_id, $file_id) {
        $sql = "SELECT f.* FROM car_assets ca INNER JOIN files f ON f.id = :file_id WHERE car_id = :car_id AND file_id = :file_id";
        $params = [
            ':car_id' => $car_id,
            ':file_id' => $file_id
        ];
        $result = $this->db->execute($sql, $params, true);
        return $result['data'];
    }

    public function deleteOne($id)
    {
        $sql = "DELETE FROM $this->_table WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }
}
