<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Person;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Criando endereço residencial e comercial aleatórios para cada pessoa.');

        Person::all()->each(function ($people) {
            Address::factory()->create(['person_id' => $people->id, 'type' => 'residential']);
            Address::factory()->create(['person_id' => $people->id, 'type' => 'commercial']);
        });

        $this->command->info('Endereços criados com sucesso.');
    }
}
