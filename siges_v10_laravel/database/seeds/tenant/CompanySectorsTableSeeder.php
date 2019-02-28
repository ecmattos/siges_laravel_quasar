<?php

use Illuminate\Database\Seeder;

class CompanySectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company_sectors =
        [
            [
                'code'        => 'St1',
                'description' => 'Setor 01'
            ],
            [
                'code'        => 'St2',
                'description' => 'Setor 02'
            ]
        ];
    
        foreach ($company_sectors as $company_sector)
        {
            \App\Entities\CompanySector::create($company_sector);
        }
    }
}

