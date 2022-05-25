<?php

namespace Database\Seeders;

use http\Env;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (\config('app.env') == 'prod'){
            $this->call([
                RoleSeeder::class,
            ]);
        } else {
            $this->call([
                RoleSeeder::class,
                TeamSeeder::class,
            ]);
        }
    }
}
