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

<style>
/* CSS chung cho tất cả kích thước màn hình */
body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    height: 100vh;
    background: #f6f6f6;
    display: flex;
    flex-direction: column;
}

.alert {
    margin-bottom: 0 !important;
}

#container {
    background-color: #fff;
    position: relative;
    overflow: hidden;
    width: 100%;
    max-width: 100%;
    min-height: 100vh;
    margin: 0;
    border-radius: 0;
    box-shadow: none;
    flex: 1;
}

.form-container {
    position: absolute;
    top: 0;
    height: 100%;
    transition: all 0.6s ease-in-out;
}

.sign-in-container {
    left: 0;
    width: 50%;
    z-index: 2;
}

.sign-up-container {
    left: 0;
    width: 50%;
    opacity: 0;
    z-index: 1;
}

.form-container form {
    background-color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 50px;
    height: 100%;
    text-align: center;
}

.social-container {
    margin: 20px 0;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    flex-wrap: nowrap;
    gap: 10px;
    width: 100%;
}

.social-container a {
    border: 1px solid #DDDDDD;
    border-radius: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 45px;
    flex: 1;
    text-decoration: none;
    color: #333;
    margin: 0;
}

.social-container a:hover {
    background-color: #f0f0f0;
}

input {
    background-color: #eee;
    border: none;
    padding: 12px 15px;
    margin: 8px 0;
    width: 100%;
    border-radius: 5px;
}

.ghost-btn {
    border-radius: 20px;
    border: 1px solid #FFFFFF;
    background-color: transparent;
    color: #FFFFFF;
    font-size: 12px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: all 0.3s ease-in-out;
    cursor: pointer;
}

.ghost-btn:hover {
    background-color: rgba(255, 255, 255, 0.2);
}

.ghost-btn:active {
    transform: scale(0.95);
}

.ghost-btn:focus {
    outline: none;
}

.overlay-container {
    position: absolute;
    top: 0;
    left: 50%;
    width: 50%;
    height: 100%;
    overflow: hidden;
    transition: transform 0.6s ease-in-out;
    z-index: 100;
}

.overlay {
    /* background: #1e88e5;
    background: -webkit-linear-gradient(to right, #2196F3, #1e88e5);
    background: linear-gradient(to right, #2196F3, #1e88e5); */
    background-repeat: no-repeat;
    background-size: cover;
    background-position: 0 0;
    color: #FFFFFF;
    position: relative;
    left: -100%;
    height: 100%;
    width: 200%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
}

.overlay-panel {
    position: absolute;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 40px;
    text-align: center;
    top: 0;
    height: 100%;
    width: 50%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
}

.overlay-left {
    transform: translateX(-20%);
}

.overlay-right {
    right: 0;
    transform: translateX(0);
}

#container.right-panel-active .sign-in-container {
    transform: translateX(100%);
}

#container.right-panel-active .sign-up-container {
    transform: translateX(100%);
    opacity: 1;
    z-index: 5;
    animation: show 0.6s;
}

#container.right-panel-active .overlay-container {
    transform: translateX(-100%);
}

#container.right-panel-active .overlay {
    transform: translateX(50%);
}

#container.right-panel-active .overlay-left {
    transform: translateX(0);
}

#container.right-panel-active .overlay-right {
    transform: translateX(20%);
}

@-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.mobile-switcher {
    display: none;
    margin-top: 20px;
    width: 100%;
    text-align: center;
}

.mobile-switcher a {
    color: #1e88e5;
    text-decoration: none;
    font-weight: bold;
}

@keyframes show {
    0%, 49.99% {
        opacity: 0;
        z-index: 1;
    }
    
    50%, 100% {
        opacity: 1;
        z-index: 5;
    }
}

