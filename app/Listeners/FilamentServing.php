<?php

namespace App\Listeners;

use App\Models\Tenant;
use Filament\Events\ServingFilament;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class FilamentServing
{
    /**
     * Handle the event.
     */
    public function handle(ServingFilament $event): void
    {
        if(Auth::check()) {

            $user = Auth::user();

            $tenant = Tenant::where('id', $user->tenant_id)->first();

            $tenant->makeCurrent();

            //dump active database connection
            // dump(config('database.connections.mysql'));
        }
    }
}
