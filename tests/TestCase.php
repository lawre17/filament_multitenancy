<?php

namespace Tests;

use App\Models\Tenant;
use App\Models\TenantUser;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        //sets up the landlord database connection for testing

        config(['multitenancy.landlord_database_connection_name' => 'landlord_tests']);

        config(['database.connections.landlord_tests.database' => ':memory:']);

        $this->artisan('migrate --path=database/migrations/landlord --database=landlord_tests');

        $tenant = Tenant::factory()->create(['name' => 'Acme Corporation','database' => 'acme_corp'])
            ->makeCurrent();

        $this->actingAs(User::factory()->create(['tenant_id' => $tenant->id]));

        //sets up the tenant database connection for testing

        config(['multitenancy.tenant_database_connection_name' => 'tenants_tests']);

        config(['database.connections.tenants_tests.database' => ':memory:']);

        $this->artisan('tenants:artisan "migrate:fresh --database=tenants_tests"');

        //create a tenant user

        $tenant->users()->each(function ($user) {

            $tenantUser = TenantUser::factory()->create([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'email_verified_at' => $user->email_verified_at,
            ]);
        });


    }
}
