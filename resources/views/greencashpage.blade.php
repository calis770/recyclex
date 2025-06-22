<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RecycleX</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-color: rgb(240, 255, 240);
            margin: 0;
            padding: 0;
        }

        .main-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .section-title {
            text-align: center;
            padding: 15px;
            background-color: #fff;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #2e7d32;
        }

        .boxes-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .box {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            width: 48%;
        }

        .box-title {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .box-icon {
            width: 60px;
            height: 60px;
            margin: 10px auto;
        }

        .btn {
            background-color: #2e7d32;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .guidelines {
            background-color: #cceed2;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .guidelines-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .guidelines-subtitle {
            color: #555;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .coin-section {
            background-color: #e8f5e9;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
        }

        .coin-title {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .coin-steps {
            display: flex;
            justify-content: space-around;
        }

        .step {
            text-align: center;
            width: 30%;
        }

        .step-icon {
            width: 50px;
            height: 50px;
            margin: 0 auto 10px;
        }

        .step-text {
            font-size: 12px;
            color: #555;
        }

        /* Add cursor pointer for profile area */
        .profile-link {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .profile-link:hover {
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
            <a href="{{ route('productcart') }}" class="fas fa-shopping-cart text-green-700 text-2xl">
            </a>
            <a href="{{ route('profilepage') }}" class="flex items-center profile-link">
                <img alt="User profile picture" class="h-10 w-10 rounded-full" height="40" src="{{ asset('Assets/profile.jpg') }}" width="40"/>
                </span>
            </a>
        </div>
    </header>

    <div id="main-content-container" class="main-content">
        <div class="section-title">
            What Can I Put In My Bag or Box?
        </div>

        <div class="boxes-container">
            <div class="box">
                <div class="box-title">WE ACCEPT</div>
                <div style="position: relative; height: 60px;">
                    <i class="fas fa-bottle-water fa-2x" style="position: absolute; left: 30%; top: 10px;"></i>
                    <i class="fas fa-box fa-2x" style="position: absolute; left: 60%; top: 10px;"></i>
                </div>
                <button class="btn" id="accept-btn">Check The Box</button>
            </div>

            <div class="box">
                <div class="box-title">WE DO NOT ACCEPT</div>
                <div style="position: relative; height: 60px;">
                    <i class="fas fa-times fa-2x" style="position: absolute; left: 30%; top: 10px;"></i>
                    <i class="fas fa-box fa-2x" style="position: absolute; left: 60%; top: 10px;"></i>
                </div>
                <button class="btn" id="reject-btn">Check The Box</button>
            </div>
        </div>

        <div class="guidelines">
            <div class="guidelines-title">Packaging Guidelines</div>
            <div class="guidelines-subtitle">Choose the delivery services</div>
        </div>

        <div class="coin-section">
            <div class="coin-title">How Do I Get a Coin?</div>
            <div class="coin-steps">
                <div class="step">
                    <i class="fas fa-box fa-3x"></i>
                    <div class="step-text">1. pack items<br>with RecycleX</div>
                </div>
                <div class="step">
                    <i class="fas fa-store fa-3x"></i>
                    <div class="step-text">2. drop your box<br>at the drop-off</div>
                </div>
                <div class="step">
                    <i class="fas fa-coins fa-3x"></i>
                    <div class="step-text">3. get access to<br>discount<br>coin</div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const acceptBtn = document.getElementById('accept-btn');
            const rejectBtn = document.getElementById('reject-btn');
            const mainContentContainer = document.getElementById('main-content-container');

            acceptBtn.addEventListener('click', function() {
                mainContentContainer.innerHTML = `
                    <div class="section-title">
                        What We Gladly Accept for Recycling
                    </div>

                    <div class="bg-white rounded-md p-6 mb-6 shadow-md">
                        <h2 class="text-xl font-semibold text-green-700 mb-4">Accepted Items</h2>
                        <p class="text-gray-700 mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i> Plastic bottles (PET and HDPE)</p>
                        <p class="text-gray-700 mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i> Glass bottles and jars</p>
                    </div>

                    <div class="bg-green-100 rounded-md p-6 shadow-md">
                        <h2 class="text-xl font-semibold text-green-700 mb-4">UMKM Drop-off Locations for Coins</h2>
                        <p class="text-gray-700 mb-2">Bring your accepted recyclables to these local UMKM partners to exchange them for RecycleX coins!</p>
                        <ul class="list-disc list-inside text-green-800">
                            <li><b>Berkah Daur Ulang:</b> Jl. Mawar No. 15, Surabaya (Open Mon-Sat, 9 AM - 5 PM)</li>
                            <li><b>Sinar Plastik:</b> Komplek Industri No. A7, Sidoarjo (Open Mon-Fri, 8 AM - 4 PM)</li>
                            <li><b>Griya Kaca Lestari:</b> Jl. Anggrek No. 22, Gresik (Open Tue-Sun, 10 AM - 6 PM)</li>
                            <li><a href="#" class="text-green-600 hover:underline">View All Locations on Map</a></li>
                        </ul>
                    </div>

                    <button class="bg-yellow-900 hover:bg-yellow-900 text-white font-bold py-2 px-4 rounded mt-4" onclick="window.location.reload()">Go Back</button>
                `;
            });

            rejectBtn.addEventListener('click', function() {
                mainContentContainer.innerHTML = `
                    <div class="section-title">
                        Items We Currently Cannot Accept
                    </div>

                    <div class="bg-white rounded-md p-6 mb-6 shadow-md">
                        <h2 class="text-xl font-semibold text-red-700 mb-4">Unaccepted Items</h2>
                        <p class="text-gray-700 mb-2"><i class="fas fa-times-circle text-red-500 mr-2"></i> Styrofoam</p>
                        <p class="text-gray-700 mb-2"><i class="fas fa-times-circle text-red-500 mr-2"></i> Electronic waste (e-waste)</p>
                        <p class="text-gray-700 mb-2"><i class="fas fa-times-circle text-red-500 mr-2"></i> Hazardous materials (chemicals, batteries)</p>
                        <p class="text-gray-700 mb-2"><i class="fas fa-times-circle text-red-500 mr-2"></i> Food waste</p>
                        <p class="text-gray-700 mb-2"><i class="fas fa-times-circle text-red-500 mr-2"></i> Multi-layer packaging (e.g., chip bags)</p>
                    </div>

                    <div class="bg-yellow-100 rounded-md p-6 shadow-md">
                        <h2 class="text-xl font-semibold text-yellow-700 mb-4">Why We Can't Accept These (Currently)</h2>
                        <p class="text-gray-700 mb-2">Our current UMKM partners and recycling processes are not yet equipped to handle these types of materials efficiently. We are continuously working to expand our capabilities and accept more materials in the future. Thank you for your understanding!</p>
                    </div>

                    <button class="bg-yellow-900 hover:bg-yellow-900 text-white font-bold py-2 px-4 rounded mt-4" onclick="window.location.reload()">Go Back</button>
                `;
            });
        });
    </script>
</body>
</html>