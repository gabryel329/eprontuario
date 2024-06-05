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
            ['especialidade' => 'Ortopedista'],
        ]);
        
        DB::table('profissionals')->insert([
            ['name' => 'Admin2','sobrenome' => 'Souza', 'email' => 'admin@anb.com'],
            ['name' => 'Matheus','sobrenome' => 'Silva', 'email' => 'cando@gmail.com']
        ]);

        DB::table('users')->insert([
            ['name' => 'Admin',
            'email' => 'admin@anb.com',
            'permisao_id' => 1,
            'profissional_id' => 1,
            'password' => bcrypt('12345678'),
            'imagem' => 'favicon.png'],
        ]);

        DB::table('pacientes')->insert([
            ['name' => 'Rafael',
            'sobrenome' => 'Souza'],
            ['name' => 'Igor',
            'sobrenome' => 'Tavares'],
        ]);

        DB::table('empresas')->insert([
            ['name' => 'A&B',
            'cnpj' => '0000000000',
            'imagem' => 'icone.png'],
        ]);

    }
}
