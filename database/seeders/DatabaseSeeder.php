<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\County;
use App\Models\City;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Teszt felhasználó a bejelentkezéshez (ha még nincs)
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'user',
                'password' => bcrypt('12345678'),
            ]
        );

        // 2. Megyék és városok feltöltése
        $pest = County::create(['name' => 'Pest']);
        City::create(['county_id' => $pest->id, 'name' => 'Vác']);
        City::create(['county_id' => $pest->id, 'name' => 'Szentendre']);
        City::create(['county_id' => $pest->id, 'name' => 'Gödöllő']);

        $baranya = County::create(['name' => 'Baranya']);
        City::create(['county_id' => $baranya->id, 'name' => 'Pécs']);
        City::create(['county_id' => $baranya->id, 'name' => 'Mohács']);

        $borsod = County::create(['name' => 'Borsod-Abaúj-Zemplén']);
        City::create(['county_id' => $borsod->id, 'name' => 'Miskolc']);
        City::create(['county_id' => $borsod->id, 'name' => 'Ózd']);
    }
}