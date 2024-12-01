<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Tenant::checkCurrent()
           ? $this->runTenantSpecificSeeders()
           : $this->runLandlordSpecificSeeders();
    }

    public function runTenantSpecificSeeders()
    {
        // run tenant specific seeders

        //get users from the current tenant
        $tenant = Tenant::current();

    }

    public function runLandlordSpecificSeeders()
    {
        // run landlord specific seeders

        User::factory()->create([

            'tenant_id' => app('currentTenant')->id,
        ]);
    }
}
