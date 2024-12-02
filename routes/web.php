<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('search', function() {
    $query = ''; // <-- Change the query for testing.
    // Visit the /search route in your web browser to see products that match the test $query.

    $products = Product::search($query)->get();

    return $products;
});
