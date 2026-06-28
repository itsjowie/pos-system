<!DOCTYPE html>
<html>
<head>
    <title>Add Inventory Item</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-slate-950 text-white p-8">

<h1 class="text-4xl text-green-400 mb-8">
    ➕ Add Inventory Item
</h1>

<form method="POST" action="/manager/inventory/store"
      class="bg-slate-900 p-6 rounded-xl max-w-lg">

    @csrf

    <label>Item Name</label>
    <input type="text"
           name="name"
           class="w-full p-3 rounded text-black mb-4"
           required>

    <label>Quantity</label>
    <input type="number"
           name="quantity"
           class="w-full p-3 rounded text-black mb-4"
           required>

    <label>Unit</label>
    <input type="text"
           name="unit"
           placeholder="kg, litres, pieces"
           class="w-full p-3 rounded text-black mb-4"
           required>

    <label>Minimum Stock</label>
    <input type="number"
           name="minimum_stock"
           value="5"
           class="w-full p-3 rounded text-black mb-6">

    <button class="bg-green-600 px-6 py-3 rounded-lg">
        Save Item
    </button>

</form>

</body>
</html>
