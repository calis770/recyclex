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
            font-family: 'Roboto', sans-serif;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
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
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .logo-img:hover {
            transform: scale(1.05);
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
        
        .form-group input.is-invalid {
            border-color: #d32f2f;
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
        }
        
        .success-message {
            color: #2e7d32;
            font-size: 14px;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #e8f5e8;
            border-radius: 4px;
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
            padding: 25px;
            text-align: center;
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
        <div class="header-logo" onclick="window.location.href='{{ url('/') }}'">
            <img src="{{ asset('Assets/logo.png') }}" alt="RecycleX Logo">
            <span>RecycleX</span>
        </div>
        <div class="header-links">
            @guest
                <a href="{{ route('signup') }}">Sign Up</a>
            @else
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
                </form>
            @endguest
        </div>
    </div>
    
    <div class="main-container">
        <div class="content-wrapper">
            <div class="logo-section">
                <img src="{{ asset('Assets/logo.png') }}" alt="RecycleX Logo" class="logo-img" onclick="window.location.href='{{ url('/') }}'">
                <div class="tagline">
                    <p>Dari UMKM untuk Bumi,</p>
                    <p>Belanja Ramah Lingkungan</p>
                </div>
            </div>
            
            <div class="login-section">
                @if(session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('status'))
                    <div class="success-message">
                        {{ session('status') }}
                    </div>
                @endif
                
                <h2 class="login-heading">Log In</h2>
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               class="@error('email') is-invalid @enderror" 
                               required 
                               autocomplete="email" 
                               autofocus>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="@error('password') is-invalid @enderror" 
                               required 
                               autocomplete="current-password">
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <div class="forgot-link">
                            <a href="{{ route('password.request') }}">Forgot Password?</a>
                        </div>
                    </div>
                    
                    <button type="submit" class="login-button">Continue</button>
                    
                    <div class="divider">
                        <span class="divider-text">OR</span>
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
        // Set CSRF token for AJAX requests
        document.addEventListener('DOMContentLoaded', function() {
            const token = document.querySelector('meta[name="csrf-token"]');
            if (token) {
                window.Laravel = {
                    csrfToken: token.getAttribute('content')
                };
            }
        });

        // Auto-hide success messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.querySelector('.success-message');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 5000);
            }
        });

        // Form validation enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitButton = document.querySelector('.login-button');
            
            form.addEventListener('submit', function() {
                submitButton.disabled = true;
                submitButton.textContent = 'Logging in...';
            });
        });
    </script>
</body>
</html>