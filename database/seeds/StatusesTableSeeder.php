<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [\App\Status::EERSTELIJN, 'wachtende op 1stelijns'],
            [\App\Status::EERSTELIJN_TOEGEWEZEN, 'toegewezen aan 1stelijns'],
            [\App\Status::TWEEDELIJN, 'wachtende op 2elijns'],
            [\App\Status::TWEEDELIJN_TOEGEWEZEN, 'toegewezen aan 2elijns'],
            [\App\Status::AFGEHANDELD, 'is afgehandeld']
        ];

        foreach ($statuses as $status) {
            DB::table('statuses')
                ->insert( [
                "name" => $status[0],
                "description" => $status[1],
                "created_at" => now(),
                "updated_at" => now()
            ]);

        }
    }
}
