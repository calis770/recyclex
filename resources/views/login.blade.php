<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecycleX - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary-green: #c3f0c8;
            --dark-green: #2e7d32;
            --button-color: #b5933a;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .header {
            background-color: var(--primary-green);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .header-logo img {
            height: 30px;
        }
        
        .header-logo span {
            color: var(--dark-green);
            font-weight: 600;
            font-size: 18px;
        }
        
        .header-links {
            display: flex;
            gap: 15px;
        }
        
        .header-links a {
            color: var(--dark-green);
            text-decoration: none;
            font-weight: 500;
        }
        
        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }
        
        .content-wrapper {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background-color: white;
            position: relative;
        }
        
        .logo-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }
        
        .logo-img {
            width: 180px;
            height: 180px;
            margin-bottom: 20px;
        }
        
        .tagline {
            color: var(--dark-green);
            text-align: center;
            font-weight: 600;
            line-height: 1.5;
        }
        
        .login-section {
            flex: 1;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            z-index: 10;
            margin-right: 30px;
            transform: translateX(30px);
            max-width: 400px;
        }
        
        .login-heading {
            color: var(--dark-green);
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .forgot-link {
            text-align: right;
            font-size: 12px;
            margin-top: 5px;
        }
        
        .forgot-link a {
            color: #666;
            text-decoration: none;
        }
        
        .login-button {
            width: 100%;
            padding: 12px;
            background-color: var(--button-color);
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            text-transform: uppercase;
            margin: 20px 0;
        }
        
        .login-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        .error-message {
            color: #d32f2f;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }
        
        .divider:before, .divider:after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #ddd;
        }
        
        .divider-text {
            padding: 0 15px;
            color: #999;
            font-size: 14px;
        }
        
        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        
        .social-button img {
            width: 20px;
            height: 20px;
        }
        
        .signup-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        
        .signup-link {
            font-weight: 600;  
            color: var(--dark-green); 
            text-decoration: none; 
        }   

        .signup-link:hover {
            text-decoration: underline; 
        }
        
        .footer {
            background-color: var(--primary-green);
            padding: 20px;
            text-align: center;
        }
        
        .auth-message {
            background-color: #f0f8ff;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            display: none;
        }
        
        .auth-message p {
            margin: 0;
            font-size: 14px;
        }
        
        .auth-message .auth-controls {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        
        .auth-message button {
            padding: 5px 10px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 12px;
        }
        
        .continue-btn {
            background-color: var(--dark-green);
            color: white;
        }
        
        .logout-btn {
            background-color: #f5f5f5;
            color: #333;
        }
        
        @media (max-width: 768px) {
            .content-wrapper {
                flex-direction: column;
                align-items: center;
            }
            
            .login-section {
                transform: none;
                margin-right: 0;
                margin-top: 30px;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-logo">
            <img src="{{ asset('Assets/logo.png') }}" alt="RecycleX Logo">
            <span>RecycleX</span>
        </div>
        <div class="header-links">
            <a href="{{ route('signup') }}" id="signuplink">Sign Up</a>
            <a href="#" id="logoutLink" style="display: none;">Log Out</a>
        </div>
    </div>
    
    <div class="main-container">
        <div class="content-wrapper">
            <div class="logo-section">
                <img src="{{ asset('Assets/logo.png') }}" alt="RecycleX Logo" class="logo-img">
                <div class="tagline">
                    <p>Dari UMKM untuk Bumi,</p>
                    <p>Belanja Ramah Lingkungan</p>
                </div>
            </div>
            
            <div class="login-section">
                <div class="auth-message" id="authMessage">
                    <p>You are already logged in as <span id="loggedInUser"></span></p>
                    <div class="auth-controls">
                        <button class="continue-btn" id="continueToHome">Continue to Homepage</button>
                        <button class="logout-btn" id="logoutBtn">Logout</button>
                    </div>
                </div>
                
                <h2 class="login-heading">Log In</h2>
                
                <form id="loginForm">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                        <div class="error-message" id="emailError"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        <div class="error-message" id="passwordError"></div>
                        <div class="forgot-link">
                            <a href="#">Forgot Password?</a>
                        </div>
                    </div>
                    
                    <button type="submit" class="login-button" id="loginButton">Continue</button>
                    <div class="error-message" id="generalError"></div>
                    
                    <div class="divider">
                        <span class="divider-text">OR</span>
                    </div>
                    
                    <div class="social-login">
                        <a href="#" class="social-button" id="googleLogin">
                            <img src="{{ asset('Assets/logo google.jpg') }}" alt="Google">
                        </a>
                        <a href="#" class="social-button" id="facebookLogin">
                            <img src="{{ asset('Assets/logo facebook.jpg') }}" alt="Facebook">
                        </a>
                    </div>
                    
                    <div class="signup-text">
                        Don't have an account? <a href="{{ route('signup') }}" class="signup-link">Sign Up Now</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="footer"></div>

    <script>
        // Authentication & Login functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Check if user is already logged in, but don't auto-redirect
            checkAuthStatus(false);
            
            // Setup login form event listener
            const loginForm = document.getElementById('loginForm');
            loginForm.addEventListener('submit', handleLoginSubmit);
            
            // Setup social login buttons
            document.getElementById('googleLogin').addEventListener('click', function(e) {
                e.preventDefault();
                handleSocialLogin('google');
            });
            
            document.getElementById('facebookLogin').addEventListener('click', function(e) {
                e.preventDefault();
                handleSocialLogin('facebook');
            });
            
            // Setup logout functionality
            document.getElementById('logoutBtn').addEventListener('click', function(e) {
                e.preventDefault();
                logout();
            });
            
            document.getElementById('logoutLink').addEventListener('click', function(e) {
                e.preventDefault();
                logout();
            });
            
            // Setup continue to homepage button
            document.getElementById('continueToHome').addEventListener('click', function(e) {
                e.preventDefault();
                redirectToHomepage();
            });
        });
        
        // Check if user is already authenticated, don't auto-redirect
        function checkAuthStatus(autoRedirect = false) {
            const authToken = localStorage.getItem('recyclexAuthToken');
            const userData = JSON.parse(localStorage.getItem('recyclexUserData') || '{}');
            
            if (authToken && userData.name) {
                // Update the UI to show the logged-in state
                const authMessage = document.getElementById('authMessage');
                const loggedInUser = document.getElementById('loggedInUser');
                const logoutLink = document.getElementById('logoutLink');
                const loginLink = document.getElementById('loginLink');
                
                loggedInUser.textContent = userData.name || userData.email;
                authMessage.style.display = 'block';
                logoutLink.style.display = 'inline-block';
                loginLink.style.display = 'none';
                
                if (autoRedirect) {
                    // Only redirect if explicitly told to do so
                    redirectToHomepage();
                }
            }
        }
        
        // Handle login form submission
        function handleLoginSubmit(e) {
            e.preventDefault();
            
            // Reset error messages
            resetErrors();
            
            // Get form values
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            
            // Validate inputs
            let isValid = true;
            
            if (!email) {
                showError('emailError', 'Please enter your email');
                isValid = false;
            } else if (!isValidEmail(email)) {
                showError('emailError', 'Please enter a valid email address');
                isValid = false;
            }
            
            if (!password) {
                showError('passwordError', 'Please enter your password');
                isValid = false;
            }
            
            if (!isValid) {
                return false;
            }
            
            // Show loading state
            const loginButton = document.getElementById('loginButton');
            loginButton.disabled = true;
            loginButton.textContent = 'Logging in...';
            
            // In a real application, you would send the credentials to your server
            // Here we'll simulate a successful login
            simulateServerLogin(email, password);
        }
        
        // Simulate server login (replace with actual API call in production)
        function simulateServerLogin(email, password) {
            // Simulate network delay
            setTimeout(function() {
                // For demo purposes, we'll simulate success
                // In a real app, validate credentials on the server
                
                // Create mock user data
                const userData = {
                    name: "Calista Zahra", 
                    email: email,
                    id: "user123"
                };
                
                // Store authentication data
                storeAuthData({
                    token: "sample-auth-token-" + Math.random(),
                    userData: userData
                });
                
                // Show success message and then redirect
                const loginButton = document.getElementById('loginButton');
                loginButton.textContent = 'Success!';
                
                // Update UI to show logged in state
                checkAuthStatus(true);
                
            }, 1000); // 1 second delay to simulate server request
        }
        
        // Handle social login (Google, Facebook)
        function handleSocialLogin(provider) {
            
            document.getElementById('loginButton').textContent = `Logging in with ${provider}...`;
            
            setTimeout(function() {
                const userData = {
                    name: "Calista Zahra", 
                    email: `user@${provider}.com`,
                    id: `${provider}123`
                };
                
                storeAuthData({
                    token: `${provider}-auth-token-` + Math.random(),
                    userData: userData
                });
                
                // Update UI to show logged in state
                checkAuthStatus(true);
            }, 1000);
        }
        
        // Store authentication data
        function storeAuthData(authData) {
            localStorage.setItem('recyclexAuthToken', authData.token);
            localStorage.setItem('recyclexUserData', JSON.stringify(authData.userData));
        }
        
        // Logout functionality
        function logout() {
            localStorage.removeItem('recyclexAuthToken');
            localStorage.removeItem('recyclexUserData');
            
            // Update UI
            const authMessage = document.getElementById('authMessage');
            const logoutLink = document.getElementById('logoutLink');
            const loginLink = document.getElementById('loginLink');
            const loginButton = document.getElementById('loginButton');
            
            authMessage.style.display = 'none';
            logoutLink.style.display = 'none';
            loginLink.style.display = 'inline-block';
            loginButton.disabled = false;
            loginButton.textContent = 'Continue';
            
            // Reset form
            document.getElementById('loginForm').reset();
        }
        
        // Redirect to homepage
        function redirectToHomepage() {
            // Using the homepage URL path - adjust based on your routing system
            window.location.href = '/homepage';
        }
        
        // Utility functions
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
        
        function showError(elementId, message) {
            const errorElement = document.getElementById(elementId);
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
        
        function resetErrors() {
            const errorElements = document.querySelectorAll('.error-message');
            errorElements.forEach(element => {
                element.textContent = '';
                element.style.display = 'none';
            });
        }
    </script>
</body>
</html>