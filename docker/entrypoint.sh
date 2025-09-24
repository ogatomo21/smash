#!/bin/sh
set -e

DB_DIR=/var/www/db
DB_FILE=$DB_DIR/smash.sqlite
INIT_SQL=/docker-entrypoint-initdb.d/init.sql

# ディレクトリがなければ作成 & 権限付与
mkdir -p "$DB_DIR"
chmod 777 "$DB_DIR"

# DB がなければ初期化
if [ ! -f "$DB_FILE" ]; then
    echo "Initializing SQLite database..."
    touch "$DB_FILE"
    chmod 666 "$DB_FILE"
    sqlite3 "$DB_FILE" < "$INIT_SQL"
fi

echo "Starting Apache..."
exec apache2-foreground
