<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class TenantUser extends Model
{
    /** @use HasFactory<\Database\Factories\TenantUserFactory> */
    use HasFactory,UsesTenantConnection;

    protected $guarded = [];

    public function todos()
    {
        return $this->hasMany(Todo::class,'tenant_user_id');
    }
}
