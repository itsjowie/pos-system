<!DOCTYPE html>
<html>
<head>
    <title>Manager Dashboard</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-slate-950 text-white p-8">

<form method="POST" action="/logout" class="float-right">
    @csrf
    <button class="bg-red-600 px-4 py-2 rounded-lg">
        Logout
    </button>
</form>

<h1 class="text-4xl font-bold text-cyan-400 mb-8">
    📊 Manager Dashboard
</h1>

<div class="flex gap-3 mb-6">

    <a href="/manager/sales"
       class="bg-green-600 px-4 py-2 rounded-lg">
        📈 Sales Reports
    </a>

    <a href="/manager/inventory"
       class="bg-purple-600 px-4 py-2 rounded-lg">
        📦 Inventory
    </a>

</div>
</a>
   

<div class="grid grid-cols-2 gap-6">

    <div class="bg-slate-900 border border-green-500 p-6 rounded-xl">
        <h2 class="text-green-400 text-xl">
            💰 Total Sales
        </h2>

        <p class="text-3xl font-bold mt-4">
            KES {{ number_format($totalSales) }}
        </p>
    </div>

    <div class="bg-slate-900 border border-blue-500 p-6 rounded-xl">
        <h2 class="text-blue-400 text-xl">
            🧾 Total Orders
        </h2>

        <p class="text-3xl font-bold mt-4">
            {{ $totalOrders }}
        </p>
    </div>

    <div class="bg-slate-900 border border-yellow-500 p-6 rounded-xl">
        <h2 class="text-yellow-400 text-xl">
            🍽 Active Orders
        </h2>

        <p class="text-3xl font-bold mt-4">
            {{ $openOrders }}
        </p>
    </div>

    <div class="bg-slate-900 border border-purple-500 p-6 rounded-xl">
        <h2 class="text-purple-400 text-xl">
            🪑 Restaurant Tables
        </h2>

        <p class="text-3xl font-bold mt-4">
            {{ $totalTables }}
        </p>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="bg-slate-900 border border-green-500 p-6 rounded-xl mt-8">
    <h2 class="text-green-400 text-2xl mb-4">
        📈 Weekly Sales Trend
    </h2>

    <canvas id="salesChart"></canvas>
</div>
<div class="bg-slate-900 border border-purple-500 p-6 rounded-xl mt-8">
    <h2 class="text-purple-400 text-2xl mb-4">
        💳 Payment Methods
    </h2>

    <canvas id="paymentChart"></canvas>
</div>
<script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('salesChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
        datasets: [{
            label: 'Sales',
            data: [2000,3500,5000,4200,6800,7200,9000],
            borderColor: '#22c55e',
            backgroundColor: 'rgba(34,197,94,0.2)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    color: 'white'
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: 'white'
                }
            },
            y: {
                ticks: {
                    color: 'white'
                }
            }
        }
    }
});

const paymentCtx = document.getElementById('paymentChart');

new Chart(paymentCtx, {
    type: 'doughnut',
    data: {
        labels: ['Cash', 'M-Pesa', 'Card'],
        datasets: [{
            data: [40,45,15],
            backgroundColor: [
                '#facc15',
                '#a855f7',
                '#3b82f6'
            ]
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    color: 'white'
                }
            }
        }
    }
});
</script>

</body>
</html>
</script>
</body>
</html>
