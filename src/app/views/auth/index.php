<div class="container" id="container">
	<div class="form-container sign-up-container">
		<form id="form-sign-up" action="/auth/signup" method="post">
			<h1>Create Account</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
				<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
			</div>
			<span>or use your email for registration</span>
			<input type="text" placeholder="Username" name="username"/>
			<input type="email" placeholder="Email" name="email"/>
			<input type="password" placeholder="Password" name="password"/>
			<button type="submit" id="signUpBtn">Submit</button>
			<div class="loader" id="loader-sign-up" style="display: none;"></div>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form id="form-sign-in">
			<h1>Sign in</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
				<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
			</div>
			<span>or use your account</span>
			<input type="email" placeholder="Email" name="email"/>
			<input type="password" placeholder="Password" name="password"/>
			<a href="#">Forgot your password?</a>
			<button type="submit" id="signInBtn">Submit</button>
            <div class="loader" id="loader-sign-in" style="display: none;"></div>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<button class="ghost" id="signIn" type="submit">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Hello, Friend!</h1>
				<p>Enter your personal details and start journey with us</p>
				<button class="ghost" id="signUp">Sign Up</button>
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
            let btn = document.getElementById('signInBtn')
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
								window.location.href = '/admin/dashboard';
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
			let btn = document.getElementById('signUpBtn');
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
    });
</script>