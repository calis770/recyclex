<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecycleX - My Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(240, 255, 240);
        }
        .header {
            background-color: #c3f0c8;
            padding: 8px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #a0e0af;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .logo img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
        }
        .logo-text {
            color: #2b5329;
            font-size: 18px;
            font-weight: bold;
        }
        .search-cart {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .search {
            padding: 8px 12px;
            border: 1px solid #2b5329;
            border-radius: 25px;
            width: 300px; /* Increased width from 200px to 300px */
            background-color: white;
            color: #333;
            font-size: 14px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.2s, border-color 0.2s;
            outline: none;
        }
        .search:focus {
            border-color: #1e3b1d;
            box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.15);
        }
        .cart-icon {
            color: #753e00;
            font-size: 18px;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .user-info img {
            width: 25px;
            height: 25px;
            border-radius: 50%;
        }
        .username {
            font-size: 14px;
            color: #333;
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
        }
        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-title {
            margin-top: 0;
            margin-bottom: 20px;
            color: #2b5329;
            font-size: 16px;
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
            width: 45%;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.2s;
            margin: 0 auto; /* This centers the button */
        }
        .update-btn:hover {
            background-color: #1e3b1d;
            transform: scale(1.05);
        }

        .footer {
            background-color: #b8f0c7;
            height: 40px;
            margin-top: 20px;
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
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="{{ asset('Assets/logo.png') }}" alt="RecycleX Logo">
            <span class="logo-text">RecycleX</span>
        </div>
        <div class="search-cart">
            <input type="text" class="search" placeholder="Search...">
            <span class="cart-icon">🛒</span>
            <div class="user-info">
                <img src="{{ asset('Assets/profile.jpg') }}" alt="User">
                <span class="username">calista zahra</span>
            </div>
        </div>
    </div>

    <div class="main-container">
        <div class="sidebar">
            <div class="user-avatar">
                <img src="{{ asset('Assets/profile.jpg') }}" alt="User Avatar">
                <span class="username" style="font-size: 12px;">calista zahra</span>
                <span class="edit-profile">Edit Profile</span>
            </div>
            <div class="menu-item">
                <a href="#"><span class="menu-icon">👤</span> My Account</a>
            </div>
            <div class="indented menu-item">
                <a href="#">Profil</a>
            </div>
            <div class="indented menu-item">
                <a href="#">Update Password</a>
            </div>
            <div class="menu-item">
                <a href="#"><span class="menu-icon">📄</span> My Order</a>
            </div>
            <div class="menu-item">
                <a href="#"><span class="menu-icon">🏆</span> Rewards</a>
            </div>
        </div>

        <div class="profile-content">
            <h3 class="form-title">MY PROFILE</h3>
            <form>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" class="form-control">
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" class="form-control">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" class="form-control">
                </div>
                <button type="submit" class="update-btn">Update Profile</button>
            </form>
            <hr>
        </div>
    </div>
    <div class="footer"></div>
</body>
</html>