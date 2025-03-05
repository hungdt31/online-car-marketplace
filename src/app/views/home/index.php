<?php
    if (empty($user)) {
        // Tạo dữ liệu giả nếu mảng $user rỗng
        $user = [
            [
                "firstname" => "Nguyễn",
                "lastname" => "A",
                "email" => "nguyena@example.com",
                "reg_date" => "2023-01-01"
            ],
            [
                "firstname" => "Trần",
                "lastname" => "B",
                "email" => "tranb@example.com",
                "reg_date" => "2023-02-01"
            ]
        ];
    }
    
    $cookie_name = 'access_token';
    if(!isset($_COOKIE[$cookie_name])) {
        echo "Cookie named '" . $cookie_name . "' is not set!";
    } else {
        echo "Cookie '" . $cookie_name . "' is set!<br>";
        echo "Value is: " . $_COOKIE[$cookie_name];
    }
?>

<div class="container mt-3">
    <div class="row row-cols-1 row-cols-sm-2 g-4"> <!-- Bắt đầu với 1 cột và chuyển sang 2 cột khi SM -->
        <?php
        foreach ($user as $value) {
            ?>
            <div class="col">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($value["firstname"]) . ' - ' . htmlspecialchars($value["lastname"]); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($value["email"]); ?></h6>
                        <p class="card-text"><?php echo htmlspecialchars($value["reg_date"]); ?></p>
                        <a href="#" class="card-link">Xem thêm</a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <form>
            <label>Upload ảnh</label>
            <input type="file" name="image" class="form-control">
            <div>
                // Hiển thị hình ảnh
                <img src="data:image/jpeg;base64,<?php echo base64_encode($image); ?>" alt="Hình ảnh" class="img-thumbnail">
            </div>
        </form>
    </div>
</div>