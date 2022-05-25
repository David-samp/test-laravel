<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //David
        $david = User::updateOrCreate([
            'first_name' => 'Admin',
            'last_name' => 'test',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $david->assignRole('admin');
    }
}
