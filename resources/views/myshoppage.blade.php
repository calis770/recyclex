<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RecycleX - My Shop</title>
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
            display: inline-block; /* Changed to inline-block */
            width: auto; /* Adjust width */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.2s;
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

        /* Styles for My Shop Page */
        .shop-info-section {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #f8f8f8;
        }

        .shop-info-section h4 {
            color: #2b5329;
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .shop-info-section p {
            color: #555;
            margin-bottom: 8px;
        }

        .shop-actions a {
            margin-right: 10px;
        }
    </style>
</head>
<body class="bg-green-100 font-roboto">
    <header class="bg-green-200 p-4 flex justify-between items-center">
        <div class="flex items-center">
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
            <a href="{{ route('productcart') }}"
               class="fas fa-shopping-cart text-green-700 text-2xl"></i>
            </a>
            </i>
            <a href="{{ route('profilepage') }}" class="flex items-center">
                <img alt="User profile picture" class="h-10 w-10 rounded-full" height="40" src="{{ asset('Assets/profile.jpg') }}" width="40"/>
                </span>
            </a>
        </div>
    </header>

    <div class="main-container">
        <div class="sidebar">
            <div class="user-avatar">
                <img src="{{ asset('Assets/profile.jpg') }}" alt="User Avatar">
                <span class="username" style="font-size: 12px;">calista zahra</span>
                <span class="edit-profile">Edit Profile</span>
            </div>
            <div class="menu-item">
                <a href="{{ route('profilepage') }}"><span class="menu-icon"><i class="fas fa-user"></i></span> My Account</a>
            </div>
            <div class="indented menu-item">
                <a href="{{ route('profilepage') }}">Profile</a>
            </div>
            <div class="indented menu-item">
                <a href="#" onclick="showSection('update-password-section')">Update Password</a>
            </div>
            <div class="menu-item">
                <a href="{{ route('myorderpage') }}">
                    <span class="menu-icon"><i class="fas fa-file-alt"></i></span> My Order
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('rewardspage') }}">
                    <span class="menu-icon"><i class="fas fa-trophy"></i></span> Rewards
                </a>
            </div>
            <div class="menu-item active seller-menu">
                <a href="#"><span class="menu-icon"><i class="fas fa-store"></i></span> My Shop</a>
            </div>
            <div class="menu-item seller-menu">
                <a href="{{ route('productspage') }}"><span class="menu-icon"><i class="fas fa-box"></i></span> Products</a>
            </div>
        </div>

        <div class="profile-content">
            <h3 class="form-title">MY SHOP</h3>

            <div class="shop-info-section">
                <h4>Shop Information</h4>
                <p><strong>Shop Name:</strong> [Your Shop Name]</p>
                <p><strong>Business Type:</strong> [Your Business Type]</p>
                <p><strong>Description:</strong> [Your Shop Description - maybe a longer one]</p>
            </div>

            <div class="shop-actions">
                <a href="#" class="update-btn"><i class="fas fa-edit mr-2"></i> Edit Shop Details</a>
                <a href="{{ route('productspage') }}" class="update-btn"><i class="fas fa-plus mr-2"></i> Add New Product</a>
            </div>

            <hr>

            <div>
                <h4>Your Products</h4>
                <p>A list of your currently active products would go here. You might want to display product names, images (if available), and perhaps status (active/inactive).</p>
                <ul>
                    <li>[Product Name 1] - <a href="#">Edit</a> | <a href="#">View</a></li>
                    <li>[Product Name 2] - <a href="#">Edit</a> | <a href="#">View</a></li>
                    </ul>
                <div class="mt-4">
                    <a href="{{ route('productspage') }}" class="text-green-700 hover:underline">Manage All Products</a>
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
                    <li><a href="{{ route('homeseller') }}" class="text-green-800 hover:underline">Home</a></li>
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
        function showSection(sectionId) {
            document.querySelectorAll('.content-area').forEach(function(section) {
                section.style.display = 'none';
            });
            const section = document.getElementById(sectionId);
            if (section) {
                section.style.display = 'block';
            }
        }
    </script>
    <script>
        // Keep the role selection logic if needed on other seller pages
        function selectRole(role) {
            document.getElementById('user-role').classList.remove('selected');
            document.getElementById('seller-role').classList.remove('selected');
            document.getElementById(role + '-role').classList.add('selected');

            if (role === 'seller') {
                document.getElementById('seller-fields').style.display = 'block';
                const sellerMenuItems = document.querySelectorAll('.seller-menu');
                sellerMenuItems.forEach(item => {
                    item.style.display = 'block';
                });
            } else {
                document.getElementById('seller-fields').style.display = 'none';
                const sellerMenuItems = document.querySelectorAll('.seller-menu');
                sellerMenuItems.forEach(item => {
                    item.style.display = 'none';
                });
            }
        }

        // Ensure the correct role is highlighted on page load if needed
        document.addEventListener('DOMContentLoaded', function() {
            // Example: If the user is a seller, highlight the seller role
            const isSeller = true; // Replace with your actual logic to check user role
            if (isSeller) {
                selectRole('seller');
            }
        });
    </script>
</body>
</html>