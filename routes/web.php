<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuItemController;

/*
|--------------------------------------------------------------------------
| Web Routes (Mambuzi EATS & DINE POS)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
| Dashboard
*/
use Illuminate\Support\Facades\DB;

Route::get('/dashboard', function () {

    $tables = DB::table('restaurant_tables')->get();

    return view('dashboard', compact('tables'));

})->middleware(['auth', 'verified'])->name('dashboard');

/*
| Menu Management (POS CORE)
*/
Route::resource('menu-items', MenuItemController::class)->middleware(['auth']);

/*
| Profile (Laravel default)
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/login-success', function () {
    return view('auth.success');
})->middleware('auth');

require __DIR__.'/auth.php';
