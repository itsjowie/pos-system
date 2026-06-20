<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mambuzi POS Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-950 text-white flex h-screen">

    <!-- LEFT SIDEBAR -->
    <div class="w-64 bg-gradient-to-b from-slate-900 via-slate-950 to-black flex flex-col">

        <!-- LOGO -->
        <div class="p-5 border-b border-slate-800 flex items-center gap-3">
            <img src="/logo/mambuzi-logo.png"
                 class="h-12 w-12 object-contain rounded">

            <span class="text-green-400 font-bold text-lg">
                Mambuzi POS
            </span>
        </div>

        <!-- NAVIGATION -->
        <a href="/dashboard" class="p-4 hover:bg-gray-800">
            Dashboard
        </a>

        <a href="/menu-items" class="p-4 hover:bg-gray-800">
            Menu Items
        </a>

        <a href="/orders" class="p-4 hover:bg-gray-800">
            Orders
        </a>

        <a href="/orders" class="p-4 hover:bg-gray-800">
            Payments
        </a>

        <!-- LOGOUT -->
        <form method="POST"
              action="{{ route('logout') }}"
              class="mt-auto">
            @csrf

            <button class="w-full text-left p-4 bg-red-700 hover:bg-red-600">
                Logout
            </button>
        </form>

    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col">

        <!-- TOP BAR -->
        <div class="bg-slate-900/60 backdrop-blur border-b border-slate-800 p-4 flex justify-between">

            <h1 class="font-bold text-green-400">
                Dashboard
            </h1>

            @if(session('active_table'))
                <div class="text-green-400 font-bold">
                    Serving Table: {{ session('active_table') }}
                </div>
            @else
                <div class="text-gray-400">
                    No table selected
                </div>
            @endif

        </div>

        <!-- TABLES -->
        <div class="p-6">

            <h2 class="text-xl font-bold text-green-400 mb-4">
                Restaurant Tables
            </h2>

            <div class="grid grid-cols-3 gap-4">

                @foreach($tables as $table)

                    @if($table->status == 'occupied')

                        <div class="p-4 rounded-lg border border-red-500 bg-red-900">

                            <div class="font-bold text-white">
                                {{ $table->table_number }}
                            </div>

                            <div class="text-sm text-red-200 mt-1">
                                Occupied
                            </div>

                            <div class="text-xs mt-2 text-red-300">
                                🔴 Customer Dining
                            </div>

                        </div>

                    @elseif(session('active_table') == $table->id)

                        <div class="p-4 rounded-lg border border-green-400 bg-green-600">

                            <div class="font-bold text-white">
                                {{ $table->table_number }}
                            </div>

                            <div class="text-sm mt-1">
                                {{ $table->status }}
                            </div>

                            <div class="text-xs mt-2">
                                🟢 Active Table
                            </div>

                        </div>

                    @else

                        <a href="/select-table/{{ $table->id }}"
                           class="block p-4 rounded-lg border border-slate-800 bg-slate-900 hover:bg-slate-800">

                            <div class="font-bold text-white">
                                {{ $table->table_number }}
                            </div>

                            <div class="text-sm text-gray-300 mt-1">
                                {{ $table->status }}
                            </div>

                            <div class="text-xs mt-2">
                                Tap to select
                            </div>

                        </a>

                    @endif

                @endforeach

            </div>

        </div>

    </div>

</body>
</html>
