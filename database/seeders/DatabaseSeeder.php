<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('permisoes')->insert([
            ['cargo' => 'Recepção'],
            ['cargo' => 'Medico'],
        ]);

        DB::table('especialidades')->insert([
            ['especialidade' => 'Clinico Geral'],
            ['especialidade' => 'Clinico'],
        ]);
        

        DB::table('users')->insert([
            ['name' => 'Admin',
            'email' => 'admin@anb.com',
            'password' => bcrypt('12345678'),
            'imagem' => 'CamaraoEmpanado.jpg'],
        ]);

        DB::table('profissionals')->insert([
            ['name' => 'leko',
            'email' => 'leko@anb.com',
            'sobrenome' => 'suzart'],
            ['name' => 'matheus',
            'email' => 'leko2@anb.com',
            'sobrenome' => 'suzart2']
        ]);

        DB::table('pacientes')->insert([
            ['name' => 'Clinico Geral',
            'sobrenome' => 'suzart'],
            ['name' => 'Clinico',
            'sobrenome' => 'suzart'],
        ]);

        DB::table('empresas')->insert([
            ['name' => 'A&B',
            'cnpj' => '0000000000',
            'imagem' => 'icone.png'],
        ]);

    }
}
