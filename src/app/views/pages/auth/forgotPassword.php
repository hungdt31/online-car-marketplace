<div class="container d-flex justify-content-center align-items-center p-3">
    <a href="/" style="position: absolute; top: 20px; left: 20px; z-index: 1000;">
        <img src="<?= htmlspecialchars(_WEB_ROOT) ?>/assets/static/images/carvan-logo.svg" alt="Carvan Logo" width="100">
    </a>
    <form action="/forgot-password" method="POST" class="p-5" id="forgot-password-form">
        <h1>Forgot Password</h1>
        <p> Enter your email address and we'll send you a link to reset your password.</p>
        <input type="email" name="email" placeholder="Email" required />
        <div class="mt-3" id="forgot-password-group-btn">
            <button type="submit" class="btn btn-primary">Send Reset Link</button>
            <div class="text-center mt-2">
                <a href="/auth">Back to Login</a>
            </div>
        </div>
        <div class="loader" id="loader-forgot-password" style="display: none;"></div>
    </form>
</div>
<style>
    .container {
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

    #forgot-password-form {
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 2;
    }
</style>

<script>
    // using ajax to submit form
	$(document).ready(function() {
		$('#forgot-password-form').submit(function(e) {
			e.preventDefault();
			var form = $(this);
			let btn = document.getElementById('forgot-password-group-btn');
			let loader = document.getElementById('loader-forgot-password');
			loader.style.display = 'block';
			btn.hidden = true;

            $.ajax({
                type: this.method,
                url: this.action,
                data: form.serialize(),
                dataType: 'json',
                success: function(response) {
                    if (typeof toastr !== "undefined") {
                        response.success
                        ? toastr.success(response.message)
                        : toastr.error(response.message);
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
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
		});
	});
</script>