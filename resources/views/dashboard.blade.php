<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mambuzi POS Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-950 text-white">

<div class="flex h-screen">

    <!-- LEFT SIDEBAR -->
    <div class="w-64 bg-gradient-to-b from-slate-900 via-slate-950 to-black flex flex-col">

        <!-- LOGO -->
        <div class="p-5 border-b border-slate-800 flex items-center gap-3">
            <img src="/logo/mambuzi-logo.png" class="h-12 w-12 object-contain rounded">

            <span class="text-green-400 font-bold text-lg">
                Mambuzi EATS & DINE
            </span>
        </div>

        <a href="/dashboard" class="p-4 hover:bg-gray-800">Dashboard</a>
        <a href="/menu-items" class="p-4 hover:bg-gray-800">Menu Items</a>
        <a href="#" class="p-4 hover:bg-gray-800">Orders</a>
        <a href="#" class="p-4 hover:bg-gray-800">Payments</a>

        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
            @csrf
            <button class="w-full text-left p-4 hover:bg-red-600 bg-red-700">
                Logout
            </button>
        </form>

    </div>

    <!-- MAIN AREA -->
    <div class="flex-1 flex flex-col">

        <!-- TOP BAR -->
        <div class="bg-slate-900/60 backdrop-blur border-b border-slate-800 p-4 flex justify-between">
            <h1 class="font-bold">Dashboard</h1>
            <div>Welcome</div>
        </div>

        <!-- CONTENT -->
        <div class="p-6">

            <h2 class="text-xl font-bold text-green-400 mb-4">
                Restaurant Tables
            </h2>

            <div class="grid grid-cols-3 gap-4">

                @foreach($tables as $table)
                    <div class="bg-slate-900 border border-slate-800 p-4 rounded-lg hover:bg-slate-800 cursor-pointer">
                        <h3 class="text-green-400 font-bold">
                            {{ $table->table_number }}
                        </h3>

                        <p class="text-sm text-gray-400">
                            Status: {{ $table->status }}
                        </p>
                    </div>
                @endforeach

            </div>

        </div>

    </div>

</div>

</body>
</html>
