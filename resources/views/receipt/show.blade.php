<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-slate-950 text-white p-6">

<div class="max-w-xl mx-auto bg-slate-900 border border-slate-800 p-6 rounded-lg">

    <h1 class="text-green-400 text-2xl font-bold mb-4">
        🧾 Mambuzi POS Receipt
    </h1>

    <p><strong>Order ID:</strong> {{ $order->id }}</p>
    <p><strong>Table:</strong> {{ $order->table_id }}</p>
    <p><strong>Status:</strong> {{ $order->status }}</p>
    <p><strong>Payment:</strong> {{ $order->payment_method }}</p>
    <p><strong>Paid At:</strong> {{ $order->paid_at }}</p>

    <hr class="my-4 border-slate-700">

    <h2 class="text-green-400 font-bold mb-2">Items</h2>

    @php $total = 0; @endphp

    @forelse($items as $item)

        @php
            $subtotal = $item->price * $item->quantity;
            $total += $subtotal;
        @endphp

        <div class="flex justify-between border-b border-slate-800 py-2">
            <span>{{ $item->name }} x {{ $item->quantity }}</span>
            <span>KES {{ $subtotal }}</span>
        </div>

    @empty
        <p class="text-gray-400">No items found for this order.</p>
    @endforelse

    <div class="mt-4 text-right text-green-400 font-bold text-xl">
        Total: KES {{ $total }}
    </div>

    <button onclick="window.print()"
        class="mt-6 w-full bg-green-500 text-black py-2 rounded">
        Print Receipt
    </button>

</div>

</body>
</html>
