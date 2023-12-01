<?php

namespace Managefaster\Database;

use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    public function boot() {
        //
    }

    public function register() {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/database.php', 'database'
        );
    }
}
