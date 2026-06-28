<!DOCTYPE html>
<html>
<head>
    <title>Inventory Management</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-slate-950 text-white p-8">

<h1 class="text-4xl font-bold text-cyan-400 mb-8">
    📦 Inventory Management
</h1>
<a href="/manager/inventory/create"
   class="bg-green-600 px-4 py-2 rounded-lg">
    ➕ Add Item
</a>

<a href="/manager"
   class="bg-blue-600 px-4 py-2 rounded-lg">
    ← Dashboard
</a>

<div class="mt-8">

@forelse($items as $item)

<div class="bg-slate-900 border border-slate-700 p-4 rounded-xl mb-4">

    <h2 class="text-2xl text-green-400">
        {{ $item->name }}
    </h2>

    <p>
        Quantity: {{ $item->quantity }}
        {{ $item->unit }}
    </p>

    @if($item->quantity <= $item->minimum_stock)

        <p class="text-red-400 font-bold">
            ⚠ Low Stock
        </p>

    @else

        <p class="text-green-400">
            ✅ In Stock
        </p>

    @endif

</div>

@empty

<p class="text-gray-400">
    No inventory items yet.
</p>

@endforelse

</div>

</body>
</html>
