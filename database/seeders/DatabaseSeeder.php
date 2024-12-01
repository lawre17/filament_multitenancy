<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\TenantUser;
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

        $tenant->users()->each(function ($user) {

            TenantUser::factory()->create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'email_verified_at' => $user->email_verified_at,
            ]);
        });

    }

    public function runLandlordSpecificSeeders()
    {
        // run landlord specific seeders

        //create a tenant
        $tenants = Tenant::factory(2)->create();

        //create a user for the tenant

        $tenants->each(function ($tenant) {

            User::factory(2)->create([

                'tenant_id' => $tenant->id,
            ]);
        });
    }
}
