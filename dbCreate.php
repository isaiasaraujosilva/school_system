<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;

require_once 'vendor/autoload.php';

$connection = ConnectDatabase::connect();

try {
$createTableSql = '
CREATE TABLE IF NOT EXISTS people (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    name TEXT NOT NULL, 
    birth_date TEXT NOT NULL,
    gender TEXT NOT NULL,
    admin INTEGER NOT NULL            
    );
    
    CREATE TABLE IF NOT EXISTS users 
    (
        id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
        user TEXT NOT NULL, 
        password TEXT NOT NULL, 
        teacher INTEGER NOT NULL, 
        people_id INTEGER NOT NULL, 
        FOREIGN KEY(people_id) REFERENCES people(id)
    );
        
    CREATE TABLE IF NOT EXISTS school_classes 
    (
        id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
        year TEXT NOT NULL, 
        identifier TEXT NOT NULL, 
        shift TEXT NOT NULL
    );
    
    CREATE TABLE IF NOT EXISTS matters 
    (
        id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
        matter TEXT NOT NULL, 
        workload INTEGER NOT NULL, 
        class_id INTEGER NOT NULL, 
        FOREIGN KEY (class_id) REFERENCES school_classes(id)
    );
    
    CREATE TABLE IF NOT EXISTS teachers 
    (
        id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
        people_id INTEGER NOT NULL, 
        matter_id INTEGER NOT NULL, 
        FOREIGN KEY (people_id) REFERENCES people(id), 
        FOREIGN KEY (matter_id) REFERENCES matters(id)
    );
    
    CREATE TABLE IF NOT EXISTS students 
    (
        id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
        people_id INTEGER NOT NULL , 
        class_id INTEGER NOT NULL, 
        FOREIGN KEY (people_id) REFERENCES people(id), 
        FOREIGN KEY(class_id) REFERENCES school_classes(id)
    );
    
    CREATE TABLE IF NOT EXISTS gradebooks 
    (
        id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
        note1 REAL, 
        note2 REAL, 
        note3 REAL, 
        note4 REAL, 
        note5 REAL, 
        note6 REAL, 
        note7 REAL, 
        note8 REAL, 
        situation INTEGER NOT NULL, 
        student_id INTEGER NOT NULL, 
        matter_id INTEGER NOT NULL, 
        FOREIGN KEY (student_id) REFERENCES students(id), 
        FOREIGN KEY (matter_id) REFERENCES matters(id)
    );
';

$connection->exec($createTableSql);
} catch (PDOException $e) {
    echo $e->getMessage();
}