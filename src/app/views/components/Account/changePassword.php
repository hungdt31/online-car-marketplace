<div class="change-password-container">
    <div class="card">
        <div class="card-header">
            <h3>Change Password</h3>
        </div>
        <div class="card-body">
            <form id="change-password-form">
                <div class="form-group mb-3">
                    <label for="current-password">Current Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="current-password" name="current_password" required>
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current-password">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-group mb-3">
                    <label for="new-password">New Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="new-password" name="new_password" required>
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new-password">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-strength mt-2">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <small class="text-muted">Password strength: <span class="strength-text">Weak</span></small>
                    </div>
                </div>
                
                <div class="form-group mb-3">
                    <label for="confirm-password">Confirm New Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirm-password">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-match-status mt-1">
                        <small class="text-muted">Passwords must match</small>
                    </div>
                </div>
                
                <div class="password-requirements mb-4">
                    <small class="text-muted">Password requirements:</small>
                    <ul class="list-unstyled small text-muted mt-1">
                        <li><i class="fa fa-check-circle text-muted requirement" data-requirement="length"></i> At least 8 characters</li>
                        <li><i class="fa fa-check-circle text-muted requirement" data-requirement="uppercase"></i> At least 1 uppercase letter</li>
                        <li><i class="fa fa-check-circle text-muted requirement" data-requirement="lowercase"></i> At least 1 lowercase letter</li>
                        <li><i class="fa fa-check-circle text-muted requirement" data-requirement="number"></i> At least 1 number</li>
                        <li><i class="fa fa-check-circle text-muted requirement" data-requirement="special"></i> At least 1 special character (!@#$%^&*)</li>
                    </ul>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary w-100" id="change-password-btn">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.change-password-container {
    max-width: 550px;
    margin: 0 auto;
}

.card {
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    border: none;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    padding: 1.25rem 1.5rem;
}

.card-header h3 {
    margin: 0;
    font-weight: 600;
    color: #3a3a3a;
    font-size: 1.25rem;
}

.card-body {
    padding: 1.75rem;
}

.form-group label {
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: #495057;
}

.input-group {
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    border-radius: 4px;
}

