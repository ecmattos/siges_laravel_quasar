<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);

        $this->call(PlanTypesTableSeeder::class);
        $this->call(PlanSubTypesTableSeeder::class);
        $this->call(PlanStatusesTableSeeder::class);
        $this->call(PlansTableSeeder::class);
        $this->call(MaterialUnitsTableSeeder::class);
        $this->call(MaterialsTableSeeder::class);
        $this->call(CompanyPositionsTableSeeder::class);
        $this->call(CompanySectorsTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(ProvidersTableSeeder::class);
        $this->call(WarehousesTableSeeder::class);
        $this->call(MeetingTypesTableSeeder::class);
    }
}
