<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Unique;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');

        DB::table('usuarios')->insert([
            'nome' => 'Gabriel Lindo',
            'email' => 'gb@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('28112006'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        for ($i = 0; $i <= 10; $i++) {
            DB::table('usuarios')->insert([
                'nome' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
