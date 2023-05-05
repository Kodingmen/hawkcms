<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Core\Database\Seeders\CitiesDistrictsWardsSeeder;
use App\Core\Database\Seeders\CountriesSeeder;
use App\Core\Database\Seeders\StatesTableSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Cache::flush();
        Model::unguard();
        $this->call(CitiesDistrictsWardsSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(StatesTableSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
