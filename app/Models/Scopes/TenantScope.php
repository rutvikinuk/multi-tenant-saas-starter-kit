<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

/**
 * Row-level tenant isolation.
 *
 * Automatically constrains queries on scoped models to the tenant_id
 * of the currently authenticated user, so one tenant can never see
 * another tenant's rows by accident.
 */
class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $tenantId = $this->currentTenantId();

        if ($tenantId !== null) {
            $builder->where($model->qualifyColumn('tenant_id'), $tenantId);
        }
    }

    public function currentTenantId(): ?int
    {
        if (! Auth::check()) {
            return null;
        }

        return Auth::user()->tenant_id;
    }
}
