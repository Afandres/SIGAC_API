<?php

namespace Modules\SICA\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SICADatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::beginTransaction(); // Iniciar transacción

        $this->call(AppTableSeeder::class); // Ejecutar Seeder de aplicación
        $this->call(CategoriesTableSeeder::class); // Ejecutar Seeder de categorias para los elementos
        $this->call(PeopleTableSeeder::class); // Ejecutar Seeder de personas
        $this->call(UsersTableSeeder::class); // Ejecutar Seeder de usuarios
        $this->call(RolesTableSeeder::class); // Ejecutar Seeder de roles para usuarios
        $this->call(PermissionsTableSeeder::class); // Ejecutar Seeder de permisos para roles

        DB::commit(); // Finalizar transación

    }
}
