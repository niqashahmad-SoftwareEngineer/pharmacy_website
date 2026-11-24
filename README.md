# Nazar Muhammad Medical Store
Laravel 13 / PHP 8.4, official Laravel React starter, React 19, TypeScript, Inertia 3, Tailwind CSS 4, and MySQL Community Server 8.4.

## Windows development
Open this folder in VS Code. Run `.\Start-Store.ps1` in PowerShell and visit http://127.0.0.1:8000.
The script accepts -Port. PHP is discovered from PATH, with the existing local development-tools installation as a fallback.
Composer is installed at D:/NiFaSoft Website/development-tools/composer.phar on this machine.
For frontend hot reload, run npm run dev in another terminal with PHP on PATH.

## Database and preservation
The ignored .env uses existing database credentials for nifasoft_web. Never commit it.
All MySQL tables and migration tracking use DB_PREFIX=nmms_ to isolate this store from existing tables.
Existing non-store table row counts were checked before and after migration.
Use php artisan migrate, never migrate:fresh, refresh or reset on this shared database.
Run php artisan db:seed --class=StoreCatalogueSeeder to add missing sample catalogue records without overwriting edits.
Tests use isolated in-memory SQLite, not nifasoft_web.
Original static content remains under dist/ for comparison. It is not the Laravel web root.

## Structure
routes/web.php → CatalogueRequest → StorefrontController → Eloquent Product → Inertia welcome.tsx.
ProductPolicy permits public catalogue reads, restricts hidden records, and denies writes; no catalogue write endpoints are exposed.
database/migrations contains additive schema changes, database/data contains preserved sample catalogue content.
resources/js/lib/catalogue.ts handles client filtering. resources/css/store.css retains the original visual theme; Tailwind supplies responsive layouts and filter styles.

## Checks
- php artisan test
- npm test
- npm run types:check
- npm run build

## Deployment and GitHub
Serve Laravel from public/ on a PHP 8.3+ host with MySQL access. Set APP_ENV=production, APP_DEBUG=false and APP_URL to the real HTTPS origin.
Install Composer production dependencies, build frontend assets, run migrations with the nmms_ prefix, and configure storage/bootstrap cache permissions.
The previous Sites URL still serves the original static site; Sites cannot run this PHP application.
This checkout has no GitHub remote. Connect GitHub and select/create a private repository before pushing. Do not push credentials or database exports.
Logo and real stock/prices remain to be supplied. Online ordering is intentionally inactive.
