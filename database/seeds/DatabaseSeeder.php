<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        
        factory(App\User::class, 10)->create();
        factory(App\Appointment::class, 10)->create();
        factory(App\Type::class, 2)->create();
        factory(App\Breed::class, 10)->create();
        factory(App\Pet::class, 30)->create();
        factory(App\Reservation::class, 10)->create();
    }
}
