<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuItemController extends Controller
{
    public function index()
    {
        $items = DB::table('menu_items')->get();
        return view('menu-items.index', compact('items'));
    }

    public function create()
    {
        return view('menu-items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'availability' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu-items', 'public');
        }

        DB::table('menu_items')->insert([
            'name' => $request->name,
            'price' => $request->price,
            'availability' => $request->availability,
            'image' => $imagePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/menu-items');
    }

    public function destroy($id)
    {
        DB::table('menu_items')->where('id', $id)->delete();
        return redirect('/menu-items');
    }

    public function addToCart($id)
    {
        $tableId = session('active_table');

        if (!$tableId) {
            return redirect()->back()->with('error', 'Select a table first');
        }

        $item = DB::table('menu_items')->where('id', $id)->first();

        if (!$item) {
            return redirect()->back();
        }

        // FIND OR CREATE ORDER
        $order = DB::table('orders')
            ->where('table_id', $tableId)
            ->where('status', 'open')
            ->first();

        if (!$order) {
            $orderId = DB::table('orders')->insertGetId([
                'table_id' => $tableId,
                'total' => 0,
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $orderId = $order->id;
        }

        // ADD ITEM
        DB::table('order_items')->insert([
            'order_id' => $orderId,
            'menu_item_id' => $item->id,
            'name' => $item->name,
            'price' => $item->price,
            'quantity' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // UPDATE TOTAL
        $total = DB::table('order_items')
            ->where('order_id', $orderId)
            ->sum(DB::raw('price * quantity'));

        DB::table('orders')
            ->where('id', $orderId)
            ->update([
                'total' => $total,
                'updated_at' => now()
            ]);

        return redirect()->back();
    }
}
