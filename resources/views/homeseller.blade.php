<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>
        RecycleX - Seller Home
    </title>
    <script src="https://cdn.tailwindcss.com">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .dashboard-item {
            background-color: #fff;
            padding: 35px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: 100%; 
        }
        .dashboard-item h3 {
            color: #2b5329;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .dashboard-item p {
            color: #555;
            font-size: 1rem;
        }

        .dashboard-item .icon {
            font-size: 2rem;
            color: #2b5329;
            margin-bottom: 10px;
        }

        .link-button {
            display: inline-block;
            background-color: #2b5329;
            color: white;
            padding: 15px 25px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        .link-button:hover {
            background-color: #1e3b1d;
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

            <!-- Profile dropdown -->
            <div class="profile-dropdown">
                <div class="profile-button flex items-center" onclick="toggleDropdown()">
                    <img alt="User profile picture" class="h-10 w-10 rounded-full" height="40" src="{{ asset('Assets/profile.jpg') }}" width="40"/>
                    <i class="fas fa-chevron-down text-green-700 ml-2 text-sm"></i>
                </div>
                <div id="profileDropdown" class="dropdown-content">
                    <a href="#" onclick="logout()">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="p-6">
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="dashboard-item">
                <i class="fas fa-box icon"></i>
                <h3>Products</h3>
                <p>Add new products, edit existing ones, and manage your inventory.</p>
                <a href="{{ route('products.index') }}" class="link-button">Manage Products</a>
            </div>

            <div class="dashboard-item">
                <i class="fas fa-user-tie icon"></i>
                <h3>Accounts</h3>
                <p>Manage all accounts, profiles, and  performance metrics.</p>
                <a href="{{ route('akun.index') }}" class="link-button">Manage Account</a>
            </div>

            <div class="dashboard-item">
                <i class="fas fa-coins icon"></i>
                <h3>Coins</h3>
                <p>Add RecycleX Customer Coins and manage reward programs.</p>
                <a href="{{ route('coins.index') }}" class="link-button">Manage Coins</a>
            </div>

            <div class="dashboard-item">
                <i class="fas fa-shopping-bag icon"></i>
                <h3>Order</h3>
                <p>Track incoming orders, update order status, and communicate with customers.</p>
                <a href="{{ route('orders.index') }}" class="link-button">Manage Orders</a>
            </div>
        </section>
    </main>

    <footer class="bg-green-200 p-6 mt-8">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-bold text-green-800 mb-4">About RecycleX</h3>
                <p class="text-green-800">RecycleX is a marketplace platform that connects consumers with local UMKM (Micro, Small, and Medium Enterprises) that produce recycled and sustainable products.</p>
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
                    <li class="flex items-center text-green-800"><i class="fas fa-map-marker-alt mr-2"></i> Jl. Sustainable No. 123, Surabaya</li>
                    <li class="flex items-center text-green-800"><i class="fas fa-envelope mr-2"></i> info@recyclex.id</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-green-300 mt-6 pt-6 text-center text-green-800">
            &copy; 2025 RecycleX. All rights reserved.
        </div>
    </footer>

    <script>
        // Function to toggle profile dropdown
        function toggleDropdown() {
            document.getElementById("profileDropdown").classList.toggle("show");
        }

        // Function to handle logout
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = "{{ route('login') }}";
            }
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
    </script>
</body>
</html>