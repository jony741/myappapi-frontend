<?php

use Illuminate\Database\Seeder;
use App\Provider;

class ProvidersTableSeeder extends Seeder
{
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Provider::truncate();
  
        $faker = \Faker\Factory::create();
  
        // And now, let's create a few articles in our database:
        // https://github.com/fzaninotto/Faker
        for ($i = 0; $i < 20; $i++) {
            Provider::create([
                'occ_id' => $faker->numberBetween($min = 1, $max = 5),
                'title' => $faker->sentence,
                'full_name'=> $faker->name,
                'description' => $faker->paragraph,
                'phone_number' => $faker->e164PhoneNumber,
                'location_id' => $faker->numberBetween($min = 1, $max = 12),
                'providers_availability_id'=>$faker->numberBetween($min = 1, $max = 12),
            ]);
        }
    }
 
}
