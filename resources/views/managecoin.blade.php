<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RecycleX Seller Portal - Add Coins</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: rgb(240, 255, 240);
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    h2 {
      color: #2e7d32;
      text-align: center;
      margin-bottom: 25px;
      font-weight: bold;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      color: #555;
      font-weight: bold;
    }

    input[type="text"],
    input[type="number"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-sizing: border-box;
      font-size: 16px;
    }

    button {
      background-color: #2e7d32;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
      display: block;
      width: 100%;
    }

    button:hover {
      background-color: #1b5e20;
    }

    .success-message {
      color: green;
      margin-top: 15px;
      text-align: center;
      font-weight: bold;
    }

    .error-message {
      color: red;
      margin-top: 15px;
      text-align: center;
      font-weight: bold;
    }

    header .relative {
      display: flex;
      align-items: center;
    }

    header .relative input[type="text"] {
      padding-left: 35px; 
      border-radius: 50px; 
      padding-right: 15px; 
    }

    header .relative i.fa-search {
      position: absolute;
      left: 10px;
      color: #718096; /* Warna abu-abu untuk ikon */
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

  <div class="container mt-8">
    <h2>Add RecycleX Coins</h2>
    <form id="addCoinForm">
      <div class="form-group">
        <label for="userId">User ID / Username:</label>
        <input type="text" id="userId" name="userId" placeholder="Enter user's ID or username">
      </div>
      <div class="form-group">
        <label for="bottles">Number of Bottles Exchanged:</label>
        <input type="number" id="bottles" name="bottles" min="1" value="1">
      </div>
      <div class="form-group">
        <label for="coinsToAdd">Coins to Add:</label>
        <input type="number" id="coinsToAdd" name="coinsToAdd" min="1" value="1" readonly>
        <p class="text-sm text-gray-600 mt-1">Based on the number of bottles exchanged.</p>
      </div>
      <button type="submit">Add Coins to User</button>
    </form>

    <div id="message" class="mt-4 text-center">
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
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('addCoinForm');
      const messageDiv = document.getElementById('message');
      const bottlesInput = document.getElementById('bottles');
      const coinsToAddInput = document.getElementById('coinsToAdd');

      bottlesInput.addEventListener('input', function() {
        // Simple logic: 1 bottle = 1 coin (you can adjust this)
        coinsToAddInput.value = parseInt(bottlesInput.value) || 0;
      });

      form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const userId = document.getElementById('userId').value;
        const coins = parseInt(document.getElementById('coinsToAdd').value);

        if (userId && coins > 0) {
          messageDiv.textContent = `Successfully added ${coins} coins to user: ${userId}`;
          messageDiv.className = 'success-message';
          form.reset();
        } else {
          messageDiv.textContent = 'Please enter a valid User ID and a positive number of coins.';
          messageDiv.className = 'error-message';
        }
      });
    });
  </script>
</body>
</html>