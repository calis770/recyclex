<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   RecycleX
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
  <style>
   body {
            font-family: 'Roboto', sans-serif;
        }
  </style>
 </head>
 <body class="bg-green-100">
  <header class="bg-green-200 p-4 flex justify-between items-center">
   <div class="flex items-center">
    <img alt="{{ asset('Assets/logo.png') }}" class="h-12 w-12" height="50" src="{{ asset('Assets/logo.png') }}" width="50"/>
    <div class="ml-2">
     <a class="text-green-800 underline" href="#">
      Download RecycleX App
     </a>
     <h1 class="text-2xl font-bold text-green-800">
      RecycleX
     </h1>
    </div>
</div>
<div class="flex items-center">
 <input class="border border-green-800 rounded-full px-4 py-2" placeholder="Search" type="text"/>
 <i class="fas fa-search text-green-800 ml-2">
 </i>
</div>
<div class="flex items-center">
    <span class="text-green-800 text-xl mr-4">🛒</span>
 </i>
 <div class="flex items-center">
  <img alt="User avatar" class="h-10 w-10 rounded-full" height="40" src="{{ asset('Assets/profile.jpg') }}" width="40"/>
  <span class="ml-2 text-green-800">
   Calista Zahra
  </span>
 </div>
</div>
</header>
<main class="p-4">
<section class="bg-white p-4 rounded-lg shadow-md mb-8">
 <h2 class="text-2xl font-bold text-green-800 mb-4">
  Category
 </h2>
 <div class="flex space-x-4 overflow-x-auto">
  <div class="flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
   <img alt="Pakaian Wanita" class="w-48 h-72 object-cover rounded-lg" height="300" src="{{ asset('Assets/pakaian wanita.jpg') }}" width="200"/>
   <p class="text-center mt-2">
    Pakaian Wanita
   </p>
  </div>
  <div class="flex-none flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
   <img alt="Aksesoris Rumah" class="w-48 h-72 object-cover rounded-lg" height="300" src="{{ asset('Assets/aksesoris.png') }}" width="200"/>
   <p class="text-center mt-2">
    Aksesoris Rumah
   </p>
  </div>
  <div class="flex-none flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
   <img alt="Tas Wanita" class="w-48 h-72 object-cover rounded-lg" height="300" src="{{ asset('Assets/tas wanita.jpg') }}" width="200"/>
   <p class="text-center mt-2">
    Tas Wanita
   </p>
  </div>
  <div class="flex-none flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
   <img alt="Perlengkapan Rumah" class="w-48 h-72 object-cover rounded-lg" height="300" src="{{ asset('Assets/perlengkapan rumah.webp') }}" width="200"/>
   <p class="text-center mt-2">
    Perlengkapan Rumah
   </p>
  </div>
 </div>
