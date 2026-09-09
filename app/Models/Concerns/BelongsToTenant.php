<?php

namespace App\Models\Concerns;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * Add this trait to any model that has a tenant_id column to
 * automatically scope every query to the current tenant and stamp
 * new records with the current tenant on creation.
 *
 * This is a basic starting point: it resolves the "current tenant"
 * from the authenticated user. Swap resolveTenantId() out for a
 * request-bound resolver (e.g. subdomain lookup) if that's needed.
 */
trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function ($model) {
            if (empty($model->tenant_id) && ($tenantId = static::resolveTenantId())) {
                $model->tenant_id = $tenantId;
            }
        });
    }

    protected static function resolveTenantId(): ?int
    {
        return Auth::check() ? Auth::user()->tenant_id : null;
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Tenant::class);
    }

    /**
     * Run a query without the tenant scope, e.g. for super-admin access.
     */
    public function scopeWithoutTenantScope($query)
    {
        return $query->withoutGlobalScope(TenantScope::class);
    }
}
