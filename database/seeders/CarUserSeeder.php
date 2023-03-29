<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Car;
use App\Models\User;
use App\Models\CarUser;

class CarUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $used_cars = CarUser::where('is_current', true)->pluck('id');

        foreach($users as $user)
        {

            $current_car = Car::whereNotIn('id', $used_cars)->first();
            if($current_car)
            {
                $user->cars()->attach($current_car->id, ['is_current' => true]);
                $used_cars[] = $current_car->id;
            }
            
            $cars = Car::where('id', '!=', $current_car->id)->inRandomOrder()->take(5)->get();
            foreach($cars as $key => $car)
            {
                $user->cars()->attach($car->id, ['is_current' => false]);
            }
        }
    }
}
