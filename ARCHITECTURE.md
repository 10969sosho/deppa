# Architecture

## Application Areas

- `app/Http/Controllers/Api/` contains name authentication and player game endpoints.
- `app/Http/Requests/` validates registration, login, and game completion input.
- `app/Services/PlayerService.php` owns player registration, game completion, and dashboard queries.
- `app/Models/Player.php` stores personal data and game results.
- `app/Models/User.php` is the Sanctum token owner for a player.
- `resources/views/api/exports/` contains the report and certificate PDF templates.
- `routes/api.php` exposes the client API; `routes/web.php` serves the Construct game at `/`, serves its export assets under `/games/*` plus whitelisted root-relative aliases, and exposes the admin dashboard at `/dashboard`, including the `DELETE /players/{id}` route for manually deleting a player.

## Authentication Flow

1. `POST /api/auth/register` creates a `User` and `Player` transactionally.
2. `POST /api/auth/login` resolves the player by case-insensitive name and creates a Sanctum token.
3. Finish, report, and certificate requests require `auth:sanctum` and resolve the name against the authenticated user's player.

Google controllers, routes, configuration, and credentials are removed. The cleanup migration removes legacy Google columns and adds the unique player-name index.

API CORS is configured in `config/cors.php` for the local preview, Construct preview, and production game origins.

## Game Navigation

- The game export is kept in `games/` and is served through Laravel because the production document root is `public/`.
- `games/scripts/navigation-guard.js` traps browser back navigation and requests the browser's native leave confirmation for refresh, close, or navigation away. Browser security prevents JavaScript from silently blocking every refresh or force-closing action.
