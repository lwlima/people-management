<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Criando 10 pessoas aleatórias.');
        Person::factory()->count(10)->create();
        $this->command->info('Pessoas criadas com sucesso.');
    }
}
