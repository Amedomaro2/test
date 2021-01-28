<?php

namespace App\Traits;

trait DB
{
    private static function getDb() {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s',
            '192.168.10.10',
            'testdb'
        );
        return new \PDO($dsn, 'testuser', 'qwerty');
    }
}