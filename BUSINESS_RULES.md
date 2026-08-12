# Business Rules

- A player name is required, trimmed, limited to 100 characters, and unique without regard to letter case.
- Registration requires `nama`, `usia`, `jenjang`, and `gender`.
- Registration returns a Sanctum token and the player ID/name needed by the client.
- Login requires only the registered name. It is rate-limited per name and IP address.
- Finish, report, and certificate access is restricted to the authenticated player's own name.
- A report and certificate can only be downloaded after `is_finish` is true.
- Certificate and report filenames use a slug derived from the player name.
