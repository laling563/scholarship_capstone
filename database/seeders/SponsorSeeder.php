<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sponsor;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sponsor::create([
            'sponsor_name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password'),
        ]);

        Sponsor::create([
            'sponsor_name' => 'Jane Smith',
            'username' => 'janesmith',
            'email' => 'janesmith@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
