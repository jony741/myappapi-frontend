<?php

use App\Providers_cat;
use Illuminate\Database\Seeder;

class ProviderCatSeeder extends Seeder
{
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Providers_cat::truncate();
  
        $faker = \Faker\Factory::create();
  
        // And now, let's create a few articles in our database:
        // https://github.com/fzaninotto/Faker
        for ($i = 0; $i < 40; $i++) {
            Providers_cat::create([
                'provider_id' => $faker->numberBetween($min = 1, $max = 20),
                'cat_id' => $faker->numberBetween($min = 1, $max = 10),
            ]);
        }
    }
}
