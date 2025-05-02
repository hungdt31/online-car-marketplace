<div class="container d-flex justify-content-center align-items-center" id="forgot-password-container">
    <form action="/forgot-password" method="POST" class="p-3">
        <h1>Forgot Password</h1>
        <p> Enter your email address and we'll send you a link to reset your password.</p>
        <input type="email" name="email" placeholder="Email" required />
        <button type="submit" class="btn btn-primary mt-3">Send Reset Link</button>
        <div class="text-center mt-2">
            <a href="/auth">Back to Login</a>
        </div>
    </form>
</div>