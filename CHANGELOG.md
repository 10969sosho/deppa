# Changelog

## 2026-08-18

- Served the Construct game export at `/` and moved the admin dashboard to `/dashboard`.
- Added safe `/games/*` asset serving and browser navigation protection for the game session.

## 2026-08-14

- Allowed CORS requests from `https://localhost` for API routes so the Construct preview APK can call the API without being blocked.
- Added a delete button in the admin dashboard and Master Player table so an admin can manually delete a player record together with its linked user account and tokens.
- Set the application timezone to `Asia/Jakarta` via `APP_TIMEZONE`.

## 2026-08-12

- Replaced Google OAuth with name-based registration and login.
- Made player names unique and case-insensitive at validation level.
- Changed finish, report, and certificate API identifiers from numeric ID to player name.
- Added a public JSON resume endpoint at `GET /api/player/name/{name}`.
- Allowed CORS requests from the Construct preview origin for API routes.
- Added automatic numbered suffixes for duplicate legacy player names before applying the unique index.
- Made finished report and certificate URLs downloadable directly without a bearer token.
- Removed Google routes, controllers, request validation, configuration, and legacy database columns through migration.
- Added feature coverage for registration, login, name-based game completion, downloads, and removed Google auth.
