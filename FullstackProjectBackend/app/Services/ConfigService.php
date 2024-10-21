<?php

namespace App\Services;

class ConfigService
{
    // Return a config value from our config.php file
    public static function get(string $configPath) {
        return config('config.' . $configPath);
    }
}
