<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RecycleX - My Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(240, 255, 240);
        }

        .main-container {
            display: flex;
            padding: 20px;
            gap: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .sidebar {
            width: 150px;
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 0 5px rgba(0,0,0,0.05);
        }

        .profile-content {
            flex: 1;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 5px rgba(0,0,0,0.05);
        }

        .user-avatar {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .user-avatar img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-bottom: 6px;
        }

        .edit-profile {
            color: #666;
            font-size: 11px;
            margin-top: 2px;
        }

        .menu-item {
            padding: 6px 0;
        }

        .menu-item a {
            text-decoration: none;
            color: #333;
            font-size: 13px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .menu-item a:hover {
            color: #2b5329;
            font-weight: 500;
        }

        .menu-item.active a {
            color: #2b5329;
            font-weight: bold;
        }

        .menu-icon {
            width: 16px;
            margin-right: 8px;
            text-align: center;
            color: #666;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #2b5329;
            font-size: 13px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: #2b5329;
            box-shadow: 0 0 5px rgba(43, 83, 41, 0.2);
        }

        .form-title {
            margin-top: 0;
            margin-bottom: 20px;
            color: #2b5329;
            font-size: 18px;
            font-weight: bold;
        }

        .update-btn {
            background-color: #2b5329;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            display: block;
            width: 50%;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.2s;
            margin: 20px auto 0;
        }

        .update-btn:hover {
            background-color: #1e3b1d;
            transform: scale(1.05);
        }

        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }

        .indented {
            padding-left: 15px;
            font-size: 12px;
        }

        /* Notification styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            z-index: 1000;
            display: none;
            animation: slideIn 0.3s ease forwards;
        }

        .notification.success {
            background-color: #2b5329;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Profile info display styles */
        .profile-info-display {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid #2b5329;
        }

        .profile-info-title {
            font-size: 14px;
            font-weight: bold;
            color: #2b5329;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .profile-info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .profile-info-item {
            margin-bottom: 8px;
        }

        .profile-info-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 2px;
        }

        .profile-info-value {
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }

        /* Success message after update */
        .success-message {
            display: none;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }

        .success-message.show {
            display: block;
        }

        .success-actions {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn-home {
            background-color: #2b5329;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn-home:hover {
            background-color: #1e3b1d;
        }

        .btn-continue {
            background-color: white;
            color: #2b5329;
            padding: 10px 20px;
            border: 1px solid #2b5329;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn-continue:hover {
            background-color: #f0f0f0;
        }

        /* Profile dropdown styles */
        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            border-radius: 8px;
            z-index: 1;
            top: 100%;
            margin-top: 5px;
        }

        .dropdown-content a {
            color: #2b5329;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
        }

        .dropdown-content a:hover {
            background-color: #f1f5f9;
        }

        .dropdown-content a:first-child {
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .dropdown-content a:last-child {
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .show {
            display: block;
        }

        .profile-button {
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .profile-button:hover {
            opacity: 0.8;
        }

        /* Navigation hover effects */
        .nav-link {
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            transform: translateY(-1px);
            color: #2b5329 !important;
        }

        .cart-icon {
            transition: all 0.3s ease;
        }

        .cart-icon:hover {
            transform: scale(1.1);
            color: #1e3b1d !important;
        }

        /* New styles for password update form */
        .password-update-container {
            display: none; /* Hidden by default */
        }

        /* Updated profile display to ensure it stays visible */
        .profile-info-display-container {
            transition: all 0.3s ease;
        }

        .profile-form-container {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-green-100 font-roboto">
    <div id="profile-updated-notification" class="notification success">
        <i class="fas fa-check-circle mr-2"></i> Profile successfully updated!
    </div>
    <div id="password-updated-notification" class="notification success">
        <i class="fas fa-check-circle mr-2"></i> Password successfully updated!
    </div>

    <header class="bg-green-200 p-4 flex justify-between items-center">
        <div class="flex items-center">
           <a href="/" class="flex items-center hover:opacity-80 transition-opacity">
            <img alt="RecycleX logo" class="h-12 w-12" height="50" src="{{ asset('Assets/logo.png') }}" width="50"/>
            <div class="ml-2">
                <a class="text-sm text-green-700" href="#">
                    Download RecycleX App
                </a>
                <h1 class="text-3xl font-bold text-green-700">
                    RecycleX
                </h1>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input class="pl-8 pr-4 py-2 rounded-full border border-gray-300" placeholder="Search" type="text"/>
                <i class="fas fa-search text-gray-400 absolute left-3 top-3"></i>
            </div>
            <a href="#" class="fas fa-shopping-cart text-green-700 text-2xl cart-icon" onclick="goToproductcart()"></a>
            
            <div class="profile-dropdown">
                <div class="profile-button flex items-center" onclick="toggleDropdown()">
                    <img alt="User profile picture" class="h-10 w-10 rounded-full" height="40" src="{{ asset('Assets/profile.jpg') }}" width="40"/>
                    <i class="fas fa-chevron-down text-green-700 ml-2 text-sm"></i>
                </div>
                <div id="profileDropdown" class="dropdown-content">
                    <a href="{{ route('profilepage') }}" class="active">
                        <i class="fas fa-user mr-2"></i>Profile
                    </a>
                    <a href="{{ route('login') }}" onclick="logout()">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="main-container">
        <div class="sidebar">
            <div class="user-avatar">
                <img src="{{ asset('Assets/profile.jpg') }}" alt="User Avatar">
                <span class="username" id="sidebar-username" style="font-size: 12px;">User</span>
                <span class="edit-profile">Edit Profile</span>
            </div>
            <div class="menu-item active" id="menu-my-account">
                <a href="#" onclick="showProfileForm()"><span class="menu-icon"><i class="fas fa-user"></i></span> My Account</a>
            </div>
            <div class="indented menu-item" id="submenu-profile">
                <a href="#" onclick="showProfileForm()">Profile</a>
            </div>
            <div class="indented menu-item" id="submenu-update-password">
                <a href="#" onclick="showUpdatePassword()">Update Password</a>
            </div>
            <div class="menu-item">
                <a href="#" onclick="goToMyOrder()" class="nav-link">
                    <span class="menu-icon"><i class="fas fa-file-alt"></i></span> My Order
                </a>
            </div>
            <div class="menu-item">
                <a href="#" onclick="goToRewards()" class="nav-link">
                    <span class="menu-icon"><i class="fas fa-trophy"></i></span> Rewards
                </a>
            </div>
        </div>

        <div class="profile-content">
            <div id="profile-info-display-container">
                <h3 class="form-title">MY PROFILE</h3>
                <div class="profile-info-display">
                    <div class="profile-info-title">
                        <i class="fas fa-id-card mr-2"></i> Current Profile Information
                    </div>
                    <div class="profile-info-grid">
                        <div class="profile-info-item">
                            <div class="profile-info-label">Username</div>
                            <div class="profile-info-value" id="display-username">-</div>
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Name</div>
                            <div class="profile-info-value" id="display-name">-</div>
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Email</div>
                            <div class="profile-info-value" id="display-email">-</div>
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Phone Number</div>
                            <div class="profile-info-value" id="display-phone">-</div>
                        </div>
                        <div class="profile-info-item" style="grid-column: span 2;">
                            <div class="profile-info-label">Address</div>
                            <div class="profile-info-value" id="display-address">-</div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="success-message" class="success-message">
                <div style="font-size: 16px; font-weight: bold; margin-bottom: 10px;">
                    <i class="fas fa-check-circle mr-2"></i> Profile Updated Successfully!
                </div>
                <p>Your profile information has been saved.</p>
                <div class="success-actions">
                    <a href="#" class="btn-home" onclick="goToHomepage()">
                        <i class="fas fa-home mr-2"></i> Go to Homepage
                    </a>
                    <button class="btn-continue" onclick="continueEditingProfile()">
                        <i class="fas fa-edit mr-2"></i> Continue Editing
                    </button>
                </div>
            </div>

            <div id="profile-form-container">
                <hr>
                <h4 style="color: #2b5329; font-size: 16px; margin-bottom: 15px;">Update Profile Information</h4>
                <form id="profile-form">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" class="form-control" placeholder="e.g., +62 812 3456 7890">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" class="form-control" rows="3" placeholder="Enter your complete address"></textarea>
                    </div>

                    <button type="submit" class="update-btn">
                        <i class="fas fa-save mr-2"></i> Update Profile
                    </button>
                </form>
            </div>

            <div id="password-update-container" class="password-update-container">
                <h3 class="form-title">UPDATE PASSWORD</h3>
                <hr>
                <form id="password-update-form">
                    <div class="form-group">
                        <label for="current-password">Current Password</label>
                        <input type="password" id="current-password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="new-password">New Password</label>
                        <input type="password" id="new-password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm New Password</label>
                        <input type="password" id="confirm-password" class="form-control" required>
                    </div>
                    <button type="submit" class="update-btn">
                        <i class="fas fa-key mr-2"></i> Change Password
                    </button>
                </form>
                <div id="password-success-message" class="success-message">
                    <div style="font-size: 16px; font-weight: bold; margin-bottom: 10px;">
                        <i class="fas fa-check-circle mr-2"></i> Password Updated Successfully!
                    </div>
                    <p>Your password has been changed.</p>
                    <div class="success-actions">
                        <a href="#" class="btn-home" onclick="goToHomepage()">
                            <i class="fas fa-home mr-2"></i> Go to Homepage
                        </a>
                        <button class="btn-continue" onclick="continueEditingPassword()">
                            <i class="fas fa-edit mr-2"></i> Change Another Password
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-green-200 p-6 mt-8">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-bold text-green-800 mb-4">About RecycleX</h3>
                <p class="text-green-800">
                    RecycleX is a marketplace platform that connects consumers with local UMKM (Micro, Small, and Medium Enterprises)
                    that produce recycled and sustainable products.
                </p>
            </div>
            <div>
                <h3 class="text-lg font-bold text-green-800 mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('homepage') }}" class="text-green-800 hover:underline">Home</a></li>
                    <li><a href="{{ route('homepage') }}" class="text-green-800 hover:underline">Categories</a></li>
                    <li><a href="{{ route('profilepage') }}" class="text-green-800 hover:underline">My Account</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-bold text-green-800 mb-4">Contact</h3>
                <ul class="space-y-2">
                    <li class="flex items-center text-green-800">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        Jl. Sustainable No. 123, Surabaya
                    </li>
                    <li class="flex items-center text-green-800">
                        <i class="fas fa-envelope mr-2"></i>
                        info@recyclex.id
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-t border-green-300 mt-6 pt-6 text-center text-green-800">
            &copy; 2025 RecycleX. All rights reserved.
        </div>
    </footer>

    <script>
        // Initial profile data - replace this with data from your backend
        let profileData = {
            username: '',
            name: '',
            email: '',
            phone: '',
            address: ''
        };

        // Function to toggle profile dropdown
        function toggleDropdown() {
            document.getElementById("profileDropdown").classList.toggle("show");
        }

        // Function to handle logout
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = "/login";
            }
        }

        // Navigation functions
        function goToMyOrder() {
            window.location.href = "/myorder";
        }

        function goToRewards() {
            window.location.href = "/rewards";
        }

        function goToproductcart() {
            window.location.href = "/cart";
        }

        function goToHomepage() {
            window.location.href = "/";
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('.profile-button') && !event.target.closest('.profile-dropdown')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }

        // Function to update the displayed profile information
        function updateDisplayedInfo(data) {
            document.getElementById('display-username').textContent = data.username || '-';
            document.getElementById('display-name').textContent = data.name || '-';
            document.getElementById('display-email').textContent = data.email || '-';
            document.getElementById('display-phone').textContent = data.phone || '-';
            document.getElementById('display-address').textContent = data.address || '-';
            
            // Update sidebar username
            const sidebarUsername = document.getElementById('sidebar-username');
            if (data.name && data.name.trim() !== '') {
                sidebarUsername.textContent = data.name;
            } else if (data.username && data.username.trim() !== '') {
                sidebarUsername.textContent = data.username;
            } else {
                sidebarUsername.textContent = 'User';
            }
        }

        // Function to populate form fields
        function populateFormFields(data) {
            document.getElementById('username').value = data.username || '';
            document.getElementById('name').value = data.name || '';
            document.getElementById('email').value = data.email || '';
            document.getElementById('phone').value = data.phone || '';
            document.getElementById('address').value = data.address || '';
        }

        // Function to update sidebar name in real-time
        function updateSidebarNameRealTime() {
            const nameInput = document.getElementById('name');
            const usernameInput = document.getElementById('username');
            const sidebarUsername = document.getElementById('sidebar-username');
            
            nameInput.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    sidebarUsername.textContent = this.value;
                } else if (usernameInput.value.trim() !== '') {
                    sidebarUsername.textContent = usernameInput.value;
                } else {
                    sidebarUsername.textContent = 'User';
                }
            });
            
            usernameInput.addEventListener('input', function() {
                if (nameInput.value.trim() === '') {
                    if (this.value.trim() !== '') {
                        sidebarUsername.textContent = this.value;
                    } else {
                        sidebarUsername.textContent = 'User';
                    }
                }
            });
        }

        // Function to show notification
        function showNotification(notificationId, duration = 3000) {
            const notification = document.getElementById(notificationId);
            if (notification) {
                notification.style.display = 'block';
                setTimeout(() => {
                    notification.style.display = 'none';
                }, duration);
            }
        }

        // Validation functions
        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function validatePhone(phone) {
            const phoneRegex = /^[\+]?[0-9\s\-\(\)]+$/;
            return phoneRegex.test(phone) && phone.length >= 10;
        }

        function validateProfileForm() {
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const username = document.getElementById('username').value;
            const name = document.getElementById('name').value;

            if (!username.trim()) {
                alert('Username is required!');
                return false;
            }

            if (!name.trim()) {
                alert('Full name is required!');
                return false;
            }

            if (!validateEmail(email)) {
                alert('Please enter a valid email address!');
                return false;
            }

            if (phone && !validatePhone(phone)) {
                alert('Please enter a valid phone number!');
                return false;
            }

            return true;
        }

        // Function to handle profile form submission 
        function handleUpdateProfile(event) {
            event.preventDefault();

            if (!validateProfileForm()) {
                return;
            }

            const formData = {
                username: document.getElementById('username').value.trim(),
                name: document.getElementById('name').value.trim(),
                email: document.getElementById('email').value.trim(),
                phone: document.getElementById('phone').value.trim(),
                address: document.getElementById('address').value.trim()
            };

            // Update the profile data
            profileData = { ...profileData, ...formData };

            // Update displayed information immediately
            updateDisplayedInfo(profileData);

            // Hide form container but KEEP profile info display visible
            document.getElementById('profile-form-container').style.display = 'none';
            // DO NOT hide profile-info-display-container
            document.getElementById('success-message').classList.add('show');
            
            // Show notification
            showNotification('profile-updated-notification');

            console.log('Profile updated:', profileData);
        }

        // Function to handle password update form submission
        function handleUpdatePassword(event) {
            event.preventDefault();

            const currentPassword = document.getElementById('current-password').value;
            const newPassword = document.getElementById('new-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            if (newPassword !== confirmPassword) {
                alert('New password and confirm password do not match!');
                return;
            }

            if (newPassword.length < 6) {
                alert('New password must be at least 6 characters long!');
                return;
            }

            console.log('Password update attempt:', {
                currentPassword,
                newPassword
            });

            document.getElementById('password-update-container').style.display = 'none';
            document.getElementById('password-success-message').classList.add('show');

            showNotification('password-updated-notification');

            document.getElementById('current-password').value = '';
            document.getElementById('new-password').value = '';
            document.getElementById('confirm-password').value = '';
        }

        // Function to continue editing profile 
        function continueEditingProfile() {
            document.getElementById('success-message').classList.remove('show');
            // Keep profile-info-display-container visible
            document.getElementById('profile-info-display-container').style.display = 'block';
            document.getElementById('profile-form-container').style.display = 'block';
            
            populateFormFields(profileData);
        }

        // Function to continue editing password
        function continueEditingPassword() {
            document.getElementById('password-success-message').classList.remove('show');
            document.getElementById('password-update-container').style.display = 'block';
        }

        // Function to show the Profile form 
        function showProfileForm() {
            // Hide password update container
            document.getElementById('password-update-container').style.display = 'none';
            document.getElementById('password-success-message').classList.remove('show');
            
            // Show profile containers
            document.getElementById('profile-info-display-container').style.display = 'block';
            document.getElementById('profile-form-container').style.display = 'block';
            document.getElementById('success-message').classList.remove('show');
            
            // Update menu active states
            document.getElementById('menu-my-account').classList.add('active');
            document.getElementById('submenu-profile').classList.add('active');
            document.getElementById('submenu-update-password').classList.remove('active');
            
            // Populate form with current data
            populateFormFields(profileData);
        }

        // Function to show Update Password form
        function showUpdatePassword() {
            // Hide profile containers
            document.getElementById('profile-info-display-container').style.display = 'none';
            document.getElementById('profile-form-container').style.display = 'none';
            document.getElementById('success-message').classList.remove('show');
            
            // Show password update container
            document.getElementById('password-update-container').style.display = 'block';
            document.getElementById('password-success-message').classList.remove('show');
            
            // Update menu active states
            document.getElementById('menu-my-account').classList.add('active');
            document.getElementById('submenu-update-password').classList.add('active');
            document.getElementById('submenu-profile').classList.remove('active');
            
            // Clear password fields
            document.getElementById('current-password').value = '';
            document.getElementById('new-password').value = '';
            document.getElementById('confirm-password').value = '';
        }

        // Function to handle menu item clicks
        function handleMenuClick(menuItem) {
            // Remove active class from all menu items
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => item.classList.remove('active'));
            
            // Add active class to clicked menu item
            menuItem.classList.add('active');
        }

        // Initialize the page when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Update displayed information with initial data
            updateDisplayedInfo(profileData);
            
            // Populate form fields with initial data
            populateFormFields(profileData);
            
            // Set up real-time sidebar name updates
            updateSidebarNameRealTime();
            
            // Set up form event listeners
            const profileForm = document.getElementById('profile-form');
            if (profileForm) {
                profileForm.addEventListener('submit', handleUpdateProfile);
            }

            const passwordForm = document.getElementById('password-update-form');
            if (passwordForm) {
                passwordForm.addEventListener('submit', handleUpdatePassword);
            }

            // Show profile form by default
            showProfileForm();
        });

        // Additional utility functions
        function resetAllForms() {
            // Reset profile form
            const profileForm = document.getElementById('profile-form');
            if (profileForm) {
                profileForm.reset();
                populateFormFields(profileData);
            }
            
            // Reset password form
            const passwordForm = document.getElementById('password-update-form');
            if (passwordForm) {
                passwordForm.reset();
            }
            
            // Hide all success messages
            document.getElementById('success-message').classList.remove('show');
            document.getElementById('password-success-message').classList.remove('show');
        }

        // Function to handle escape key to close modals/notifications
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                // Close dropdown if open
                const dropdown = document.getElementById('profileDropdown');
                if (dropdown && dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                }
                
                // Hide notifications
                const notifications = document.querySelectorAll('.notification');
                notifications.forEach(notification => {
                    notification.style.display = 'none';
                });
            }
        });

        // Function to validate password strength
        function validatePasswordStrength(password) {
            const minLength = 8;
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumbers = /\d/.test(password);
            const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);
            
            if (password.length < minLength) {
                return { valid: false, message: 'Password must be at least 8 characters long' };
            }
            
            let strengthScore = 0;
            if (hasUpperCase) strengthScore++;
            if (hasLowerCase) strengthScore++;
            if (hasNumbers) strengthScore++;
            if (hasSpecialChar) strengthScore++;
            
            if (strengthScore < 3) {
                return { 
                    valid: false, 
                    message: 'Password should contain at least 3 of: uppercase, lowercase, numbers, special characters' 
                };
            }
            
            return { valid: true, message: 'Password is strong' };
        }

        // Enhanced password validation in form submission
        function handleUpdatePasswordEnhanced(event) {
            event.preventDefault();

            const currentPassword = document.getElementById('current-password').value;
            const newPassword = document.getElementById('new-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            // Check if new password matches confirmation
            if (newPassword !== confirmPassword) {
                alert('New password and confirm password do not match!');
                return;
            }

            // Validate password strength
            const validation = validatePasswordStrength(newPassword);
            if (!validation.valid) {
                alert(validation.message);
                return;
            }

            // Check if new password is different from current
            if (currentPassword === newPassword) {
                alert('New password must be different from current password!');
                return;
            }

            console.log('Password update attempt:', {
                currentPassword: '[HIDDEN]',
                newPassword: '[HIDDEN]',
                validation: validation.message
            });

            // Hide form and show success message
            document.getElementById('password-update-container').style.display = 'none';
            document.getElementById('password-success-message').classList.add('show');

            // Show notification
            showNotification('password-updated-notification');

            // Clear form fields
            document.getElementById('current-password').value = '';
            document.getElementById('new-password').value = '';
            document.getElementById('confirm-password').value = '';
        }

        // Function to auto-save profile data (simulate auto-save feature)
        function setupAutoSave() {
            const formFields = ['username', 'name', 'email', 'phone', 'address'];
            
            formFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.addEventListener('blur', function() {
                        // Auto-save when user leaves a field
                        const currentValue = this.value.trim();
                        if (currentValue !== profileData[fieldId]) {
                            console.log(`Auto-saving ${fieldId}: ${currentValue}`);
                            // Here you would typically send an AJAX request to save the data
                        }
                    });
                }
            });
        }

        // Initialize auto-save feature
        document.addEventListener('DOMContentLoaded', function() {
            setupAutoSave();
        });
    </script>
</body>
</html>