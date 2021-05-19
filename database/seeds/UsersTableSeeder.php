<?php

use Illuminate\Database\Seeder;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users =
                [

                    ['Wessel', 'Wessel@admin.nl', 'admin', \App\Role::ADMIN],


                    ['A. Eerstelijns', 'help1@gmail.com', 'help1', \App\Role::EERSTELIJNS_MEDEWERKER],
                    ['B. Eerstelijns', 'help2@gmail.com', 'help2', \App\Role::EERSTELIJNS_MEDEWERKER],


                    ['C. Tweedelijns', 'help3@gmail.com', 'help3', \App\Role::TWEEDELIJNS_MEDEWERKER ],
                    ['D. Tweedelijns', 'help4@gmail.com', 'help4', \App\Role::TWEEDELIJNS_MEDEWERKER ],


                    ['E. Klant', 'klant1@gmail.com', 'klant1', \App\Role::KLANT],
                    ['F. Klant', 'klant2@gmail.com', 'klant2', \App\Role::KLANT]

                ];

        $role_ids = DB::table('roles')->pluck('id', 'name');

        $records = [];

        foreach ($users as $user) {
            $records[] =
                [
                    'name' => $user[0],
                    'email' => $user[1],
                    'password' => bcrypt($user[2]),
                    'role_id' => $role_ids[$user[3]],
                    'created_at' => now()
                ];
        }


        DB::table('users')->insert($records);

//        var_dump($records);
    }
}
