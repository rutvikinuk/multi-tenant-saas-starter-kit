<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Super-admin API for managing tenants.
 *
 * These routes sit outside normal tenant scoping - they're for the
 * platform operator, not for tenant users. Auth/authorization for
 * "who is a super-admin" is intentionally left as a TODO for the
 * admin panel sprint.
 */
class TenantController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Tenant::orderBy('name')->paginate(25)
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'plan' => ['sometimes', 'string', 'max:50'],
            'usage_limit' => ['sometimes', 'integer', 'min:0'],
        ]);

        $tenant = Tenant::create($validated);

        return response()->json($tenant, 201);
    }

    public function show(Tenant $tenant): JsonResponse
    {
        return response()->json($tenant);
    }
}
