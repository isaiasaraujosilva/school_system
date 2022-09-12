<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;

require_once 'vendor/autoload.php';

$connection = ConnectDatabase::connect();

try {
$createTableSql = 'CREATE TABLE IF NOT EXISTS school_classes (id INTEGER PRIMARY KEY, year TEXT, identifier TEXT, shift TEXT);
CREATE TABLE IF NOT EXISTS matters (id INTEGER PRIMARY KEY, matter TEXT, workload INTEGER, class_id INTEGER, FOREIGN KEY(class_id) REFERENCES school_classes(id));
CREATE TABLE IF NOT EXISTS students (id INTEGER PRIMARY KEY, name TEXT, birth_date TEXT, class_id INTEGER, FOREIGN KEY(class_id) REFERENCES school_classes(id));';

$connection->exec($createTableSql);
} catch (PDOException $e) {
    echo $e->getMessage();
}
