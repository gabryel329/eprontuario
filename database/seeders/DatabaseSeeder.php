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
            'cargo' => 'Recepção',
        ]);

        DB::table('especialidades')->insert([
            'especialidade' => 'Clinico Geral',
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@anb.com',
            'password' => bcrypt('12345678'),
            'permisoes_id' => 1,
            'especialidade_id' => 1,
        ]);
    }
}
