<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'first_name' => 'Ricky',
        //     'last_name' => 'Ponting',
        //     'randomid'=>'hcv45f6chs',
        //     'password'=>Hash::make('admin@123'),
        //     'email' => 'ricky@mailinator.com',
        // ]
        // );
        // User::factory()->create([
        //     'first_name' => 'Morgan',
        //     'last_name' => 'White',
        //     'randomid'=>'m4cdg43cji',
        //     'password'=>Hash::make('admin@123'),
        //     'email' => 'white@mailinator.com',
        // ]
        // );
        $this->call([
            RoleSeeder::class,
        ]);
    }
}
