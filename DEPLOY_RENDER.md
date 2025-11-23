# Deploying InventoryPro to Render.com (Docker)

This guide helps you deploy the Laravel app using the included `Dockerfile` and `render.yaml`.

1. Push your repository to GitHub (or supported Git provider).
2. On Render, create a new service and connect your repository. Render will detect `render.yaml` and use the Docker configuration.
3. In the Render service settings, set environment variables (at minimum):
   - `APP_KEY` (generate locally with `php artisan key:generate --show` and paste),
   - `APP_URL` (e.g. `https://your-app.onrender.com`),
   - `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
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
