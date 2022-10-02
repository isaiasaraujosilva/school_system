<?php

namespace Alura\Pdo\Domain\Controller;

require_once '../../vendor/autoload.php';

use Alura\Pdo\Domain\Model\Student;
use DateTimeInterface;
use PDOStatement;

interface StudentController 
{
    public function allStudents(): array;

    public function studentsBirthAt(DateTimeInterface $date): array;

    public function getListOfStudents(PDOStatement $statement) : array;

    public function save(Student $student): bool;

    public function insert(Student $student): bool;

    public function update(Student $student): bool;

    public function remove(Student $student): bool;
}