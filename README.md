# MyOnlineShop Web (CI4 Frontend)

A **CodeIgniter 4** + **Bootstrap 5** consumer frontend for the MyOnlineShop practice project. Renders all customer- and merchant-facing pages and talks to a separate [Go/Gin API](#) for all data — this repo has no business logic of its own beyond presentation, session handling, and (for a small number of pages) direct read access to the shared database.

## Tech Stack

- **CodeIgniter 4** — sections-based view templating (`extend`/`section`)
- **Bootstrap 5** + **Bootstrap Icons** — UI
- **Guzzle** — HTTP client for calling the Go API
- **Docker** — PHP 8.2 + Apache image

## Features

- Role-aware navbar and layout (guest / customer / merchant)
- Product catalog with search, category filter, and pagination
- Product detail page with size-variant selection (price/stock update via vanilla JS)
- Cart and checkout
- Customer order history with a visual status tracker, and a Pay Now button that initiates a Midtrans Snap payment
- Merchant product, variant, and order management
- Merchant dashboard (summary stats, recent orders, low-stock alert, recent reviews)
- Product review submission, gated to completed orders
- Session-based JWT storage with automatic refresh-token retry on 401

## Project Structure

```
.
├── app/
│   ├── Controllers/
│   │   ├── Customers/     # Customer-facing controllers
│   │   ├── Merchants/     # Merchant-facing controllers
│   │   └── Admin/         # Admin-facing controllers
│   ├── Services/          # BaseApiService + per-domain API service classes
│   ├── Views/
│   │   ├── Layouts/       # Shared layout, navbar, footer
│   │   ├── products/, cart/, orders/, merchant/, ...
│   └── Config/
├── public/                 # Web root (Apache DocumentRoot)
├── entrypoint.sh            # Docker container startup script (see below)
└── Dockerfile
```

## How This App Talks to the API

All API calls go through `BaseApiService`, extended by per-domain service classes (`CartApiService`, `PaymentApiService`, etc.). It centralizes:
- Attaching the JWT (`Authorization: Bearer ...`) from session to every request
- Automatic refresh-token retry on a `401` response
- Consistent `{ success, data | message }` return shape for controllers to check

When adding a new API-backed feature, add a method to the relevant service class (or create a new one extending `BaseApiService`) rather than calling Guzzle directly from a controller.

## Environment Variables

| Variable | Description | Example |
|---|---|---|
| `API_BASE_URL` | Base URL of the Go API | `http://goapi:8080/` (Docker) / `http://localhost:8080/` (local) |
| `app.baseURL` | CI4's own base URL, used by `base_url()`/`site_url()` | `http://myonlineshop.localhost/` |
| `database.default.hostname` | Direct DB connection host (used by a small number of controllers) | `mysql` |
| `database.default.database` | Database name | `myonlineshop` |
| `database.default.username` | Database user | |
| `database.default.password` | Database password | |
| `database.default.port` | Database port | `3306` |

> **Note on Docker + dotted variable names:** environment variable names containing dots (like `database.default.hostname`) are not valid POSIX identifiers and get silently dropped from a container's init-process environment. This repo's `entrypoint.sh` works around that by accepting plain, underscore-named variables from Docker Compose (`DB_HOSTNAME`, `APP_BASE_URL`, etc.) and writing them into a real `.env` file at container startup, which CI4's own `Dotenv` loader then reads normally. See `docker-compose.yml` in the deployment repo for the exact variable names Compose passes in.

## Running Locally (without Docker)

Requires PHP 8.2+ with the `intl`, `mbstring`, and `mysqli` extensions, Composer, and a running instance of the Go API.

```bash
composer install
cp env .env   # then fill in the variables above
php spark serve
```

## Running with Docker

This service is designed to run as part of the full stack via Docker Compose alongside the Go API and MariaDB (see the deployment repo/directory). To build just this image standalone:

```bash
docker build -t mos-web .
docker run -p 80:80 \
  -e API_BASE_URL="http://host.docker.internal:8080/" \
  -e APP_BASE_URL="http://myonlineshop.localhost/" \
  -e DB_HOSTNAME="host.docker.internal" \
  -e DB_DATABASE="myonlineshop" \
  -e DB_USERNAME="..." \
  -e DB_PASSWORD="..." \
  -e DB_PORT="3306" \
  mos-web
```

## Notes

This is a learning/practice project built alongside a companion Go API repo. Payment flows are tested against Midtrans's **sandbox** environment only.
