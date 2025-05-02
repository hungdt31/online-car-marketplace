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