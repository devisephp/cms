the testing database is stored in bootstrap/app/database/testing.sqlite and has already been preloaded with migrations and the devise seeds

If you navigate to tests/bootstrap directory, these are the commands that were run to initialize the testing.sqlite database that is used for functional testing.

```
php artisan migrate:reset
php artisan migrate --path ../../src/migrations
php artisan db:seed --class DeviseSeeder
```
