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

use App\Models\User;
Route::get('/zadanie2', function () {
    
    $users = User::all();

    foreach($users as $user)
    {
        echo "User {$user->id} -> {$user->email}<br>";

        echo "Cars:<br>";
        foreach($user->cars as $car)
        {
            echo "- {$car->id} -> ({$car->plate}) {$car->brand}";
            echo "<br>";
        }
        $current_car = $user->cars()->wherePivot('is_current', true)->first();
        if($current_car)
        {
            echo "Current Car:  " . $current_car->plate;
        }

        echo "<hr>";
    }
});