</section>
<section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
 <div class="bg-white p-4 rounded-lg shadow-md flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
  <img alt="Scrunche Flower" class="w-full h-48 object-cover rounded-lg" height="200" src="{{ asset('Assets/scrunchie bunga.jpg') }}" width="200"/>
  <div class="mt-2">
   <h3 class="text-lg font-bold">
    Scrunchie Flower
   </h3>
   <p class="text-green-800">
    Rp. 9,000.00
   </p>
   <div class="flex items-center text-sm text-gray-600">
    <i class="fas fa-star text-yellow-500">
    </i>
    <span class="ml-1">
     4.8
    </span>
    <span class="ml-2">
     50rb+ terjual
    </span>
    <span class="ml-2">
     UMKM Rotu Mulyo
    </span>
   </div>
  </div>
 </div>
 <div class="bg-white p-4 rounded-lg shadow-md flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
  <img alt="Totebag Batik" class="w-full h-48 object-cover rounded-lg" height="200" src="https://storage.googleapis.com/a1aa/image/8Bl30NHY684g3I2FkkEOlbGwHYtiGchN652GRXl31Sg.jpg" width="200"/>
  <div class="mt-2">
   <h3 class="text-lg font-bold">
    Totebag Batik
   </h3>
   <p class="text-green-800">
    Rp. 54,000.00
   </p>
   <div class="flex items-center text-sm text-gray-600">
    <i class="fas fa-star text-yellow-500">
    </i>
    <span class="ml-1">
     4.8
    </span>
    <span class="ml-2">
     15rb+ terjual
    </span>
    <span class="ml-2">
     UMKM Putri
    </span>
   </div>
  </div>
 </div>
 </div>
 <div class="bg-white p-4 rounded-lg shadow-md flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
  <img alt="Lampu Gantung" class="w-full h-48 object-cover rounded-lg" height="200" src="{{ asset('Assets/lampu gantung.png') }}" width="200"/>
  <div class="mt-2">
   <h3 class="text-lg font-bold">
    Lampu Gantung
   </h3>
   <p class="text-green-800">
    Rp. 45,000.00
   </p>
   <div class="flex items-center text-sm text-gray-600">
    <i class="fas fa-star text-yellow-500">
    </i>
    <span class="ml-1">
     4.8
    </span>
    <span class="ml-2">
     5rb+ terjual
    </span>
    <span class="ml-2">
     UMKM Wosata
    </span>
   </div>
  </div>
 </div>
 <div class="bg-white p-4 rounded-lg shadow-md flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
  <img alt="Wadah Aksesoris" class="w-full h-48 object-cover rounded-lg" height="200" src="{{ asset('Assets/wadah aksesoris.jpg') }}" width="200"/>
  <div class="mt-2">
   <h3 class="text-lg font-bold">
    Wadah Aksesoris
   </h3>
   <p class="text-green-800">
    Rp. 35,000.00
   </p>
   <div class="flex items-center text-sm text-gray-600">
    <i class="fas fa-star text-yellow-500">
    </i>
    <span class="ml-1">
     4.8
    </span>
    <span class="ml-2">
     8rb+ terjual
    </span>
    <span class="ml-2">
     UMKM Juara
    </span>
   </div>
  </div>
 </div>
 <div class="bg-white p-4 rounded-lg shadow-md flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
  <img alt="Outer Patchwork" class="w-full h-48 object-cover rounded-lg" height="200" src="{{ asset('Assets/outer patchwork.jpg') }}" width="200"/>
  <div class="mt-2">
   <h3 class="text-lg font-bold">
    Outer Patchwork 
   </h3>
   <p class="text-green-800">
    Rp. 135,000.00
   </p>
   <div class="flex items-center text-sm text-gray-600">
    <i class="fas fa-star text-yellow-500">
    </i>
    <span class="ml-1">
     4.8
    </span>
    <span class="ml-2">
     10rb+ terjual
    </span>
    <span class="ml-2">
     UMKM Aksiku
    </span>
   </div>
  </div>
 </div>
 </div>
 <div class="bg-white p-4 rounded-lg shadow-md flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
  <img alt="Ransel Jeans" class="w-full h-48 object-cover rounded-lg" height="200" src="{{ asset('Assets/ransel perca.avif') }}" width="200"/>
  <div class="mt-2">
   <h3 class="text-lg font-bold">
    Ransel Jeans
   </h3>
   <p class="text-green-800">
    Rp. 185,000.00
   </p>
   <div class="flex items-center text-sm text-gray-600">
    <i class="fas fa-star text-yellow-500">
    </i>
    <span class="ml-1">
     4.8
    </span>
    <span class="ml-2">
     5rb+ terjual
    </span>
    <span class="ml-2">
     Daur Kreatif
    </span>
   </div>
  </div>
 </div>
 <div class="bg-white p-4 rounded-lg shadow-md flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
  <img alt="Sarung Bantal" class="w-full h-48 object-cover rounded-lg" height="200" src="{{ asset('Assets/sarung bantal.jpg') }}" width="200"/>
  <div class="mt-2">
   <h3 class="text-lg font-bold">
    Sarung Bantal
   </h3>
   <p class="text-green-800">
    Rp.56,000.00
   </p>
   <div class="flex items-center text-sm text-gray-600">
    <i class="fas fa-star text-yellow-500">
    </i>
    <span class="ml-1">
     4.8
    </span>
    <span class="ml-2">
     30rb+ terjual
    </span>
    <span class="ml-2">
     Hijau Kaya
    </span>
   </div>
  </div>
 </div>
 <div class="bg-white p-4 rounded-lg shadow-md flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
  <img alt="Recycle Paper" class="w-full h-48 object-cover rounded-lg" height="200" src="{{ asset('Assets/recycle paper.jpg') }}" width="200"/>
  <div class="mt-2">
   <h3 class="text-lg font-bold">
      Recycle Paper
   </h3>
   <p class="text-green-800">
    Rp. 6,000.00
   </p>
   <div class="flex items-center text-sm text-gray-600">
    <i class="fas fa-star text-yellow-500">
    </i>
    <span class="ml-1">
     4.8
    </span>
    <span class="ml-2">
     10rb+ terjual
    </span>
    <span class="ml-2">
     UMKM Siti
    </span>
   </div>
  </div>
 </div>
 </div>
 </div>
 <div class="bg-white p-4 rounded-lg shadow-md flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
  <img alt="Dompet Koin" class="w-full h-48 object-cover rounded-lg" height="200" src="{{ asset('Assets/dompet koin.jpg') }}" width="200"/>
   <h3 class="text-lg font-bold">
    Dompet Koin
   </h3>
   <p class="text-green-800">
    Rp. 50,000.00
   </p>
   <div class="flex items-center text-sm text-gray-600">
    <i class="fas fa-star text-yellow-500">
    </i>
    <span class="ml-1">
     4.8
    </span>
    <span class="ml-2">
     10rb+ terjual
    </span>
    <span class="ml-2">
     UMKM Alam
    </span>
   </div>
  </div>
 </div>
 <div class="bg-white p-4 rounded-lg shadow-md flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
  <img alt="Selimut Bunga" class="w-full h-48 object-cover rounded-lg" height="200" src="{{ asset('Assets/selimut bunga.png') }}" width="200"/>
  <div class="mt-2">
   <h3 class="text-lg font-bold">
    Selimut Bunga
   </h3>
   <p class="text-green-800">
    Rp. 155,000.00
   </p>
   <div class="flex items-center text-sm text-gray-600">
    <i class="fas fa-star text-yellow-500">
    </i>
    <span class="ml-1">
     4.8
    </span>
    <span class="ml-2">
     15rb+ terjual
    </span>
    <span class="ml-2">
     Sirkus Hijau
    </span>
   </div>
  </div>
 </div>
 <div class="bg-white p-4 rounded-lg shadow-md flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
  <img alt="Pot Hewan Lucu" class="w-full h-48 object-cover rounded-lg" height="100" src="{{ asset('Assets/pot.jpg') }}" width="200"/>
  <div class="mt-2">
   <h3 class="text-lg font-bold">
    Pot Hewan Lucu 
   </h3>
   <p class="text-green-800">
    Rp. 25,000.00
   </p>
   <div class="flex items-center text-sm text-gray-600">
    <i class="fas fa-star text-yellow-500">
    </i>
    <span class="ml-1">
     4.8
    </span>
    <span class="ml-2">
     7rb+ terjual
    </span>
    <span class="ml-2">
     UMKM Meraki
    </span>
   </div>
  </div>
 </div>
 </div>
</section>
</main>
 </body>
</html>
