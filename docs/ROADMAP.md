# Roadmap

Agile sprint plan for the Multi-Tenant SaaS Starter Kit, targeting a full
build by **2026-11-30**. Sprints are ~3 weeks each, adjusted at the end for
polish and deployment.

## Sprint 1 — Tenant model & row-level scoping foundation
**2026-09-09 to 2026-09-25**

- [x] `Tenant` model + migration (`name`, `plan`, `usage_limit`)
- [x] `tenant_id` foreign key on `users`
- [x] `BelongsToTenant` trait + `TenantScope` global scope for row-level
      isolation
- [x] Basic `TenantController` REST API (`index`, `store`, `show`) under
      `/api/tenants`
- [ ] Model/feature tests for tenant scoping (a user from tenant A can't see
      tenant B's rows)
- [ ] Seeder for local dev tenants + users

## Sprint 2 — Tenant sign-up flow & admin panel
**2026-09-28 to 2026-10-16**

- [ ] Public sign-up flow: create a tenant + its first (owner) user in one
      transaction
- [ ] Auth scaffolding (Laravel Breeze or Fortify) scoped to tenant context
- [ ] Middleware to resolve/attach the current tenant to each request
- [ ] Super-admin authentication and authorization (a real admin guard, not
      the current controller's TODO)
- [ ] Blade-based admin panel: list tenants, view a tenant's users, basic
      tenant CRUD UI on top of the existing API
- [ ] Update/destroy endpoints on `TenantController`

## Sprint 3 — Stripe Billing integration
**2026-10-19 to 2026-11-06**

- [ ] Wire up Laravel Cashier (Stripe)
- [ ] Define plan tiers (free / pro / enterprise) and map to Stripe prices
- [ ] Subscription checkout + billing portal for tenant owners
- [ ] Webhook handling for subscription lifecycle events (created, updated,
      cancelled, payment failed)
- [ ] Sync a tenant's `plan` column with its active Stripe subscription

## Sprint 4 — Usage limits, polish, deploy
**2026-11-09 to 2026-11-30**

- [ ] Enforce `usage_limit` per tenant (e.g. seats, API calls, or records —
      whichever the product needs first) with clear over-limit errors
- [ ] Usage dashback in the admin panel (per-tenant usage vs. limit)
- [ ] Swap local SQLite for PostgreSQL, verify migrations against Postgres
- [ ] Environment/config hardening for deployment (queues, cache, mail)
- [ ] Deploy to a hosting target, smoke test end-to-end
- [ ] Final documentation pass on `README.md`

## Notes

- PostgreSQL is the target production database; SQLite remains the local
  dev default for speed and zero setup.
- Tenancy is row-level (`tenant_id` scoping), not database-per-tenant —
  keeps operations simple for a starter kit at this scale.
