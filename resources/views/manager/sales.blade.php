<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-slate-950 text-white p-8">

<a href="/manager"
   class="bg-blue-600 px-4 py-2 rounded">
    ← Dashboard
</a>

<h1 class="text-4xl text-green-400 font-bold mt-6 mb-8">
    📊 Sales Report
</h1>

<div class="grid grid-cols-2 gap-6">

    <div class="bg-slate-900 p-6 rounded-xl border border-green-500">
        <h2>Today's Sales</h2>
        <p class="text-3xl mt-3">
            KES {{ number_format($todaySales) }}
        </p>
    </div>

    <div class="bg-slate-900 p-6 rounded-xl border border-blue-500">
        <h2>Cash Sales</h2>
        <p class="text-3xl mt-3">
            KES {{ number_format($cashSales) }}
        </p>
    </div>

    <div class="bg-slate-900 p-6 rounded-xl border border-purple-500">
        <h2>M-Pesa Sales</h2>
        <p class="text-3xl mt-3">
            KES {{ number_format($mpesaSales) }}
        </p>
    </div>

    <div class="bg-slate-900 p-6 rounded-xl border border-yellow-500">
        <h2>Card Sales</h2>
        <p class="text-3xl mt-3">
            KES {{ number_format($cardSales) }}
        </p>
    </div>

</div>

<div class="bg-slate-900 p-6 rounded-xl border border-cyan-500 mt-6">
    <h2>Total Paid Orders</h2>

    <p class="text-3xl mt-3">
        {{ $paidOrders }}
    </p>
</div>

</body>
</html>
