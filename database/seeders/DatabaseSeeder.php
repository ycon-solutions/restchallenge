<?php

namespace Database\Seeders;

use App\Models\User;
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
        // Adding an admin user
        if( User::where('email','=','admin@admin.com')->count() < 1 ) {
            User::create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        }

        $this->call(PermissionsSeeder::class);

        $this->call(UserSeeder::class);
        $this->call(ShipmentSeeder::class);
        $this->call(GpspositionSeeder::class);
    }
}
