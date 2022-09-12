<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Controller\SchoolClassController;
use Alura\Pdo\Domain\Model\SchoolClass;
use PDO;
use PDOStatement;

require_once '../../../../vendor/autoload.php';

class PdoSchoolClassRepository implements SchoolClassController
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getClass(int $id): SchoolClass
    {
        $sqlQuery = "SELECT * FROM school_classes WHERE id = {$id}";

        $statement = $this->connection->query($sqlQuery);
        $classData = $statement->fetch(PDO::FETCH_ASSOC);

        return new SchoolClass($classData['id'], $classData['year'], $classData['identifier'], $classData['shift']);
    }

    public function allClasses(): array 
    {
        $statement = $this->connection->query('SELECT * FROM school_classes');

        return $this->getListOfCLasses($statement);
    }

    public function getClassesByShift(string $choice): array
    {
        if ($choice === '1') {
            $sqlQuery = 'SELECT * FROM school_classes WHERE shift = manha';
        } elseif ($choice === '2') {
            $sqlQuery = 'SELECT * FROM school_classes WHERE shift = tarde';
        } else {
            echo 'Você informou uma opção inválida para turnos.';
            exit();
        }

        $statement = $this->connection->query($sqlQuery);

        return $this->getListOfCLasses($statement);
    }

    public function getClassesByYear(string $year): array
    {
        $sqlQuery = "SELECT * FROM school_classes WHERE year = {$year}";

        $statement = $this->connection->query($sqlQuery);

        return $this->getListOfCLasses($statement);
    }

    public function getListOfCLasses(PDOStatement $statement): array
    {
        $classesData = $statement->fetchAll(PDO::FETCH_ASSOC);

        $classesList = [];

        foreach ($classesData as $class) {
            $classesList[] = new SchoolClass(
                $class['id'],
                $class['year'],
                $class['identifier'],
                $class['shift']
            );
        }

        return $classesList;
    }

    public function insert(SchoolClass $class): bool
    {
        $sqlInsert = 'INSERT INTO school_classes (year, identifier, shift) VALUES (:year, :identifier, :shift)';
        
        $statement = $this->connection->prepare($sqlInsert);

        return $statement->execute([
            ':year' => $class->getYear(),
            ':identifier' => $class->getIdentifier(),
            ':shift' => $class->getShift()
        ]);
    }

    public function save(SchoolClass $class): bool
    {
        if ($class->getId() === null) {
            return $this->insert($class);
        }

        return $this->update($class);
    }

    public function update(SchoolClass $class): bool
    {
        $sqlUpdate = 'UPDATE school_classes SET year = :year, identifier = :identifier, shift = :shift WHERE id = :id';

        $statement = $this->connection->prepare($sqlUpdate);

        return $statement->execute([
            ':year' => $class->getYear(),
            ':identifier' => $class->getIdentifier(),
            ':shift' => $class->getShift(),
            ':id' => $class->getId()
        ]);
    }

    public function remove(SchoolClass $class): bool
    {
        $sqlRemove = 'DELETE FROM school_classes WHERE id = :id';

        $statement = $this->connection->prepare($sqlRemove);

        return $statement->execute([
            ':id' => $class->getId()
        ]);
    }
}