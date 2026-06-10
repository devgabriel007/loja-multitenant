#!/bin/bash
php artisan migrate --force
php artisan db:seed --class=MultitenancyTestSeeder --force
apache2-foreground
