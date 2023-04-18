<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        $faker = \Faker\Factory::create();

        // Cria 10 reservas aleatórias para cada usuário
        foreach ($users as $user) {
            for ($i = 0; $i < 10; $i++) {
                Reservation::create([
                    'user_id' => $user->id,
                    'date' => $faker->dateTimeBetween('now', '+1 year'),
                    'time' => $faker->dateTimeBetween('now', '+1 year'),
                    'num_people' => $faker->numberBetween(1, 10),
                    'remarks' => $faker->text()
                ]);
            }
        }
    }
}