.form-control {
    padding: 0.6rem 0.75rem;
    border: 1px solid #e1e5eb;
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.toggle-password {
    cursor: pointer;
    border-color: #e1e5eb;
    background-color: #f8f9fa;
    color: #6c757d;
}

.toggle-password:hover {
    background-color: #e9ecef;
}

.requirement {
    margin-right: 5px;
}

.requirement.text-success {
    color: #28a745 !important;
}

.progress {
    border-radius: 2px;
    margin-bottom: 0.25rem;
    background-color: #e9ecef;
}

.progress-bar {
    transition: width 0.3s ease;
}

.password-strength .progress-bar.weak {
    background-color: #dc3545;
}

.password-strength .progress-bar.medium {
    background-color: #ffc107;
}

.password-strength .progress-bar.strong {
    background-color: #28a745;
}

.password-strength .progress-bar.very-strong {
    background-color: #20c997;
}

.password-match-status .text-success {
    color: #28a745 !important;
}

.password-match-status .text-danger {
    color: #dc3545 !important;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    padding: 0.6rem 1rem;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
}

.btn-primary:hover {
    background-color: #0069d9;
    border-color: #0062cc;
    transform: translateY(-1px);
}

.password-requirements ul li {
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
}

@media (max-width: 768px) {
    .change-password-container {
        max-width: 100%;
    }
    
    .card-body {
        padding: 1.25rem;
    }
}
</style>

<script>
$(document).ready(function() {
    // Show/hide password
    $('.toggle-password').click(function() {
        const targetId = $(this).data('target');
        const passwordInput = $('#' + targetId);
        const icon = $(this).find('i');
        
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
    
    // Check password strength
    $('#new-password').keyup(function() {
        const password = $(this).val();
        checkPasswordStrength(password);
        validatePasswords();
    });
    
    // Check password match
    $('#confirm-password').keyup(function() {
        validatePasswords();
    });
    
    // Check password strength
    function checkPasswordStrength(password) {
        let strength = 0;
        const progressBar = $('.password-strength .progress-bar');
        const strengthText = $('.strength-text');
        
        // Update requirement status
        $('.requirement[data-requirement="length"]').toggleClass('text-success', password.length >= 8);
        $('.requirement[data-requirement="uppercase"]').toggleClass('text-success', /[A-Z]/.test(password));
        $('.requirement[data-requirement="lowercase"]').toggleClass('text-success', /[a-z]/.test(password));
        $('.requirement[data-requirement="number"]').toggleClass('text-success', /[0-9]/.test(password));
        $('.requirement[data-requirement="special"]').toggleClass('text-success', /[!@#$%^&*]/.test(password));
        
        // Calculate strength score
        if (password.length >= 8) strength += 1;
        if (/[A-Z]/.test(password)) strength += 1;
        if (/[a-z]/.test(password)) strength += 1;
        if (/[0-9]/.test(password)) strength += 1;
        if (/[!@#$%^&*]/.test(password)) strength += 1;
        
        // Update progress bar and text
        progressBar.removeClass('weak medium strong very-strong');
        
        if (password.length === 0) {
            progressBar.css('width', '0%');
            strengthText.text('Weak');
        } else if (strength <= 2) {
            progressBar.addClass('weak').css('width', '25%');
            strengthText.text('Weak');
        } else if (strength === 3) {
            progressBar.addClass('medium').css('width', '50%');
            strengthText.text('Medium');
        } else if (strength === 4) {
            progressBar.addClass('strong').css('width', '75%');
            strengthText.text('Strong');
        } else {
            progressBar.addClass('very-strong').css('width', '100%');
            strengthText.text('Very Strong');
        }
    }
    
    // Validate password match
    function validatePasswords() {
        const newPassword = $('#new-password').val();
        const confirmPassword = $('#confirm-password').val();
        const matchStatus = $('.password-match-status small');
        
        if (confirmPassword.length === 0) {
            matchStatus.removeClass('text-success text-danger').addClass('text-muted').text('Passwords must match');
        } else if (newPassword === confirmPassword) {
            matchStatus.removeClass('text-muted text-danger').addClass('text-success').text('Passwords match!');
        } else {
            matchStatus.removeClass('text-muted text-success').addClass('text-danger').text('Passwords do not match!');
        }
    }
    
    // Handle password change form
    $('#change-password-form').submit(function(e) {
        e.preventDefault();
        
        const currentPassword = $('#current-password').val();
        const newPassword = $('#new-password').val();
        const confirmPassword = $('#confirm-password').val();
        
        // Check if new password and confirm password match
        if (newPassword !== confirmPassword) {
            toastr.error('Confirm password does not match new password!');
            return;
        }
        
        // Check password strength
        let strength = 0;
        if (newPassword.length >= 8) strength += 1;
        if (/[A-Z]/.test(newPassword)) strength += 1;
        if (/[a-z]/.test(newPassword)) strength += 1;
        if (/[0-9]/.test(newPassword)) strength += 1;
        if (/[!@#$%^&*]/.test(newPassword)) strength += 1;
        
        if (strength < 3) {
            toastr.error('New password is not strong enough!');
            return;
        }
        
        // Submit button
        const submitBtn = $('#change-password-btn');
        const originalBtnText = submitBtn.html();
        submitBtn.html('<i class="fa fa-spinner fa-spin me-2"></i>Processing...').prop('disabled', true);
        
        // Send AJAX request
        $.ajax({
            url: '<?php echo _WEB_ROOT; ?>/user/account/changePassword',
            type: 'POST',
            data: {
                current_password: currentPassword,
                new_password: newPassword,
                confirm_password: confirmPassword
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Reset form
                    $('#change-password-form')[0].reset();
                    
                    // Update UI
                    $('.requirement').removeClass('text-success');
                    $('.password-strength .progress-bar').css('width', '0%').removeClass('weak medium strong very-strong');
                    $('.strength-text').text('Weak');
                    $('.password-match-status small').removeClass('text-success text-danger').addClass('text-muted').text('Passwords must match');
                    
                    // Show success message
                    toastr.success(response.message || 'Password has been updated successfully!');
                } else {
                    // Show error message
                    toastr.error(response.message || 'Could not update password. Please try again!');
                }
            },
            error: function(xhr, status, error) {
                let errorMessage = 'An error occurred. Please try again!';
                
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }
                
                toastr.error(errorMessage);
            },
            complete: function() {
                // Restore submit button
                submitBtn.html(originalBtnText).prop('disabled', false);
            }
        });
    });
});
</script> 