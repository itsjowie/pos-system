<!DOCTYPE html>
<html>
<head>
    <title>Kitchen Screen</title>
      <meta http-equiv="refresh" content="5">

    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        background: linear-gradient(135deg, #0f0f0f, #1c1c2b);
        color: #ffffff;
    }

    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: #141424;
        border-bottom: 1px solid #2a2a3d;
        position: sticky;
        top: 0;
    }

    h1 {
        font-size: 20px;
        margin: 0;
        color: #00e5ff;
    }

    .order {
        background: linear-gradient(145deg, #1b1b2a, #151521);
        margin: 15px;
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.4);
        border-left: 4px solid #00e5ff;
        transition: 0.2s ease;
    }

    .order:hover {
        transform: scale(1.01);
        border-left: 4px solid #ff9800;
    }

    .items {
        margin-top: 10px;
        padding-left: 10px;
        border-left: 2px dashed #333;
    }

    h3 {
        margin: 0;
        color: #ffffff;
    }

    p {
        margin: 5px 0;
        color: #cfcfcf;
    }

    .badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        margin-left: 10px;
    }

    .open {
        background: #ff9800;
        color: black;
    }

    .preparing {
        background: #03a9f4;
        color: black;
    }

    .ready {
        background: #4caf50;
        color: black;
    }

    button {
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        margin-right: 5px;
        font-weight: bold;
    }

    .btn-prep {
        background: #ff9800;
    }

    .btn-ready {
        background: #4caf50;
    }

    form button {
        background: #ff3b3b;
        color: white;
    }
</style>
</head>

<body>

<div class="topbar">
    <h1>🍽 Kitchen Screen</h1>

    <!-- SAFE LOGOUT (POST METHOD) -->
    <form method="POST" action="/logout">
        @csrf
        <button type="submit" style="background:red; color:white;">
            Logout
        </button>
    </form>
</div>

@foreach($orders as $order)

    <div class="order">
        <h3>Order #{{ $order->id }}</h3>
        <p>
    Status:
    
    @if($order->status == 'open')
        <span class="badge open">OPEN</span>
    @elseif($order->status == 'preparing')
        <span class="badge preparing">PREPARING</span>
    @elseif($order->status == 'ready')
        <span class="badge ready">READY</span>
    @endif
</p>

<br>

<a href="/kitchen/preparing/{{ $order->id }}">
    <button class="btn-prep">Start Preparing</button>
</a>

<a href="/kitchen/ready/{{ $order->id }}">
    <button class="btn-ready">Mark Ready</button>
</a>

        <div class="items">
            <h4>Items:</h4>

            @php
                $items = DB::table('order_items')
                    ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
                    ->where('order_items.order_id', $order->id)
                    ->select('menu_items.name', 'order_items.quantity')
                    ->get();
            @endphp

            @foreach($items as $item)
                <p>🍔 {{ $item->name }} x {{ $item->quantity }}</p>
            @endforeach

        </div>
    </div>

@endforeach

@if(count($orders) == 0)
    <p>No orders yet.</p>
@endif

</body>
</html>
