<?php

namespace App\Model;

use App\Traits\DB;

class User
{
    use DB;

    public static function getAll()
    {
        $db = self::getDb();
        $stm = $db->query('SELECT * FROM users');
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }
}