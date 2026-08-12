# Changelog

## 2026-08-12

- Replaced Google OAuth with name-based registration and login.
- Made player names unique and case-insensitive at validation level.
- Changed finish, report, and certificate API identifiers from numeric ID to player name.
- Removed Google routes, controllers, request validation, configuration, and legacy database columns through migration.
- Added feature coverage for registration, login, name-based game completion, downloads, and removed Google auth.
