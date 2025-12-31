<!-- Copied into the repo to help AI coding agents be productive quickly -->

# Copilot / AI agent instructions — Ecom (Laravel)

Quick orientation

-   This is a Laravel 10 monolithic web app (PHP >= 8.1) with Vite-managed frontend assets. See `composer.json` and `package.json` for platform and scripts.
-   Main HTTP entry: `routes/web.php`. App controllers live under `app/Http/Controllers`. Views are Blade templates in `resources/views`.

Big picture (what matters)

-   Single app with two authentication guards: the default `web` and a custom `admin` guard. Check `config/auth.php` and `app/Models/Admin.php` for the admin provider and model.
-   Admin flow: routes in `routes/web.php` → `App\Http\Controllers\AdminController` → Admin Eloquent model (`app/Models/Admin.php`) → views at `resources/views/admin/*`.
-   Frontend assets: Vite + `laravel-vite-plugin`. Dev server uses `npm run dev` (HMR), production build uses `npm run build`.

Developer workflows (commands you can run)

-   Install PHP deps: `composer install` (ensure PHP 8.1+). Post-install steps are in `composer.json` (copies .env, runs artisan package discovery).
-   Env & keys: `cp .env.example .env` then `php artisan key:generate`.
-   Database: configure DB in `.env`, then `php artisan migrate` (migrations in `database/migrations`).
-   Frontend: `npm install` then `npm run dev` for local development or `npm run build` for production assets.
-   Serve: `php artisan serve` (or use Valet/Docker if preferred).
-   Tests & tooling: `./vendor/bin/phpunit` runs tests; formatting via `./vendor/bin/pint` (pint included as dev dependency).

Project-specific conventions & patterns

-   Admin guard: Code uses `Auth::guard('admin')` — follow that for admin auth logic and middleware uses like `->middleware('auth:admin')`.
-   Blade structure: `resources/views/layouts/master.blade.php` is the main layout. Admin partials live under `resources/views/admin/master/` (head, navbar, footer, etc.). New pages should extend the master layout.
-   Validation & security: controllers use `$request->validate(...)` and `Hash::make(...)` for passwords (see `app/Http/Controllers/AdminController.php`). Login handlers regenerate sessions after successful auth.
-   Naming: routes use names like `login`, `login.submit`, `register`, `register.submit`, `admin.dashboard`. Preserve these names when changing links/forms.
-   Language: source files contain Mongolian text/comments — keep user-facing copy consistent with existing phrasing unless asked to translate.

Integration points & external dependencies

-   Database: Eloquent models, migrations, and `password_reset_tokens` table are used. Admins table is created by `database/migrations/2025_10_09_062255_create_admins_table.php`.
-   HTTP/auth: `config/auth.php` (guards/providers) is authoritative for any auth changes.
-   Frontend: Vite is configured in `vite.config.js` and `resources/js`/`resources/css`.
-   Third-party packages noted in `composer.json` and `package.json` (e.g., `laravel/sanctum`, `laravel-vite-plugin`).

Guidance for code-editing tasks (practical rules for AI)

-   When changing auth/guard behavior: update `config/auth.php`, `app/Models/Admin.php`, and the migration (if schema changes are required). Run `php artisan migrate` and mention migration consequences in the PR.
-   When adding routes: update `routes/web.php`. If the route serves a view, add a blade under `resources/views` and register any new assets in `resources/js` or `resources/css`.
-   When touching views: extend `resources/views/layouts/master.blade.php` and reuse partials under `resources/views/admin/master/` for consistent UI.
-   For JS/CSS edits: after changes run `npm run dev` (dev) or `npm run build` (production). Mention which command in the PR comment.
-   Preserve existing route names and blade variable naming patterns to avoid breaking forms — e.g., login form posts to `route('login')` and register to `route('register')`.

Useful file references (start here)

-   Routes: routes/web.php
-   Admin controller: app/Http/Controllers/AdminController.php
-   Admin model: app/Models/Admin.php
-   Auth config: config/auth.php
-   Views/layout: resources/views/layouts/master.blade.php
-   Admin views: resources/views/admin/\*
-   Migrations: database/migrations/\*
-   Frontend scripts: package.json, vite.config.js, resources/js, resources/css

Review & PR notes

-   Include commands you ran in the PR description (composer, artisan, npm commands).
-   If you add DB fields, include a migration and instructions to run `php artisan migrate` and (if needed) `php artisan migrate:fresh --seed` for local dev.

If anything in this summary is unclear or you want me to expand a specific area (auth, views, or build/test commands), tell me which section to refine.
