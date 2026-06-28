<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuItemController;
use App\Models\Inventory;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $tables = DB::table('restaurant_tables')->get();

    return view('dashboard', compact('tables'));

})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| MENU ITEMS (POS CORE)
|--------------------------------------------------------------------------
*/

Route::resource('menu-items', MenuItemController::class)
    ->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| CART SYSTEM
|--------------------------------------------------------------------------
*/

Route::get('/add-to-cart/{id}', [MenuItemController::class, 'addToCart'])
    ->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| ORDERS VIEW
|--------------------------------------------------------------------------
*/

Route::get('/orders', function () {

    $orders = DB::table('orders')
        ->whereIn('status', ['open', 'preparing', 'ready'])
        ->get();

    return view('orders.index', compact('orders'));

})->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| PAY ORDER
|--------------------------------------------------------------------------
*/

Route::post('/pay-order/{orderId}', function ($orderId) {

    $method = request('payment_method');

    $order = DB::table('orders')->where('id', $orderId)->first();

    if (!$order) {
         return redirect('/orders');
    }
$orderItems = DB::table('order_items')
    ->where('order_id', $orderId)
    ->get();

foreach ($orderItems as $item) {

    DB::table('inventory')
        ->where('name', $item->name)
        ->decrement('quantity', $item->quantity);
}
    DB::table('orders')
        ->where('id', $orderId)
        ->update([
            'status' => 'paid',
            'payment_method' => $method,
            'paid_at' => now(),
            'updated_at' => now()
        ]);

    DB::table('restaurant_tables')
        ->where('id', $order->table_id)
        ->update([
            'status' => 'free',
            'updated_at' => now()
        ]);

    session()->forget('active_table');

    return redirect('/receipt/' . $orderId);

})->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| CLOSE TABLE
|--------------------------------------------------------------------------
*/

Route::get('/close-table/{tableId}', function ($tableId) {

    $order = DB::table('orders')
        ->where('table_id', $tableId)
        ->whereIn('status', ['open', 'preparing', 'ready'])
        ->first();

    if ($order) {
        DB::table('orders')
            ->where('id', $order->id)
            ->update([
                'status' => 'paid',
                'updated_at' => now()
            ]);
    }

    DB::table('restaurant_tables')
        ->where('id', $tableId)
        ->update([
            'status' => 'free',
            'updated_at' => now()
        ]);

    session()->forget('active_table');

    return redirect('/dashboard');

})->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| TABLE SELECTION
|--------------------------------------------------------------------------
*/

Route::get('/select-table/{id}', function ($id) {

    session(['active_table' => $id]);

    return redirect()->route('dashboard');

})->middleware(['auth', 'verified']);

/*
|--------------------------------------------------------------------------
| RECEIPT SYSTEM
|--------------------------------------------------------------------------
*/

Route::get('/receipt/{orderId}', function ($orderId) {

    $order = DB::table('orders')
        ->where('id', $orderId)
        ->first();

    if (!$order) {
        abort(404);
    }

    $items = DB::table('order_items')
        ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
        ->where('order_items.order_id', $orderId)
        ->select(
            'menu_items.name',
            'order_items.price',
            'order_items.quantity'
        )
        ->get();

    return view('receipt.show', compact('order', 'items'));

})->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| LOGIN SUCCESS
|--------------------------------------------------------------------------
*/

Route::get('/login-success', function () {
    return view('auth.success');
})->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

Route::get('/kitchen', function () {

    if (!Auth::check()) {
        return redirect('/login');
    }

    if (Auth::user()->user_type !== 'kitchen') {
        abort(403);
    }

    $orders = DB::table('orders')
    ->whereIn('status', [
        'open',
        'preparing',
        'ready'
    ])
    ->latest()
    ->get();

    return view('kitchen.index', compact('orders'));
});
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/kitchen/preparing/{id}', function ($id) {

    DB::table('orders')
        ->where('id', $id)
        ->update([
            'status' => 'preparing',
            'updated_at' => now()
        ]);

    return back();
});

Route::get('/kitchen/ready/{id}', function ($id) {

    DB::table('orders')
        ->where('id', $id)
        ->update([
            'status' => 'ready',
            'updated_at' => now()
        ]);

    return back();
});
Route::post('/complete-order/{id}', function ($id) {

    $order = DB::table('orders')
        ->where('id', $id)
        ->first();

    if (!$order) {
        return redirect('/dashboard');
    }

    DB::table('orders')
        ->where('id', $id)
        ->update([
            'status' => 'completed',
            'updated_at' => now()
        ]);

    DB::table('restaurant_tables')
        ->where('id', $order->table_id)
        ->update([
            'status' => 'free',
            'updated_at' => now()
        ]);

    session()->forget('active_table');

    return redirect('/dashboard');

})->middleware(['auth']);
Route::get('/manager', function () {

    if (!Auth::check()) {
        return redirect('/login');
    }

    if (Auth::user()->user_type !== 'manager') {
        abort(403);
    }

    $totalSales = DB::table('orders')
        ->where('status', 'paid')
        ->sum('total');

    $totalOrders = DB::table('orders')->count();

    $openOrders = DB::table('orders')
        ->whereIn('status', ['open', 'preparing', 'ready'])
        ->count();

    $totalTables = DB::table('restaurant_tables')
        ->count();

    return view('manager.index', compact(
        'totalSales',
        'totalOrders',
        'openOrders',
        'totalTables'
    ));

});

Route::get('/manager/sales', function () {

    if (!Auth::check()) {
        return redirect('/login');
    }

    if (Auth::user()->user_type !== 'manager') {
        abort(403);
    }

    $todaySales = DB::table('orders')
        ->where('status', 'paid')
        ->whereDate('updated_at', today())
        ->sum('total');

    $cashSales = DB::table('orders')
        ->where('status', 'paid')
        ->where('payment_method', 'cash')
        ->sum('total');

    $mpesaSales = DB::table('orders')
        ->where('status', 'paid')
        ->where('payment_method', 'mpesa')
        ->sum('total');

    $cardSales = DB::table('orders')
        ->where('status', 'paid')
        ->where('payment_method', 'card')
        ->sum('total');

    $paidOrders = DB::table('orders')
        ->where('status', 'paid')
        ->count();

    return view('manager.sales', compact(
        'todaySales',
        'cashSales',
        'mpesaSales',
        'cardSales',
        'paidOrders'
    ));

})->middleware('auth');


Route::get('/manager/inventory', function () {

    if (!Auth::check()) {
        return redirect('/login');
    }

    if (Auth::user()->user_type !== 'manager') {
        abort(403);
    }

    $items = Inventory::all();

    return view('manager.inventory', compact('items'));
});
Route::get('/manager/inventory/create', function () {

    return view('manager.add_inventory');

})->middleware('auth');

Route::post('/manager/inventory/store', function (\Illuminate\Http\Request $request) {

    Inventory::create([
        'name' => $request->name,
        'quantity' => $request->quantity,
        'unit' => $request->unit,
        'minimum_stock' => $request->minimum_stock,
    ]);

    return redirect('/manager/inventory');

})->middleware('auth');
require __DIR__.'/auth.php';
