<!DOCTYPE html>
<html>
<head>
    <title>Add Menu Item</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-slate-950 text-white p-6">

    <h1 class="text-2xl text-green-400 mb-4">
        Add Menu Item
    </h1>

    <form method="POST" action="/menu-items" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <input
            type="text"
            name="name"
            placeholder="Food Name"
            class="w-full p-2 text-black rounded"
            required
        >

        <input
            type="number"
            step="0.01"
            name="price"
            placeholder="Price"
            class="w-full p-2 text-black rounded"
            required
        >

        <select
            name="availability"
            class="w-full p-2 text-black rounded"
        >
            <option value="available">Available</option>
            <option value="out_of_stock">Out of Stock</option>
        </select>

        <div>
            <label class="block mb-2">Food Image</label>
            <input
                type="file"
                name="image"
                class="w-full p-2 border border-slate-700 rounded"
            >
        </div>

        <button
            type="submit"
            class="bg-green-500 hover:bg-green-400 text-black px-4 py-2 rounded"
        >
            Save Item
        </button>

    </form>

</body>
</html>
