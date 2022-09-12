<?php

namespace Alura\Pdo\Infrastructure\Persistence;

require_once '../../../../vendor/autoload.php';

use PDO;

class ConnectDatabase 
{
    public static function connect() :PDO
    {
        $bdPath = __DIR__ . '/../../../database.sqlite';
        
        $connection = new PDO('sqlite:' . $bdPath);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $connection;
    }
}