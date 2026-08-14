# Architecture

## Application Areas

- `app/Http/Controllers/Api/` contains name authentication and player game endpoints.
- `app/Http/Requests/` validates registration, login, and game completion input.
- `app/Services/PlayerService.php` owns player registration, game completion, and dashboard queries.
- `app/Models/Player.php` stores personal data and game results.
- `app/Models/User.php` is the Sanctum token owner for a player.
- `resources/views/api/exports/` contains the report and certificate PDF templates.
- `routes/api.php` exposes the client API; `routes/web.php` exposes the admin dashboard, including the `DELETE /players/{id}` route for manually deleting a player.

## Authentication Flow

1. `POST /api/auth/register` creates a `User` and `Player` transactionally.
2. `POST /api/auth/login` resolves the player by case-insensitive name and creates a Sanctum token.
3. Finish, report, and certificate requests require `auth:sanctum` and resolve the name against the authenticated user's player.

Google controllers, routes, configuration, and credentials are removed. The cleanup migration removes legacy Google columns and adds the unique player-name index.

API CORS is configured in `config/cors.php` for the local preview, Construct preview, and production game origins.
