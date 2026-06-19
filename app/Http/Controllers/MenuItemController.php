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
}
