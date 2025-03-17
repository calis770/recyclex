<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecycleX - Sign Up</title>
    <!-- Font Poppins -->
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
        
        /* Header */
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
        
        .login-link {
            font-weight: 600;  
            color: var(--dark-green); 
            text-decoration: none; 
        }   

        .login-link:hover {
            text-decoration: underline; 
        }
        
        .header-links a {
            color: var(--dark-green);
            text-decoration: none;
            font-weight: 500;
        }
        
        /* Main Container */
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
        
        /* Logo Section */
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
        
        /* Sign Up Section */
        .signup-section {
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
        
        .signup-heading {
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
        
        .signup-button {
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
        
        .signup-button:disabled {
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
            color: var(--dark-green);
            font-weight: 600;
            text-decoration: none;
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
        
        /* Additional step form fields */
        .step-container {
            display: none;
        }
        
        .step-container.active {
            display: block;
        }
        
        .next-btn, .prev-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .next-btn {
            background-color: var(--button-color);
            color: white;
        }
        
        .prev-btn {
            background-color: #f5f5f5;
            color: #333;
            margin-right: 10px;
        }
        
        .steps-nav {
            display: flex;
            justify-content: space-between;
        }
        
        /* Footer */
        .footer {
            background-color: var(--primary-green);
            padding: 20px;
            text-align: center;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .content-wrapper {
                flex-direction: column;
                align-items: center;
            }
            
            .signup-section {
                transform: none;
                margin-right: 0;
                margin-top: 30px;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-logo">
            <img src="{{ asset('Assets/logo.png') }}" alt="RecycleX Logo">
            <span>RecycleX</span>
        </div>
        <div class="header-links">
            <a href="{{ route('login') }}" id="loginLink">Log In</a>
            <a href="#" id="logoutLink" style="display: none;">Log Out</a>
        </div>
    </div>
    
    <!-- Main Container -->
    <div class="main-container">
        <div class="content-wrapper">
            <!-- Logo & Tagline -->
            <div class="logo-section">
                <img src="{{ asset('Assets/logo.png') }}" alt="RecycleX Logo" class="logo-img">
                <div class="tagline">
                    <p>Dari UMKM untuk Bumi,</p>
                    <p>Belanja Ramah Lingkungan</p>
                </div>
            </div>
            
            <!-- Sign Up Form -->
            <div class="signup-section">
                <div class="auth-message" id="authMessage">
                    <p>You are already registered as <span id="loggedInUser"></span></p>
                    <div class="auth-controls">
                        <button class="continue-btn" id="continueToHome">Continue to Homepage</button>
                        <button class="logout-btn" id="logoutBtn">Logout</button>
                    </div>
                </div>
                
                <h2 class="signup-heading">Sign Up</h2>
                
                <form id="signupForm">
                    <!-- Step 1: Phone -->
                    <div class="step-container active" id="step1">
                        <div class="form-group">
                            <label for="phone">No. Telepon</label>
                            <input type="text" id="phone" name="phone" required>
                            <div class="error-message" id="phoneError"></div>
                        </div>
                        
                        <button type="button" class="signup-button" id="step1Button">Continue</button>
                    </div>
                    
                    <!-- Step 2: Additional Info -->
                    <div class="step-container" id="step2">
                        <div class="form-group">
                            <label for="fullname">Nama Lengkap</label>
                            <input type="text" id="fullname" name="fullname" required>
                            <div class="error-message" id="nameError"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                            <div class="error-message" id="emailError"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required>
                            <div class="error-message" id="passwordError"></div>
                        </div>
                        
                        <div class="steps-nav">
                            <button type="button" class="prev-btn" id="prevStep1">Back</button>
                            <button type="submit" class="signup-button" id="signupButton">Sign Up</button>
                        </div>
                        <div class="error-message" id="generalError"></div>
                    </div>
                    
                    <div class="divider">
                        <span class="divider-text">OR</span>
                    </div>
                    
                    <div class="social-login">
                        <a href="#" class="social-button" id="googleSignup">
                            <img src="{{ asset('Assets/logo google.jpg') }}" alt="Google">
                        </a>
                        <a href="#" class="social-button" id="facebookSignup">
                            <img src="{{ asset('Assets/logo facebook.jpg') }}" alt="Facebook">
                        </a>
                    </div>
                    
                    <div class="signup-text">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="login-link">Log In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="footer"></div>

    <!-- Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if user is already logged in, but don't auto-redirect
            checkAuthStatus(false);
            
            // Setup multi-step form navigation
            const step1Button = document.getElementById('step1Button');
            const prevStep1Button = document.getElementById('prevStep1');
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            
            step1Button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Validate phone
                const phone = document.getElementById('phone').value.trim();
                if (!phone) {
                    showError('phoneError', 'Please enter your phone number');
                    return;
                }
                
                if (!isValidPhone(phone)) {
                    showError('phoneError', 'Please enter a valid phone number');
                    return;
                }
                
                // Move to step 2
                step1.classList.remove('active');
                step2.classList.add('active');
            });
            
            prevStep1Button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Go back to step 1
                step2.classList.remove('active');
                step1.classList.add('active');
            });
            
            // Setup signup form submission
            const signupForm = document.getElementById('signupForm');
            signupForm.addEventListener('submit', handleSignupSubmit);
            
            // Setup social signup buttons
            document.getElementById('googleSignup').addEventListener('click', function(e) {
                e.preventDefault();
                handleSocialSignup('google');
            });
            
            document.getElementById('facebookSignup').addEventListener('click', function(e) {
                e.preventDefault();
                handleSocialSignup('facebook');
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
        
        // Check if user is already authenticated
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
        
        // Handle signup form submission
        function handleSignupSubmit(e) {
            e.preventDefault();
            
            // Reset error messages
            resetErrors();
            
            // Get form values
            const phone = document.getElementById('phone').value.trim();
            const fullname = document.getElementById('fullname').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            
            // Validate inputs
            let isValid = true;
            
            if (!phone) {
                showError('phoneError', 'Please enter your phone number');
                isValid = false;
            } else if (!isValidPhone(phone)) {
                showError('phoneError', 'Please enter a valid phone number');
                isValid = false;
            }
            
            if (!fullname) {
                showError('nameError', 'Please enter your full name');
                isValid = false;
            }
            
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
            } else if (password.length < 8) {
                showError('passwordError', 'Password must be at least 8 characters');
                isValid = false;
            }
            
            if (!isValid) {
                return false;
            }
            
            // Show loading state
            const signupButton = document.getElementById('signupButton');
            signupButton.disabled = true;
            signupButton.textContent = 'Signing up...';
            
            // In a real application, you would send the data to your server
            // Here we'll simulate a successful signup
            simulateServerSignup(fullname, email, phone, password);
        }
        
        // Simulate server signup (replace with actual API call in production)
        function simulateServerSignup(fullname, email, phone, password) {
            // Simulate network delay
            setTimeout(function() {
                // Create mock user data
                const userData = {
                    name: fullname,
                    email: email,
                    phone: phone,
                    id: "user" + Math.floor(Math.random() * 1000)
                };
                
                // Store authentication data
                storeAuthData({
                    token: "sample-auth-token-" + Math.random(),
                    userData: userData
                });
                
                // Show success message and then redirect
                const signupButton = document.getElementById('signupButton');
                signupButton.textContent = 'Success!';
                
                // Update UI to show logged in state
                checkAuthStatus(true);
                
            }, 1000); // 1 second delay to simulate server request
        }
        
        // Handle social signup
        function handleSocialSignup(provider) {
            // In a real app, you would implement OAuth flow
            const signupButton = document.getElementById('step1Button');
            signupButton.textContent = `Signing up with ${provider}...`;
            
            setTimeout(function() {
                const userData = {
                    name: provider === 'google' ? 'Google User' : 'Facebook User',
                    email: `user@${provider}.com`,
                    id: `${provider}${Math.floor(Math.random() * 1000)}`
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
            
            authMessage.style.display = 'none';
            logoutLink.style.display = 'none';
            loginLink.style.display = 'inline-block';
            
            // Reset form
            document.getElementById('signupForm').reset();
            
            // Reset to step 1
            document.getElementById('step2').classList.remove('active');
            document.getElementById('step1').classList.add('active');
            
            // Reset buttons
            document.getElementById('step1Button').disabled = false;
            document.getElementById('step1Button').textContent = 'Continue';
            document.getElementById('signupButton').disabled = false;
            document.getElementById('signupButton').textContent = 'Sign Up';
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
        
        function isValidPhone(phone) {
            // Basic validation for Indonesian phone number
            // Allows formats: +628xxxxxxxxxx, 08xxxxxxxxxx, 628xxxxxxxxxx
            const phoneRegex = /^(\+?62|0)[0-9]{9,12}$/;
            return phoneRegex.test(phone);
        }
        
        function showError(elementId, message) {
            const errorElement = document.getElementById(elementId);
            if (errorElement) {
                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }
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