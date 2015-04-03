#!/bin/bash

[ -f app/database/troubleshoot.sqlite ] && rm app/database/troubleshoot.sqlite
touch app/database/troubleshoot.sqlite

php artisan migrate --path ../../src/migrations --database troubleshoot
php artisan db:seed --class DeviseSeeder --database troubleshoot
