<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->truncate();

        DB::table('role')->insert(
            [
                [
                    'name' => 'Admin'
                ],
                [
                    'name' => 'User'
                ],
            ]
        );
    }
}
