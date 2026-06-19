<!DOCTYPE html>
<html>
<head>
    <title>Menu Items</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-950 text-white p-6">

    <h1 class="text-2xl font-bold text-green-400 mb-4">
        🍔 Menu Items (Mambuzi POS)
    </h1>

    <a href="/menu-items/create"
       class="bg-green-500 text-black px-4 py-2 rounded">
        + Add Item
    </a>

    <div class="mt-6">

        <table class="w-full text-left border border-slate-700">

            <thead>
                <tr class="border-b border-slate-700 text-green-400">
                    <th class="p-2">Image</th>
                         <th class="p-2">Name</th>
                         <th class="p-2">Price</th>
                         <th class="p-2">Availability</th>
                         <th class="p-2">Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($items as $item)

                    <tr class="border-b border-slate-800">
                      <td class="p-2">
    @if($item->image)
        <img
            src="{{ asset('storage/' . $item->image) }}"
            class="w-16 h-16 rounded object-cover"
        >
    @else
        <span class="text-gray-500">
            No Image
        </span>
    @endif
</td>

                        <td class="p-2">
                            {{ $item->name }}
                        </td>

                        <td class="p-2">
                            {{ $item->price }}
                        </td>

                        <td class="p-2">
                            {{ $item->availability }}
                        </td>

                        <td class="p-2">
                            <form action="/menu-items/{{ $item->id }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button
                                    onclick="return confirm('Delete this item?')"
                                    class="bg-red-600 hover:bg-red-500 px-3 py-1 rounded"
                                >
                                    Delete
                                </button>
                            </form>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="p-4 text-gray-400">
                            No menu items found
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</body>
</html>
