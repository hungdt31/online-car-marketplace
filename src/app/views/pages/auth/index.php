<?php
// đăng nhập với google
$instance = new GoogleClient();
$scope = [
	"email",
	"profile"
];

$instance->addScope($scope);

$client = $instance->getClient();
$ggUrl = $client->createAuthUrl();

// đăng nhập với facebook
$fb = new FacebookClient();
$fbUrl = $fb->getLoginUrl();

// đăng nhập với github
$github = new GitHubClient();
$githubUrl = $github->getLoginUrl();

// thông báo đăng nhập
global $oauth_notice;
$notice = null;
if (isset($_GET['code'])) {
	foreach ($oauth_notice as $key => $value) {
		if ($_GET['code'] == $key) {
			$notice = $value;
			break;
		}
	}
}
?>
<?php if ($notice): ?>
	<div class="alert alert-<?php echo $notice['status'] ?> alert-dismissible mb-0" role="alert">
		<div>
			<?php echo $notice['message'] ?>
		</div>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
<?php endif; ?>

<div class="container" id="container">
	<div class="form-container sign-up-container">
		<form id="form-sign-up" action="/auth/signup" method="post">
			<h1>Create an Account</h1>
			<div class="social-container">
				<a href="<?= isset($ggUrl) ? htmlspecialchars($ggUrl) : '#' ?>" class="social" id="gg-sign-up">
					<img src="<?php echo _WEB_ROOT ?>/assets/static/images/social/google.png" alt="Google" style="width: 20px; height: 20px; margin-right: 5px;" />
					<strong>Google</strong>
				</a>
				<a href="<?= isset($githubUrl) ? htmlspecialchars($githubUrl) : '#' ?>" class="social" id="github-sign-up">
				<img src="<?php echo _WEB_ROOT ?>/assets/static/images/social/github.png" alt="Github" style="width: 20px; height: 20px; margin-right: 5px;" />
					<strong>GitHub</strong>
				</a>
				<!-- <a href="#" class="social">
					<img src="<?php echo _WEB_ROOT ?>/assets/static/images/social/linkedin.png" alt="Facebook" style="width: 20px; height: 20px; margin-right: 5px;" />
					<strong>Linkedin </strong>
				</a> -->
			</div>
			<span>or use your email for registration</span>
			<input type="text" placeholder="Username" name="username" />
			<input type="email" placeholder="Email" name="email" />
			<div class="password-container" style="position: relative; width: 100%;">
				<input type="password" placeholder="Password" name="password" id="password-signin" />
				<i class="fas fa-eye-slash toggle-password"
					style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #777;"
					data-toggle="password"
					data-target="#password-signin"></i>
			</div>
			<div class="mt-3" id="signup-group-btn">
				<button type="button" id="clearSignUpBtn" class="btn btn-danger" style="min-width: 150px;">Clear</button>
				<button type="submit" id="signUpBtn" class="btn btn-primary" style="min-width: 150px;">Submit</button>
			</div>
			<div class="loader" id="loader-sign-up" style="display: none;"></div>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form id="form-sign-in">
			<h1>Sign in</h1>
			<div class="social-container">
				<!-- <a href="<?= isset($fbUrl) ? htmlspecialchars($fbUrl) : '#' ?>" class="social">
					<i class="fab fa-facebook-f"></i>
				</a> -->
				<a href="<?= isset($ggUrl) ? htmlspecialchars($ggUrl) : '#' ?>" class="social" id="gg-sign-in">
					<img src="<?php echo _WEB_ROOT ?>/assets/static/images/social/google.png" alt="Google" style="width: 20px; height: 20px; margin-right: 5px;" />
					<strong>Google</strong>
				</a>
				<a href="<?= isset($githubUrl) ? htmlspecialchars($githubUrl) : '#' ?>" class="social" id="github-sign-in">
				<img src="<?php echo _WEB_ROOT ?>/assets/static/images/social/github.png" alt="Github" style="width: 20px; height: 20px; margin-right: 5px;" />
					<strong>GitHub</strong>
				</a>
				<!-- <a href="#" class="social">
					<img src="<?php echo _WEB_ROOT ?>/assets/static/images/social/linkedin.png" alt="Facebook" style="width: 20px; height: 20px; margin-right: 5px;" />
					<strong>Linkedin </strong>
				</a> -->
			</div>
			<span>or use your account</span>
			<input type="email" placeholder="Email" name="email" />
			<div class="password-container" style="position: relative; width: 100%;">
				<input type="password" placeholder="Password" name="password" id="password-signup" />
				<i class="fas fa-eye-slash toggle-password"
					style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #777;"
					data-toggle="password"
					data-target="#password-signup"></i>
			</div>
			<a href="/forgot-password">Forgot your password?</a>
			<div id="signin-group-btn">
				<button type="button" id="clearSignInBtn" class="btn btn-danger" style="min-width: 150px;">Clear</button>
				<button type="submit" id="signInBtn" class="btn btn-primary" style="min-width: 150px;">Submit</button>
			</div>

			<div class="loader" id="loader-sign-in" style="display: none;"></div>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<a href="/" style="position: absolute; top: 20px; left: 20px; z-index: 1000;">
					<img src="<?= htmlspecialchars(_WEB_ROOT) ?>/assets/static/images/carvan-logo.svg" alt="Carvan Logo" width="100">
				</a>
				<h1>Welcome Back!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<button class="ghost-btn" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<a href="/" style="position: absolute; top: 20px; right: 20px; z-index: 1000;">
					<img src="<?= htmlspecialchars(_WEB_ROOT) ?>/assets/static/images/carvan-logo.svg" alt="Carvan Logo" width="100">
				</a>
				<h1>Hello, Friend!</h1>
				<p>Enter your personal details and start journey with us</p>
				<button class="ghost-btn" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
