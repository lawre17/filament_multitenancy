<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class Tenant extends Model
{
    Use HasFactory,UsesLandlordConnection;

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
