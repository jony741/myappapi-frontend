<?php

use Illuminate\Database\Seeder;
use App\promo_providers;

class PromoProvidersTableSeeder extends Seeder
{
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        promo_providers::truncate();
  
        $faker = \Faker\Factory::create();
  
        // And now, let's create a few articles in our database:
        // https://github.com/fzaninotto/Faker
        for ($i = 0; $i < 15; $i++) {
            promo_providers::create([
                'provider_id' => $faker->numberBetween($min = 1, $max = 20),
                'promotion_id' => $faker->numberBetween($min = 1, $max = 4),
                'expirey_date' => $faker->dateTime(),
            ]);
        }
    }
 
}
