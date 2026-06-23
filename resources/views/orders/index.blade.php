<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-slate-950 text-white p-6">

<h1 class="text-2xl font-bold text-green-400 mb-6">
    🧾 Active Orders (Mambuzi POS)
</h1>

<div class="grid grid-cols-3 gap-4">

@forelse($orders as $order)

    <div class="bg-slate-900 border border-slate-800 p-4 rounded-lg">

        <h2 class="text-green-400 font-bold">
            Table {{ $order->table_id }}
        </h2>

        <p class="text-gray-300 mt-2">
            Total: KES {{ $order->total }}
        </p>

        <p class="text-sm text-gray-500 mt-2">
            Status: {{ $order->status }}
        </p>

        @if($order->status == 'open')

            <!-- PAYMENT FORM -->
            <form method="POST" action="/pay-order/{{ $order->id }}" class="mt-3">
                @csrf

                <select class="payment_method w-full p-2 text-black rounded"
        name="payment_method">

    <option value="cash">Cash</option>
    <option value="mpesa">M-Pesa</option>
    <option value="card">Card</option>

</select>

<div class="mpesa_box" style="display:none; margin-top:10px;">

    <input type="text"
           name="phone_number"
           placeholder="254712345678"
           class="w-full p-2 text-black rounded">

</div>

                <button class="bg-green-500 text-black px-3 py-2 mt-2 rounded w-full">
                    Pay & Close Bill
                </button>
            </form>

            <!-- CLOSE TABLE -->
            <a href="/close-table/{{ $order->table_id }}"
               class="bg-red-600 text-white px-3 py-1 rounded mt-3 inline-block">
               Close Table Only
            </a>

        @else

            <p class="text-green-400 mt-2">
                ✔ Paid via {{ $order->payment_method ?? 'N/A' }}
            </p>

            <!-- RECEIPT BUTTON -->
            <a href="/receipt/{{ $order->id }}"
               class="bg-blue-600 text-white px-3 py-2 rounded mt-3 inline-block">
               View Receipt
            </a>

        @endif

    </div>

@empty

    <p class="text-gray-400">
        No active orders yet.
    </p>

@endforelse

</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

   <script>
document.querySelectorAll('.payment_method').forEach(function(select){

    select.addEventListener('change', function(){

        const box = this.parentElement.querySelector('.mpesa_box');

        if(this.value === 'mpesa'){
            box.style.display = 'block';
        } else {
            box.style.display = 'none';
        }

    });

});
</script>

});
</script>
</body>
</html>
