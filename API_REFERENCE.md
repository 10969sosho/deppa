# API Reference

All routes are prefixed with `/api`.

## Register

`POST /auth/register` (the existing `POST /player` alias is also supported)

Request JSON:

```json
{
  "nama": "Budi Santoso",
  "usia": 12,
  "jenjang": "SD",
  "gender": "L"
}
```

The response contains `data.token`, `data.id`, and `data.player`.

## Login

`POST /auth/login`

Request JSON:

```json
{
  "nama": "Budi Santoso"
}
```

The `name` request key is accepted as an alias. The response contains a Sanctum bearer token and the player metadata.

## Resume Player

`GET /player/name/{name}`

This public endpoint is used by the game main menu before the player has a token. `{name}` must be URL-encoded. It returns JSON with `id`, `nama`, `usia`, `jenjang`, `gender`, `score`, `duration`, and `is_finish`.

Cross-origin requests from `https://preview.construct.net` are allowed for API routes.

## Game Endpoints

Use `Authorization: Bearer <token>` for these routes. `{name}` is the URL-encoded registered player name.

- `PUT /player/{name}/finish` with `{ "score": 95 }`
- `GET /player/{name}/report` downloads the report PDF after finish
- `GET /player/{name}/certificate` downloads the certificate PDF after finish

The old Google endpoint `/auth/google` and numeric-ID player endpoints are no longer part of the API.
