# Authentication System

The API uses token-based authentication.

## How It Works

- On login, users receive an X-Access-Token.
- This token must be included in the `X-Access-Token` header for protected actions (Create, Update, Delete).

## Endpoints

| Method | Endpoint | Purpose |
|--------|----------|---------|
| POST | `/api/users/loginUser.php` | Authenticate and receive token |

Tokens must be included in the header:
X-Access-Token: Bearer {token}