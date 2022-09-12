<?php

namespace Alura\Pdo\Domain\Controller;

use Alura\Pdo\Domain\Model\SchoolClass;
use PDOStatement;

require_once '../../../../vendor/autoload.php';

interface SchoolClassController 
{
    public function getClassesByShift(string $choice): array;

    public function getClassesByYear(string $year): array;

    public function getListOfCLasses(PDOStatement $statement): array;

    public function insert(SchoolClass $class): bool;

    public function save(SchoolClass $class): bool;

    public function update(SchoolClass $class): bool;

    public function remove(SchoolClass $class): bool;
}