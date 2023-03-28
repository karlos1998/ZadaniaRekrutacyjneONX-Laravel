<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Order;

use App\Models\User;
use App\Models\Client;
use App\Models\Item;
use App\Models\OrderItem;



class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory()
            ->count(30)
            ->hasItems(5
                // OrderItem::factory()
                // ->count(3),
                // 'items'
            )
            ->create();


            // ->afterCreating(function ($order) {
            //     //$order->items()->saveMany(factory(Post::class, 3)->make());
            //     Item::factory()->count(3)->make();
            // });

    }
}
