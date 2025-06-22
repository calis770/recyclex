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
            font-family: 'Roboto', sans-serif;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Header */
        .header {
            background-color: var(--primary-green);
            padding: 25px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: opacity 0.3s ease;
            text-decoration: none;
        }
        
        .header-logo:hover {
            opacity: 0.8;
        }
        
        .header-logo img {
            height: 45px;
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
        .steps-nav {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-top: 20px;
            width: 100%;
            align-items: center;
        }

        .prev-btn, .steps-nav .signup-button {
            flex: 1;
            min-height: 44px;
            padding: 0; 
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            text-align: center;
            font-size: 14px;
            white-space: nowrap;
            box-sizing: border-box;
            border: none; 
            display: flex; 
            align-items: center; 
            justify-content: center;
        }

        .prev-btn {
            background-color: #f5f5f5;
            color: #333;
        }

        .steps-nav .signup-button {
            background-color: var(--button-color);
            color: white;
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

        .form-group input.is-invalid {
            border-color: #d32f2f;
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
            font-size: 12px;
            margin-top: 5px;
        }

        .success-message {
            color: #2e7d32;
            font-size: 14px;
            background-color: #e8f5e8;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid #c3f0c8;
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
        <a href="{{ route('landingpage') }}" class="header-logo" id="logoLink">
            <img src="{{ asset('Assets/logo.png') }}" alt="RecycleX Logo">
            <span>RecycleX</span>
        </a>
        <div class="header-links">
            <a href="{{ route('login') }}" id="loginLink">Log In</a>
        </div>
    </div>
    
    <!-- Main Container -->
    <div class="main-container">
        <div class="content-wrapper">
            <!-- Logo & Tagline -->
            <div class="logo-section">
                <img src="{{ asset('Assets/logo.png') }}" alt="RecycleX Logo" class="logo-img" onclick="window.location.href='{{ url('/') }}'">
                <div class="tagline">
                    <p>Dari UMKM untuk Bumi,</p>
                    <p>Belanja Ramah Lingkungan</p>
                </div>
            </div>
            
            <!-- Sign Up Form -->
            <div class="signup-section">
                <h2 class="signup-heading">Sign Up</h2>

                <!-- Display Success Message -->
                @if(session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Display Laravel Validation Errors -->
                @if($errors->any())
                    <div class="error-message" style="background-color: #ffeaea; padding: 10px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #d32f2f;">
                        <strong>Please fix the following errors:</strong>
                        <ul style="margin: 5px 0 0 20px; padding: 0;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('signup') }}" id="signupForm">
                    @csrf
                    
                    <!-- Step 1: Phone -->
                    <div class="step-container active" id="step1">
                        <div class="form-group">
                            <label for="phone">No. Telepon</label>
                            <input type="text" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   class="@error('phone') is-invalid @enderror"
                                   required>
                            @error('phone')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="error-message" id="phoneError"></div>
                        </div>
                        
                        <button type="button" class="signup-button" id="step1Button">Continue</button>
                    </div>
                    
                    <!-- Step 2: Additional Info -->
                    <div class="step-container" id="step2">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   class="@error('name') is-invalid @enderror"
                                   required>
                            @error('name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="error-message" id="nameError"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   class="@error('email') is-invalid @enderror"
                                   required>
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="error-message" id="emailError"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" 
                                   id="password" 
                                   name="password"
                                   class="@error('password') is-invalid @enderror"
                                   required>
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="error-message" id="passwordError"></div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation"
                                   required>
                            <div class="error-message" id="passwordConfirmError"></div>
                        </div>
                        
                        <div class="steps-nav">
                            <button type="button" class="prev-btn" id="prevStep1">Back</button>
                            <button type="submit" class="signup-button" id="signupButton">Sign Up</button>
                        </div>
                    </div>
                </form>

                <div class="divider">
                    <span class="divider-text">OR</span>
                </div>
                
                <div class="signup-text">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="login-link">Log In</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="footer"></div>

    <!-- Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if we have validation errors and should show step 2
            @if($errors->has('name') || $errors->has('email') || $errors->has('password'))
                document.getElementById('step1').classList.remove('active');
                document.getElementById('step2').classList.add('active');
            @endif

            // Setup multi-step form navigation
            const step1Button = document.getElementById('step1Button');
            const prevStep1Button = document.getElementById('prevStep1');
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            
            step1Button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Validate phone
                const phone = document.getElementById('phone').value.trim();
                const phoneError = document.getElementById('phoneError');
                
                // Clear previous errors
                phoneError.textContent = '';
                phoneError.style.display = 'none';
                
                if (!phone) {
                    showError('phoneError', 'Please enter your phone number');
                    return;
                }
                
                if (!isValidPhone(phone)) {
                    showError('phoneError', 'Please enter a valid phone number (format: 08xxxxxxxxxx or +628xxxxxxxxxx)');
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

            // Real-time password confirmation validation
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            const passwordConfirmError = document.getElementById('passwordConfirmError');

            passwordConfirmation.addEventListener('input', function() {
                if (passwordConfirmation.value && password.value !== passwordConfirmation.value) {
                    showError('passwordConfirmError', 'Passwords do not match');
                    passwordConfirmation.classList.add('is-invalid');
                } else {
                    passwordConfirmError.textContent = '';
                    passwordConfirmError.style.display = 'none';
                    passwordConfirmation.classList.remove('is-invalid');
                }
            });

            // Form submission validation
            const signupForm = document.getElementById('signupForm');
            signupForm.addEventListener('submit', function(e) {
                let isValid = true;

                // Clear all errors first
                resetErrors();

                // Validate all fields
                const phone = document.getElementById('phone').value.trim();
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const passwordValue = password.value;
                const passwordConfirmationValue = passwordConfirmation.value;

                if (!phone || !isValidPhone(phone)) {
                    showError('phoneError', 'Please enter a valid phone number');
                    isValid = false;
                }

                if (!name) {
                    showError('nameError', 'Please enter your full name');
                    isValid = false;
                }

                if (!email || !isValidEmail(email)) {
                    showError('emailError', 'Please enter a valid email address');
                    isValid = false;
                }

                if (!passwordValue || passwordValue.length < 6) {
                    showError('passwordError', 'Password must be at least 6 characters');
                    isValid = false;
                }

                if (passwordValue !== passwordConfirmationValue) {
                    showError('passwordConfirmError', 'Passwords do not match');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    // Show step 2 if there are errors in step 2 fields
                    if (!name || !email || !passwordValue || passwordValue !== passwordConfirmationValue) {
                        step1.classList.remove('active');
                        step2.classList.add('active');
                    }
                    return false;
                }

                // Show loading state
                const signupButton = document.getElementById('signupButton');
                signupButton.disabled = true;
                signupButton.textContent = 'Signing up...';
            });
            
            // Setup social signup buttons (placeholder)
            document.getElementById('googleSignup').addEventListener('click', function(e) {
                e.preventDefault();
                alert('Google signup will be implemented later');
            });
            
            document.getElementById('facebookSignup').addEventListener('click', function(e) {
                e.preventDefault();
                alert('Facebook signup will be implemented later');
            });
        });
        
        // Utility functions
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
        
        function isValidPhone(phone) {
            // Indonesian phone number validation
            // Allows: +628xxxxxxxxxx, 08xxxxxxxxxx, 628xxxxxxxxxx
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
                if (element.id) { // Only reset JS generated errors, not Laravel errors
                    element.textContent = '';
                    element.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>