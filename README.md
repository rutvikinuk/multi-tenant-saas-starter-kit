# Multi-Tenant SaaS Starter Kit

A reusable foundation for building multi-tenant SaaS products: team sign-up,
subscription billing with plan tiers and usage limits, row-level tenant data
isolation, and a super-admin panel to manage every tenant on the platform.

Status: 🚧 In active development

## Tech stack

- **Laravel** (PHP) — application framework and API
- **PostgreSQL** — production database (SQLite is used for local development)
- **Stripe Billing** — subscriptions, plan tiers, invoicing (planned)
- Row-level multi-tenancy via a `tenant_id` column + a `BelongsToTenant`
  trait/global scope, rather than separate databases per tenant

## Planned features

- Tenant sign-up flow and per-tenant data isolation
- Subscription billing with multiple plan tiers, powered by Stripe
- Per-tenant usage limits, enforced at the application layer
- Super-admin panel to view, create, and manage all tenants

See [`docs/ROADMAP.md`](docs/ROADMAP.md) for the sprint-by-sprint build plan.

## Getting started

```bash
composer install
cp .env.example .env
php artisan key:generate

# local dev uses SQLite
touch database/database.sqlite
php artisan migrate

php artisan serve
```

The tenant management API is available at `/api/tenants` (`GET`, `POST`,
`GET /{tenant}`) and is intended for super-admin use.

## Multi-tenancy approach

Tenant data isolation is row-level: tenant-owned tables carry a `tenant_id`
foreign key, and models that belong to a tenant use the `BelongsToTenant`
trait (`app/Models/Concerns/BelongsToTenant.php`) to automatically scope
queries to the current tenant and stamp new records on creation. This keeps
the app on a single database while still preventing cross-tenant data leaks
at the query level.
