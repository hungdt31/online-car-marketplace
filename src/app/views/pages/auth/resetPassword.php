<div class="container d-flex justify-content-center align-items-center p-3">
    <a href="/" style="position: absolute; top: 20px; left: 20px; z-index: 1000;">
        <img src="<?= htmlspecialchars(_WEB_ROOT) ?>/assets/static/images/carvan-logo.svg" alt="Carvan Logo" width="100">
    </a>
    <form action="/reset-password" method="POST" class="p-5" id="reset-password-form">
        <h2 class="text-center">Reset Password</h2>

        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger mt-3" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= htmlspecialchars($error) ?>
            </div>
            <div class="text-center mt-3">
                <a href="/auth" class="text-decoration-none">
                    <i class="fas fa-arrow-left me-1"></i> Back to Login
                </a>
            </div>
        <?php endif; ?>
        <?php if (isset($success) && $success): ?>
            <div class="alert alert-success mt-3" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= htmlspecialchars($success) ?>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-eye-slash"></i>
                    </span>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Enter new password" required minlength="8" />

                </div>
                <div class="form-text">Password must be at least 8 characters</div>
            </div>

            <div class="mb-4">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-eye-slash"></i>
                    </span>
                    <input type="password" name="confirm_password" id="confirm_password"
                        class="form-control" placeholder="Confirm new password" required />
                </div>
            </div>

            <input type="hidden" name="token" value="<?= $_GET['token'] ?>" />

            <div class="mt-4" id="reset-password-btn-group">
                <button type="submit" class="btn btn-primary w-100">
                    Submit
                </button>
                <div class="text-center mt-3">
                    <a href="/auth" class="text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i> Back to Login
                    </a>
                </div>
            </div>

            <div class="loader m-auto" id="loader-reset-password" style="display: none;"></div>
        <?php endif; ?>
    </form>
</div>
<style>
    * {
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    .container {
        min-height: 100vh;
        min-width: 100vw;
        background-image: url("<?= htmlspecialchars(_WEB_ROOT) . '/assets/static/images/bg-forgotpassword.jpeg' ?>");
    }

    .container::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1;
    }

    button {
        min-width: 200px;
    }

    .btn-primary {
        background-color: #146C94;
        border-color: #146C94;
    }

    .btn-primary:hover {
        background-color: #19A7CE;
        border-color: #19A7CE;
    }

    #reset-password-form {
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 2;
    }

    /* HTML: <div class="loader"></div> */
    .loader {
        width: 60px;
        aspect-ratio: 2;
        --_g: no-repeat radial-gradient(circle closest-side, #000 90%, #0000);
        background:
            var(--_g) 0% 50%,
            var(--_g) 50% 50%,
            var(--_g) 100% 50%;
        background-size: calc(100%/3) 50%;
        animation: l3 1s infinite linear;
    }

    @keyframes l3 {
        20% {
            background-position: 0% 0%, 50% 50%, 100% 50%
        }

        40% {
            background-position: 0% 100%, 50% 0%, 100% 50%
        }

        60% {
            background-position: 0% 50%, 50% 100%, 100% 0%
        }

        80% {
            background-position: 0% 50%, 50% 50%, 100% 100%
        }
    }
</style>

<script>
    // Toggle password visibility
    $(document).ready(function() {
        // Password toggle functionality
        $('.input-group-text').click(function() {
            const inputGroup = $(this).closest('.input-group');
            const passwordInput = inputGroup.find('input');
            const icon = $(this).find('i');

            // Toggle input type between password and text
            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);

            // Toggle icon between eye and eye-slash
            icon.toggleClass('fa-eye fa-eye-slash');
        });

        // Form submission code
        $('#reset-password-form').submit(function(e) {
            e.preventDefault();

            var form = $(this);
            let btn = document.getElementById('reset-password-btn-group');
            let loader = document.getElementById('loader-reset-password');
            loader.style.display = 'block';
            btn.hidden = true;

            setTimeout(() => {
                // Simulate a delay for the loader
                $.ajax({
                    type: 'POST',
                    url: '/reset-password',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (typeof toastr !== "undefined") {
                            response.success ?
                                toastr.success(response.message) :
                                toastr.warning(response.message);
                        } else {
                            alert(response.message);
                        }

                        if (response.success) {
                            setTimeout(() => {
                                window.location.href = '/auth';
                            }, 1500);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        if (typeof toastr !== "undefined") {
                            toastr.error('An error occurred. Please try again.');
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    },
                    complete: function() {
                        loader.style.display = 'none';
                        btn.hidden = false;
                    }
                });
            }, 1000);
        });
    });
</script>