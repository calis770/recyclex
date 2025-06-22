
</head>
 <body class="bg-green-100 font-roboto">
  <header class="bg-green-200 p-4 flex justify-between items-center">
   <div class="flex items-center">
    <a href="{{ route('homeseller') }}" class="flex items-center hover:opacity-80 transition-opacity">
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
    </i>
    <a href="{{ route('profilepage') }}" class="flex items-center">
     <img alt="User profile picture" class="h-10 w-10 rounded-full" height="40" src="{{ asset('Assets/profile.jpg') }}" width="40"/>
     </span>
     </a>
    </div>
   </div>
  </header>

<!-- Tambahkan di dalam <head> -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
