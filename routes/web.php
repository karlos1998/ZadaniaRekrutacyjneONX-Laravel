<?php

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


use App\Models\Order;
Route::get('/zadanie1', function () {
    
    /**
     * Info:
     * Zadanie dotyczy stworzenia powiązań pomiędzy modelami, więc pozwoliłem sobie uprościć i "na szybko" wyświetlić zamówienia zwyczajnie tu
     * Bez robienia kontrolera, resource, kolekcji itp :)
     */
    $orders = Order::all();

    foreach($orders as $order )
    {
        echo "Order ID: {$order->id}<br>";

        echo "Client {$order->client_id} -> {$order->client->full_name}<br>";
        echo "User {$order->user_id} -> {$order->user->email} <br>";

        echo "Order items: " . "<br>";

        foreach($order->items as $item) 
        {
            echo "   - {$item->id} -> {$item->name}<br>";
        }

        echo "<hr>";
    }
    dd($orders);
});