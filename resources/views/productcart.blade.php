<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecycleX - Product Cart</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            font-family: Arial, sans-serif;
            background-color: #f0fff0;
        }
        .header {
            background-color: #c3f0c8;
            padding: 10px 20px;
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
            border: 1px solid #ccc;
            border-radius: 25px;
            width: 300px;
            background-color: white;
            color: #333;
            font-size: 14px;
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
            flex: 1; /* This allows the main container to grow and fill the available space */
            max-width: 800px;
            margin: 20px auto;
        }
        .cart-container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 5px rgba(0,0,0,0.05);
        }
        .cart-title {
            margin-top: 0;
            margin-bottom: 20px;
            color: #2b5329;
            font-size: 18px;
            font-weight: bold;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .seller-group {
            margin-bottom: 20px;
        }
        .seller-name {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .seller-name input[type="checkbox"] {
            margin-right: 10px;
        }
        .cart-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            position: relative;
        }
        .item-checkbox {
            margin-right: 10px;
        }
        .item-image {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 15px;
            border: 1px solid #ddd;
        }
        .item-details {
            flex: 1;
        }
        .item-name {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .item-description {
            font-size: 12px;
            color: #666;
            margin-bottom: 3px;
        }
        .item-note {
            font-size: 12px;
            color: #666;
        }
        .item-price {
            font-weight: bold;
            color: #333;
            margin-right: 20px;
            font-size: 15px;
        }
        .quantity-control {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }
        .quantity-btn {
            width: 30px;
            height: 30px;
            background-color: #f5f5f5;
            border: none;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .quantity-input {
            width: 40px;
            height: 30px;
            border: none;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
            text-align: center;
        }
        .voucher-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-top: 1px solid #eee;
            margin-top: 10px;
        }
        .voucher-text {
            display: flex;
            align-items: center;
        }
        .voucher-icon {
            background-color: #c3f0c8;
            padding: 10px;
            border-radius: 6px;
            margin-right: 10px;
            font-size: 18px;
        }
        .voucher-info {
            font-size: 14px;
            color: #333;
        }
        .voucher-link {
            color: #2b5329;
            text-decoration: none;
            font-size: 14px;
        }
        .voucher-link:hover {
            text-decoration: underline;
        }
        .footer {
            background-color: #b8f0c7;
            height: 40px;
        }
        hr {
            border: none;
            border-top: 1px solid #eee;
            margin: 15px 0;
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
                <img src="{{ asset('Assets/profile.jpg') }}" alt="User ">
                <span class="username">calista zahra</span>
            </div>
        </div>
    </div>

    <div class="main-container">
        <div class="cart-container">
            <h2 class="cart-title">Product Cart</h2>
            
            <div class="seller-group">
                <div class="seller-name">
                    <input type="checkbox" id="seller1">
                    <label for="seller1">UMKM Putri</label>
                </div>
                
                <div class="cart-item">
                    <input type="checkbox" class="item-checkbox">
                    <img src="{{ asset('Assets/') }}" alt="Totebag Batik" class="item-image">
                    <div class="item-details">
                        <div class="item-name">Totebag Batik</div>
                        <div class="item-description">Terbuat dari kain perca</div>
                        <div class="item-note">Cocok untuk dipakai pergi berkuliah</div>
                    </div>
                    <div class="item-price">Rp. 54.000,00</div>
                    <div class="quantity-control">
                        <button class="quantity-btn">-</button>
                        <input type="text" value="1" class="quantity-input">
                        <button class="quantity-btn">+</button>
                    </div>
                </div>
            </div>
            
            <div class="voucher-section">
                <div class="voucher-text">
                    <span class="voucher-icon">🎟️</span>
                    <span class="voucher-info">Tersedia Voucher Diskon s/d 50%</span>
                </div>
                <a href="#" class="voucher-link">Voucher Lainnya</a>
            </div>
        </div>
    </div>
    
    <div class="footer"></div>

    <script>
        // Simple quantity increment/decrement functionality
        document.addEventListener('DOMContentLoaded', function() {
            const minusButtons = document.querySelectorAll('.quantity-btn:first-child');
            const plusButtons = document.querySelectorAll('.quantity-btn:last-child');
            
            minusButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.nextElementSibling;
                    let value = parseInt(input.value);
                    if (value > 1) {
                        input.value = value - 1;
                    }
                });
            });
            
            plusButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    let value = parseInt(input.value);
                    input.value = value + 1;
                });
            });
        });
    </script>
</body>
</html>