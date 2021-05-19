<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [\App\Role::ADMIN],
            [\App\Role::KLANT],
            [\App\Role::EERSTELIJNS_MEDEWERKER],
            [\App\Role::TWEEDELIJNS_MEDEWERKER]
        ];

        foreach ($roles as $role){
            DB::table('roles')
                ->insert( [
                "name" => $role[0],
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }
    }
}
