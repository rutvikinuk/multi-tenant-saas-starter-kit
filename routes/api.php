<?php

use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;

// Super-admin tenant management. Not tenant-scoped - this is how the
// platform operator creates and inspects tenants.
Route::apiResource('tenants', TenantController::class)->only([
    'index', 'store', 'show',
]);
