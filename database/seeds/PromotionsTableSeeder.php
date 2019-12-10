<?php

use Illuminate\Database\Seeder;
use App\Promotion;

class PromotionsTableSeeder extends Seeder
{
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Promotion::truncate();
  
        $faker = \Faker\Factory::create();
  
        // And now, let's create a few articles in our database:
        // https://github.com/fzaninotto/Faker
        for ($i = 0; $i < 4; $i++) {
            Promotion::create([
                'promotion_type' => $faker->sentence,
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'price' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 1000),
            ]);
        }
    }
}
