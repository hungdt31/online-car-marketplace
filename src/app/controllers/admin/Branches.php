<?php

class Branches extends Controller
{
    public $branch_model;
    public $car_model;
    public $blog_model;
    public $user_model;
    public $jwt;

    public function __construct()
    {
        $this->branch_model = $this->model('BranchModel');
        $this->car_model = $this->model('CarModel');
        $this->blog_model = $this->model('BlogModel');
        $this->user_model = $this->model('UserModel');
        $this->jwt = new JwtAuth();
    }

    public function index()
    {
        $branches = $this->branch_model->findAll();
        $payload = SessionFactory::createSession('account')->getProfile();
        $this->renderAdmin([
            'page_title' => 'Branch Management',
            'view' => 'protected/branchManager',
            'content' => [
                'title' => 'Branch Management',
                'payload' => $payload,
                'branches' => $branches
            ]
        ]);
    }

    public function addBranch()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'address' => $_POST['address'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'email' => $_POST['email'] ?? '',
            ];

            if (empty($data['name']) || empty($data['address']) || empty($data['phone']) || empty($data['email'])) {
                echo json_encode(['success' => false, 'message' => 'All fields are required']);
                return;
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'message' => 'Invalid email format']);
                return;
            }

            if (!preg_match('/^[0-9]{10,11}$/', $data['phone'])) {
                echo json_encode(['success' => false, 'message' => 'Phone number must be 10-11 digits']);
                return;
            }

            $result = $this->branch_model->createOne($data);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Branch added successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add branch']);
            }
        }
    }

    public function getBranch($id)
    {
        $branch = $this->branch_model->findOne($id);
        
        if (!$branch) {
            echo '<div class="modal-body"><p class="text-danger">Branch not found</p></div>';
            return;
        }

        if (isset($_GET['getToUpdate']) && $_GET['getToUpdate']) {
            ?>
            <div class="modal-header">
              <h5 class="modal-title">Edit Branch</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="edit_name" class="form-label">Branch Name</label>
                <input type="text" class="form-control" id="edit_name" name="name" 
                       value="<?= htmlspecialchars($branch['name']) ?>" required>
              </div>

              <div class="mb-3">
                <label for="edit_address" class="form-label">Address</label>
                <input type="text" class="form-control" id="edit_address" name="address" 
                       value="<?= htmlspecialchars($branch['address']) ?>" required>
              </div>

              <div class="mb-3">
                <label for="edit_phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="edit_phone" name="phone" 
                       value="<?= htmlspecialchars($branch['phone']) ?>" required>
              </div>

              <div class="mb-3">
                <label for="edit_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="edit_email" name="email" 
                       value="<?= htmlspecialchars($branch['email']) ?>" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" data-id="<?= htmlspecialchars($branch['id']) ?>">Update</button>
            </div>
            <?php
        } else {
            ?>
            <div class="modal-header">
              <h5 class="modal-title">Branch Details</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="card border-0">
                <div class="card-body p-3">
                  <h3 class="text-primary mb-4"><?= htmlspecialchars($branch['name']) ?></h3>
                  
                  <div class="mb-3">
                    <h6 class="text-muted text-uppercase small fw-bold">Address</h6>
                    <p class="mb-0">
                      <i class="fas fa-map-marker-alt text-danger me-2"></i>
                      <?= htmlspecialchars($branch['address']) ?>
                    </p>
                  </div>
                  
                  <div class="mb-3">
                    <h6 class="text-muted text-uppercase small fw-bold">Contact Information</h6>
                    <p class="mb-1">
                      <i class="fas fa-phone text-primary me-2"></i>
                      <?= htmlspecialchars($branch['phone']) ?>
                    </p>
                    <p class="mb-0">
                      <i class="fas fa-envelope text-primary me-2"></i>
                      <?= htmlspecialchars($branch['email']) ?>
                    </p>
                  </div>
                  
                  <div class="mb-0">
                    <h6 class="text-muted text-uppercase small fw-bold">Created</h6>
                    <p class="mb-1 text-muted small">
                      <i class="fas fa-calendar"></i> <?= date('d/m/Y H:i:s', strtotime($branch['created_at'])) ?>
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <?php
        }
    }
    
    public function editBranch($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'address' => $_POST['address'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
            ];
            
            $result = $this->branch_model->updateOne($id, $data);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Branch updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update branch']);
            }
        }
    }
    
    public function deleteBranch($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->branch_model->deleteOne($id);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Branch deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete branch']);
            }
        }
    }
}