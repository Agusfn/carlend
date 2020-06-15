<?php

use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Agregamos admin user
        DB::table('usuarios')->insert([
            'email' => 'agusfn20@gmail.com',
            'name' => 'Agustin',
            'password' => bcrypt('20596')
        ]);
    }
}
