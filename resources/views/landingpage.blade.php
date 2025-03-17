<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecycleX - Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        .hero-image {
            width: 100%; 
            height: 100%;
        }
        .hero-container {
            display: flex;
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
        }
        .body {
            font-family: 'Arial', sans-serif;
        }
    </style>
</head>
<body class="bg-green-100">

    <!-- Header -->
    <header class="bg-green-200 p-4 flex justify-between items-center">
        <div class="flex items-center">
            <img src="{{ asset('Assets/logo.png') }}" alt="RecycleX Logo" class="h-12 w-12" />
            <h1 class="text-2xl font-bold text-green-800 ml-2">RecycleX</h1>
        </div>
        <nav>
            <a href="#features" class="text-green-800 mx-4">Features</a>
            <a href="#new products" class="text-green-800 mx-4">New Products</a>
            <a href="{{ route('login') }}" class="bg-green-800 text-white px-4 py-2 rounded-md">Log In</a>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="relative">
        <div class="hero-container">
        <img alt="Header" class="hero-image" src="{{ asset('Assets/bg header (2).jpg') }}"/>
        <div class="absolute top-1/5 left-1/4.1 text-white">
            <h2 class="text-4xl font-bold">Halo! Aku RecycleX,
            <h2 class= "text-4xl font-bold">teman ramah lingkunganmu!</h2>
            <p class="mt-4 text-lg" >"Dari UMKM untuk Bumi,</p>
            <p></p>Belanja Ramah Lingkungan"</p>
            <a href="{{ route('login') }}" class="bg-white text-green-800 px-6 py-3 rounded-md mt-6 inline-block">Get Started</a>
        </div>
       </section>
  <!-- Features Section -->
  <section id="features" class="py-20">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold text-green-800 mb-8">Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
                    <i class="fas fa-recycle text-green-500 text-4xl mb-4"></i>
                    <h3 class="text-xl font-semibold">Eco-Friendly Products</h3>
                    <p>Discover a wide range of products that are good for the planet.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
                    <i class="fas fa-shopping-cart text-green-500 text-4xl mb-4"></i>
                    <h3 class="text-xl font-semibold">Easy Shopping</h3>
                    <p>Shop effortlessly with our user-friendly interface.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
                    <i class="fas fa-coins text-green-500 text-4xl mb-4"></i>
                    <h3 class="text-xl font-semibold">GreenCash</h3>
                    <p>Swap Bottles, Save the Earth, Earn Profit!</p>
                </div>
            </div>
        </div>
    </section>
<!-- Promotion Section -->
<section id="new products" class="container mx-auto py-10 px-6">
        <div class="flex justify-between items-center mb-6" >
         <h2 class="text-2xl font-bold text-green-800 mb-8">
          NEW
         </h2>
         <div class="flex space-x-4">
          <a class="text-gray-600 hover:text-gray-900" href="#">
           POPULAR
          </a>
          <a class="text-gray-600 hover:text-gray-900" href="#">
           TOP PICKS
          </a>
         </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
         <div class="border p-4 flex-none transition-transform transform hover:scale-96 hover:shadow-lg">
          <img alt="Product 1" class="w-full" height="200" src="{{ asset('Assets/jurnal.jpg') }}" width="300"/>
          <div class="mt-4">
           <p class="text-red-600">
            Rp. 35.000
           </p>
           <p class="text-gray-600 line-through">
            Rp. 50.000
           </p>
           <h3 class="text-lg font-bold">
            Recycle Paper Notebook
           </h3>
           <p class="text-gray-600">
            NEW ARRIVALS
           </p>
          </div>
         </div>
         <div class="border p-4 flex-none transition-transform transform hover:scale-96 hover:shadow-lg">
         <img alt="Product 2" class="w-full" height="200" src="{{ asset('Assets/case.jpg') }}" width="300"/>
          <div class="mt-4">
           <p class="text-red-600">
            Rp. 25.000
           </p>
           <p class="text-gray-600 line-through">
            Rp. 35.000
           </p>
           <h3 class="text-lg font-bold">
            Case Handphone Earth
           </h3>
           <p class="text-gray-600">
            NEW ARRIVALS
           </p>
          </div>
         </div>
         <div class="border p-4 flex-none transition-transform transform hover:scale-96 hover:shadow-lg">
          <img alt="Product 3" class="w-full" height="200" src="{{ asset('Assets/sepatu insecta.jpg') }}" width="300"/>
          <div class="mt-4">
           <p class="text-red-600">
            Rp. 143.000
           </p>
           <p class="text-gray-600 line-through">
            Rp. 175.000
           </p>
           <h3 class="text-lg font-bold">
            Sepatu Insecta
           </h3>
           <p class="text-gray-600">
            NEW ARRIVALS
           </p>
          </div>
         </div>
         <div class="border p-4 flex-none transition-transform transform hover:scale-96 hover:shadow-lg">
          <img alt="Product 4" class="w-full" height="200" src="{{ asset('Assets/buket bunga.jpg') }}" width= "300"/>
          <div class="mt-4">
           <p class="text-red-600">
            Rp. 150.000
           </p>
           <p class="text-gray-600 line-through">
            Rp. 178.000
           </p>
           <h3 class="text-lg font-bold">
            Buket Perca Batik 
           </h3>
           <p class="text-gray-600">
            NEW ARRIVALS
           </p>
          </div>
         </div>
        </div>
       </section>
    
    <!-- App Promotion Section -->
    <section id="app-promotion" class="py-20 bg-green-100">
        <div class="container mx-auto text-center">
        <hr style="border: none; border-top: 1px solid rgba(0, 0, 0, 0.1); margin: 40px 0;">
            <h2 class="text-3xl font-bold text-green-800 mb-8">Download Our App!</h2>
            <p class="mb-4">Enjoy the ease of sustainable shopping anytime, anywhere.</p>
            <p class="mb-6">Unlock exclusive deals and be the first to discover new arrivals.</p>
            <a href="#" class="bg-green-800 text-white px-6 py-3 rounded-md mt-6 inline-block">Download on the App Store</a>
            <a href="#" class="bg-green-800 text-white px-6 py-3 rounded-md mt-6 inline-block ml-4">Get it on Google Play</a>
        </div>
    </section>
    
 <!-- Footer -->
 <footer class="bg-green-200 text-center py-4">
        <p class="text-green-800">© 2025 RecycleX. All rights reserved.</p>
    </footer>

</body>
</html>
