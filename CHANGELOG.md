# Changelog

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
