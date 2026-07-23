#!/bin/sh
set -e

cat > /var/www/html/.env <<EOF
app.baseURL = '${APP_BASE_URL}'

database.default.hostname = '${DB_HOSTNAME}'
database.default.database = '${DB_DATABASE}'
database.default.username = '${DB_USERNAME}'
database.default.password = '${DB_PASSWORD}'
database.default.port = ${DB_PORT}

API_BASE_URL = '${API_URL:-$API_BASE_URL}'
EOF

echo "--- Generated .env ---"
cat /var/www/html/.env
echo "-----------------------"

exec apache2-foreground