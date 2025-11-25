# Deploying InventoryPro to Render.com (Docker)

This guide helps you deploy the Laravel app using the included `Dockerfile` and `render.yaml`.

1. Push your repository to GitHub (or supported Git provider).
2. On Render, create a new service and connect your repository. Render will detect `render.yaml` and use the Docker configuration.
3. In the Render service settings, set environment variables (at minimum):
   - `APP_KEY` (generate locally with `php artisan key:generate --show` and paste),
   - `APP_URL` (e.g. `https://your-app.onrender.com`),
   - `DB_CONNECTION` (set to `mongodb` if connecting to MongoDB),
   - `MONGODB_URI` (preferred) or `MONGODB_HOST`, `MONGODB_PORT`, `MONGODB_DATABASE`, `MONGODB_USERNAME`, `MONGODB_PASSWORD`.
   - Optional: `MIGRATE_ON_START=true` to run migrations on service start.
4. (Optional) Create a managed database on Render and copy its credentials into the service environment.
5. Trigger a deploy. The Docker build will run `npm run build` and `composer install` in multi-stage builds. The container will start `php-fpm` + `nginx`.

Post-deploy tasks:
- To run migrations manually via Render shell:

```bash
# Open a shell on your Render service (via dashboard) and run:
php artisan migrate --force
php artisan db:seed --class=UserSeeder --force
```

Notes:
- The repository already contains `render.yaml` with example environment variables. Replace placeholders before deploying if desired.
- If you prefer not to use Docker, Render supports other workflows but Docker gives predictable builds for Laravel + Vite.

Migrations & Data notes (MongoDB):
- Laravel's default migrations and schema are SQL-oriented; many migration statements (foreign keys, increments, etc.) are not supported on MongoDB.
- If you plan to keep existing SQL migrations, use a relational DB. To fully migrate to MongoDB:
   - Convert / rewrite migrations to use the MongoDB schema builder (or create seeders).
   - Use `migrate:fresh` carefully; some SQL features aren't supported.
   - Consider writing migration scripts that transform SQL data to Mongo documents when migrating an existing relational DB to Mongo.


MongoDB notes:
- If you use MongoDB Atlas, copy the URI into `MONGODB_URI` and leave the other MONGODB_* values blank (or fill for clarity).
- Ensure `DB_CONNECTION` is set to `mongodb` in Render environment variables.
- The project uses `jenssegers/mongodb` package — make sure to run `composer require jenssegers/mongodb` locally and push `composer.lock` to the repo before deploying.
 - If you haven't already installed the driver locally, run:

    ```bash
    composer require jenssegers/mongodb
    ```

 - Also add the database env variables in your `.env` or via Render dashboard.