</div>
<script>
	// using ajax to submit form
	$(document).ready(function() {
		$('#form-sign-in').submit(function(e) {
			e.preventDefault();
			var form = $(this);
			let btn = document.getElementById('signin-group-btn');
			let loader = document.getElementById('loader-sign-in');
			loader.style.display = 'block';
			btn.hidden = true;

			// Trì hoãn 1.5 giây trước khi gửi request
			setTimeout(function() {
				$.ajax({
					type: 'POST',
					url: '/auth/signin',
					data: form.serialize(),
					dataType: 'json',
					success: function(response) {
						if (response.success) {
							toastr.success(response.message);
							setTimeout(() => {
								response.role === 'admin' ? window.location.href = '/admin/dashboard' : window.location.href = '/account';
							}, 1000);
						} else {
							toastr.warning(response.message);
						}
					},
					complete: function() {
						loader.style.display = 'none';
						btn.hidden = false;
					}
				});
			}, 1000);
		});
		$('#form-sign-up').submit(function(e) {
			e.preventDefault();
			var form = $(this);
			let btn = document.getElementById('signup-group-btn');
			let loader = document.getElementById('loader-sign-up');

			// Hiển thị loader và ẩn nút đăng ký ngay lập tức
			loader.style.display = 'block';
			btn.hidden = true;

			// Trì hoãn 1.5 giây trước khi gửi request
			setTimeout(function() {
				$.ajax({
					type: 'POST',
					url: '/auth/signup',
					data: form.serialize(),
					dataType: 'json',
					success: function(response) {
						if (response.success) {
							toastr.success(response.message);
						} else {
							toastr.warning(response.message);
						}
					},
					complete: function() {
						loader.style.display = 'none';
						btn.hidden = false;
					}
				});
			}, 1500);
		});

		// Handle clear button for sign-in form
		$('#form-sign-in .btn-danger').click(function(e) {
			e.preventDefault(); // Prevent form submission
			$('#form-sign-in input').val(''); // Clear all inputs in the sign-in form
			toastr.info('Sign in form cleared');
		});

		// Handle clear button for sign-up form
		$('#form-sign-up .btn-danger').click(function(e) {
			e.preventDefault(); // Prevent form submission
			$('#form-sign-up input').val(''); // Clear all inputs in the sign-up form
			toastr.info('Sign up form cleared');
		});
	});
	document.addEventListener("DOMContentLoaded", function() {
		document.getElementById("gg-sign-up").addEventListener("click", function() {
			document.cookie = "authType=signup"; // Lưu trạng thái đăng ký
		});

		document.getElementById("gg-sign-in").addEventListener("click", function() {
			document.cookie = "authType=signin"; // Lưu trạng thái đăng nhập
		});

		document.getElementById("github-sign-up").addEventListener("click", function() {
			document.cookie = "authType=signup"; // Lưu trạng thái đăng ký
		});

		document.getElementById("github-sign-in").addEventListener("click", function() {
			document.cookie = "authType=signin"; // Lưu trạng thái đăng nhập
		});
	});

	const signUpButton = document.getElementById('signUp');
	const signInButton = document.getElementById('signIn');
	const container = document.getElementById('container');
	const togglePasswordButtons = document.querySelectorAll('.toggle-password');

	signUpButton.addEventListener('click', () => {
		container.classList.add("right-panel-active");
	});

	signInButton.addEventListener('click', () => {
		container.classList.remove("right-panel-active");
	});

	togglePasswordButtons.forEach(toggleButton => {
		toggleButton.addEventListener('click', function() {
			// Find the password input that this button controls
			const passwordInput = document.querySelector(this.getAttribute('data-target'));

			if (passwordInput) {
				// Toggle the type attribute
				const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
				console.log('Toggling password input type to:', type);
				passwordInput.setAttribute('type', type);

				// Toggle the eye icon
				if (type === 'password') {
					this.classList.add('fa-eye-slash');
					this.classList.remove('fa-eye');
				} else {
					this.classList.add('fa-eye');
					this.classList.remove('fa-eye-slash');
				}
			}
		});
	});
</script>