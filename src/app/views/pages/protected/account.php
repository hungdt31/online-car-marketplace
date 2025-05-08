<?php
$currentTab = $_GET['tab'] ?? 'profile';
?>
<div class="profile-container">
    <!-- Top Navigation Area -->
    <div class="top-nav">
        <div class="user-profile">
            <div class="avatar-container">
                <?php if (!empty($profile['avatar'])): ?>
                    <img src="<?= htmlspecialchars($profile['avatar'], ENT_QUOTES, 'UTF-8') ?>" alt="Avatar" class="avatar">
                <?php else: ?>
                    <div class="avatar">
                        <i class="fa fa-user-circle"></i>
                    </div>
                <?php endif; ?>
                <div class="avatar-overlay" id="changeAvatarBtn">
                    <i class="fa fa-camera"></i>
                    <span>Change</span>
                </div>
            </div>
            <div class="user-info">
                <h4><?= htmlspecialchars($profile['username'], ENT_QUOTES, 'UTF-8') ?></h4>
                <p><?= htmlspecialchars($profile['email'], ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        </div>

        <div class="nav-links">
            <a href="?tab=profile" class="nav-link <?= $currentTab === 'profile' ? 'active' : '' ?>">
                <i class="fa fa-user"></i>
                Personal Information
            </a>
            <a href="?tab=appointments" class="nav-link <?= $currentTab === 'appointments' ? 'active' : '' ?>">
                <i class="fa fa-calendar"></i>
                Appointments
            </a>
            <a href="?tab=change-password" class="nav-link <?= $currentTab === 'change-password' ? 'active' : '' ?>">
                <i class="fa fa-lock"></i>
                Change Password
            </a>
            <button class="btn-danger btn" id="logout-btn">
                <i class="fa fa-sign-out"></i>
                Log out
            </button>
        </div>
    </div>

    <!-- Content Area -->
    <?php if ($currentTab === 'profile'): ?>
        <?php
            RenderSystem::renderOne('components', 'Account/profile', [
                'profile' => $profile
            ]);
        ?>
    <?php elseif ($currentTab === 'appointments'): ?>
        <?php
            RenderSystem::renderOne('components', 'Account/appointments', [
                'appointments' => $appointments,
            ]);
        ?>
    <?php elseif ($currentTab === 'change-password'): ?>
        <?php
            RenderSystem::renderOne('components', 'Account/changePassword', [
                'profile' => $profile
            ]);
        ?>
    <?php endif; ?>
</div>

<!-- Avatar Upload Modal -->
<div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="avatarModalLabel">Change Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="avatar-preview-container">
                        <div id="avatarPreview">
                            <?php if (!empty($profile['avatar'])): ?>
                                <img src="<?= htmlspecialchars($profile['avatar'], ENT_QUOTES, 'UTF-8') ?>" alt="Current Avatar">
                            <?php else: ?>
                                <div class="default-avatar">
                                    <i class="fa fa-user-circle"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <form id="avatarUploadForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="avatarFile" class="form-label">Select a new profile picture</label>
                        <input class="form-control" type="file" id="avatarFile" name="avatar" accept="image/*">
                        <div class="form-text">Recommended size: 500x500 pixels. Max file size: 2MB.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveAvatarBtn" disabled>Save Changes</button>
            </div>
        </div>
    </div>
</div>

<style>
    <?php 
        RenderSystem::renderOne('assets', 'static/css/account/index.css');
    ?>

    /* Avatar styling */
    .avatar-container {
        position: relative;
        margin-right: 15px;
        cursor: pointer;
    }

    .avatar, .avatar-container img.avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #6c757d;
        object-fit: cover;
    }

    .avatar-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .avatar-container:hover .avatar-overlay {
        opacity: 1;
    }

    .avatar-overlay i {
        font-size: 20px;
        margin-bottom: 2px;
    }

    .avatar-overlay span {
        font-size: 12px;
    }

    /* Avatar preview in modal */
    .avatar-preview-container {
        width: 150px;
        height: 150px;
        margin: 0 auto;
        overflow: hidden;
        border-radius: 50%;
        border: 3px solid #e9ecef;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    #avatarPreview {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }

    #avatarPreview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .default-avatar {
        font-size: 80px;
        color: #adb5bd;
    }
</style>

<script>
    $(document).ready(function() {
        // Handle logout
        $('#logout-btn').click(function() {
            $.ajax({
                type: 'POST',
                url: '/auth/logout',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.href = '/auth';
                        }, 2000);
                    }
                }
            });
        });

        // Open avatar modal
        $('#changeAvatarBtn').click(function() {
            $('#avatarModal').modal('show');
        });

        // Handle file input change
        $('#avatarFile').change(function() {
            const file = this.files[0];
            
            // Validate file type and size
            if (file) {
                if (!file.type.match('image.*')) {
                    toastr.error('Please select an image file');
                    this.value = '';
                    $('#saveAvatarBtn').prop('disabled', true);
                    return;
                }
                
                if (file.size > 2 * 1024 * 1024) { // 2MB
                    toastr.error('File size should not exceed 2MB');
                    this.value = '';
                    $('#saveAvatarBtn').prop('disabled', true);
                    return;
                }
                
                // Preview the selected image
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#avatarPreview').html('<img src="' + e.target.result + '" alt="Avatar Preview">');
                    $('#saveAvatarBtn').prop('disabled', false);
                };
                reader.readAsDataURL(file);
            } else {
                $('#saveAvatarBtn').prop('disabled', true);
            }
        });

        // Handle avatar upload
        $('#saveAvatarBtn').click(function() {
            const file = $('#avatarFile')[0].files[0];
            
            if (!file) {
                toastr.error('Please select an image file');
                return;
            }
            
            // Create FormData and append file
            const formData = new FormData();
            formData.append('avatar', file);
            
            // Show loading state
            $(this).html('<i class="fa fa-spinner fa-spin me-2"></i>Uploading...').prop('disabled', true);
            
            // Send AJAX request
            $.ajax({
                url: '<?php echo _WEB_ROOT; ?>/user/account/uploadAvatar',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Update avatar in UI
                        $('.avatar-container').html('<img src="' + response.avatar_url + '" alt="Avatar" class="avatar"><div class="avatar-overlay" id="changeAvatarBtn"><i class="fa fa-camera"></i><span>Change</span></div>');
                        
                        // Reattach click event
                        $('#changeAvatarBtn').click(function() {
                            $('#avatarModal').modal('show');
                        });
                        
                        // Show success message
                        toastr.success(response.message || 'Avatar updated successfully!');
                        
                        // Close modal
                        $('#avatarModal').modal('hide');
                    } else {
                        // Show error message
                        toastr.error(response.message || 'Failed to update avatar');
                    }
                },
                error: function() {
                    toastr.error('An error occurred. Please try again.');
                },
                complete: function() {
                    // Reset button state
                    $('#saveAvatarBtn').html('Save Changes').prop('disabled', false);
                }
            });
        });
    });
</script>