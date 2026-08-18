# DEPPA Project Context

DEPPA is a Laravel API and administration dashboard for the Si Doel Smart Finance game. Players register their personal data, complete the game, and download a report and certificate after finishing.

The production game is available at `https://games.alureflow.com/`; the administration dashboard is available at `https://games.alureflow.com/dashboard`.

## Current Authentication

- Authentication is name-based; no password or Google OAuth is used.
- `players.nama` is the unique player identity.
- Registration creates the player and its Sanctum token in one transaction.
- The API returns the numeric player ID as metadata, but player actions use the name.

## Related Documentation

- [Architecture](ARCHITECTURE.md)
- [Business Rules](BUSINESS_RULES.md)
- [API Reference](API_REFERENCE.md)
- [Changelog](CHANGELOG.md)