/* Responsive CSS cho điện thoại và tablet */
@media only screen and (max-width: 768px) {
    #container {
        width: 100%;
        margin: 0;
        min-height: 100vh;
        height: 100vh;
        box-shadow: none;
    }
    
    .overlay-container {
        display: none;
    }
    
    .form-container {
        position: relative;
        width: 100%;
        height: 100vh;
        transition: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .sign-in-container, .sign-up-container {
        width: 100%;
        transform: none !important;
        left: 0;
    }
    
    .sign-up-container {
        display: none;
    }
    
    .form-container form {
        padding: 30px 20px;
        height: auto;
        max-width: 400px;
        width: 100%;
    }
    
    .social-container {
        flex-direction: row;
        width: 100%;
        justify-content: space-between;
    }
    
    .social-container a {
        flex: 1;
        margin: 0;
    }
    
    #signin-group-btn, #signup-group-btn {
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 100%;
    }
    
    #signin-group-btn button, #signup-group-btn button {
        width: 100%;
        margin: 5px 0;
    }
    
    .mobile-switcher {
        display: block;
    }
    
    input, .password-container {
        width: 100%;
    }
    
    /* Button style cho mobile */
    .mobile-switcher a {
        padding: 8px 15px;
        border: 1px solid #1e88e5;
        border-radius: 20px;
        background-color: transparent;
        margin-top: 10px;
        display: inline-block;
    }
}
</style>

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
            <div class="mobile-switcher">
                <p>Already have an account? <a href="#" id="mobile-signin">Sign In</a></p>
            </div>
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
            <div class="mobile-switcher">
                <p>Don't have an account? <a href="#" id="mobile-signup">Sign Up</a></p>
            </div>
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
		// Mobile switcher functionality
		$('#mobile-signin').click(function(e) {
			e.preventDefault();
			$('.sign-up-container').hide();
			$('.sign-in-container').show();
		});
		
		$('#mobile-signup').click(function(e) {
			e.preventDefault();
			$('.sign-in-container').hide();
			$('.sign-up-container').show();
		});
		
		// Check screen size and apply mobile view if needed
		function checkMobileView() {
			if ($(window).width() <= 768) {
				// On mobile views
				$('#container').removeClass('right-panel-active');
				if ($('#container').hasClass('show-signup')) {
					$('.sign-in-container').hide();
					$('.sign-up-container').show();
				} else {
					$('.sign-up-container').hide();
					$('.sign-in-container').show();
				}
			} else {
				// On desktop views
				$('.sign-in-container, .sign-up-container').show();
				// Restore proper active state
				if ($('#container').hasClass('show-signup')) {
					$('#container').addClass('right-panel-active');
				} else {
					$('#container').removeClass('right-panel-active');
				}
			}
		}
		
		// Run on page load and window resize
		checkMobileView();
		$(window).resize(checkMobileView);
		
		// Form submissions
		$('#form-sign-in').submit(function(e) {
			e.preventDefault();
			var form = $(this);
			let btn = document.getElementById('signin-group-btn');
			let loader = document.getElementById('loader-sign-in');
			loader.style.display = 'block';
			btn.hidden = true;

			// Trì hoãn 1 giây trước khi gửi request
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
		container.classList.add("show-signup");
		
		// Check if we're on mobile, manually show/hide containers
		if (window.innerWidth <= 768) {
			document.querySelector('.sign-in-container').style.display = 'none';
			document.querySelector('.sign-up-container').style.display = 'block';
		}
	});

	signInButton.addEventListener('click', () => {
		container.classList.remove("right-panel-active");
		container.classList.remove("show-signup");
		
		// Check if we're on mobile, manually show/hide containers
		if (window.innerWidth <= 768) {
			document.querySelector('.sign-up-container').style.display = 'none';
			document.querySelector('.sign-in-container').style.display = 'block';
		}
	});

	togglePasswordButtons.forEach(toggleButton => {
		toggleButton.addEventListener('click', function() {
			// Find the password input that this button controls
			const passwordInput = document.querySelector(this.getAttribute('data-target'));

			if (passwordInput) {
				// Toggle the type attribute
				const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
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