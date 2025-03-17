<html>
 <head>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
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
     </i>
    </div>
    <i class="fas fa-shopping-cart text-green-700 text-2xl">
    </i>
    <div class="flex items-center">
     <img alt="User profile picture" class="h-10 w-10 rounded-full" height="40" src="{{ asset('Assets/profile.jpg') }}" width="40"/>
     <span class="ml-2 text-green-700">
      calista zahra
     </span>
    </div>
   </div>
  </header>
  <main class="p-8">
   <h2 class="text-2xl font-bold text-green-700 mb-4">
    Product Detail
   </h2>
   <div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex flex-col md:flex-row">
     <img alt="Totebag Batik" class="w-48 h-48 object-cover rounded-lg mb-4 md:mb-0 md:mr-6" height="150" src="{{ asset('Assets/tas wanita.jpg') }}" width="150"/>
     <div>
      <h3 class="text-2xl font-bold mb-2">
       Totebag Batik
      </h3>
      <p class="text-gray-700 mb-2">
       Terbuat dari kain perca. Cocok untuk dipakai pergi berkuliah.
      </p>
      <div class="flex items-center mb-4">
       <span class="text-lg font-bold text-yellow-500">
        4,9
       </span>
       <i class="fas fa-star text-yellow-500 ml-1">
       </i>
       <span class="text-gray-700 ml-2">
        7rb++ Penilaian
       </span>
       <span class="text-gray-700 ml-4">
        1rb++ Sold
       </span>
      </div>
      <p class="text-red-600 text-xl font-bold mb-4">
       Rp. 54.000,00
      </p>
      <div class="flex items-center mb-4">
       <i class="fas fa-truck text-gray-700 text-2xl mr-2">
       </i>
       <div>
        <p class="text-gray-700">
         Pengiriman ke
        </p>
        <p class="text-gray-700 font-bold">
         KOTA SURABAYA
        </p>
        <p class="text-gray-700">
         Rp0
        </p>
       </div>
      </div>
      <div class="mb-4">
       <p class="text-gray-700 mb-2">
        Variasi
       </p>
       <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
        <button class="border border-gray-300 p-2 rounded-lg flex items-center">
         <img alt="Coklat" class="w-10 h-10 object-cover rounded-lg mr-2" height="50" src="{{ asset('Assets/totebag biru coklat.jpg') }}" width="50"/>
            Coklat
        </button>
        <button class="border border-gray-300 p-2 rounded-lg flex items-center">
         <img alt="Pink" class="w-10 h-10 object-cover rounded-lg mr-2" height="50" src="{{ asset('Assets/totebag pink biru.jpg') }}" width="50"/>
            Pink
        </button>
        <button class="border border-gray-300 p-2 rounded-lg flex items-center">
         <img alt="Biru" class="w-10 h-10 object-cover rounded-lg mr-2" height="50" src="{{ asset('Assets/totebag biru.jpg') }}" width="50"/>
            Biru
        </button>
        <button class="border border-gray-300 p-2 rounded-lg flex items-center">
            <img alt="Hijau" class="w-10 h-10 object-cover rounded-lg mr-2" height="50" src="{{ asset('Assets/totebag hijau biru.jpg') }}" width="50"/>
            Hijau
       </div>
      </div>
      <div class="flex space-x-4">
       <button class="bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
        <i class="fas fa-shopping-cart mr-2">
        </i>
        Add to cart
       </button>
       <button class="bg-green-700 text-white px-4 py-2 rounded-lg">
        Buy Now
       </button>
      </div>
     </div>
    </div>
   </div>
  </main>
 </body>
</html>