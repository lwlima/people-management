<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info("Criando usuário com o email 'admin@admin.com.br'.");
        $user = User::where('email', 'admin@admin.com')->first();
        if ($user) {
            $this->command->info('Usuário admin já existe, nenhum novo usuário criado.');
            return;
        }

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        if ($user)
            $this->command->info('Usuário admin criado com sucesso.');
        else
            $this->command->info('Erro ao criar usuário admin.');
    }
}
