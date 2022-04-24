<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = Client::factory()->create();
        $faker = \Faker\Factory::create();
        
        $client->contactNumber()->create([
            'contactNumber' => $faker->numerify('09#########')
        ]);

        $client->emailAddress()->create([
            'emailAddress' => $faker->email
        ]);

        $client->organization()->create([
            'name' => $faker->company
        ]);

        $client->addMedia('C:/xampp/htdocs/giatech/public/profile-pictures/default.png')
        ->preservingOriginal()->toMediaCollection('client_profile_picture');
    }
}
