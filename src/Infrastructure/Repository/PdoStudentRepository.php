<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Controller\StudentController;
use Alura\Pdo\Domain\Model\Student;
use DateTimeImmutable;
use DateTimeInterface;
use PDO;
use PDOStatement;

require_once '../../../../vendor/autoload.php';

class PdoStudentRepository implements StudentController
{

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getStudent(int $id): Student 
    {
        $sqlQuery = "SELECT * FROM students WHERE id = :id";
        $statement = $this->connection->prepare($sqlQuery);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return new Student($result['id'], $result['name'], new DateTimeImmutable($result['birth_date']), $result['class_id']);
    }

    public function allStudents(): array
    {
        $statement = $this->connection->query('SELECT * FROM students');      

        return $this->getListOfStudents($statement);
    }

    public function studentsBirthAt(DateTimeInterface $date): array
    {
        $statement = $this->connection->prepare("SELECT * FROM students WHERE birth_date = :birth_date");
        $statement->bindValue(':birth_date', $date->format('Y-m-d'));
        $statement->execute();
        
        return $this->getListOfStudents($statement);
    }

    public function getStudentsByClass(int $id): void
    {
        $sqlQuery = 'SELECT * FROM students WHERE class_id = :id';

        $statement = $this->connection->prepare($sqlQuery);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $this->getListOfStudents($statement);
    }

    public function getListOfStudents(PDOStatement $statement): array
    {
        $studentsData = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        $studentsList = [];

        foreach ($studentsData as $student) {
            $studentsList[] = new Student(
                $student['id'],
                $student['name'],
                new DateTimeImmutable($student['birth_date']),
                $student['class_id']
            );
        }

        return $studentsList;
    }

    public function save(Student $student): bool
    {
        if ($student->id() === null) {
            return $this->insert($student);
        }

        return $this->update($student);
    }

    public function insert(Student $student) :bool
    {
        $statement = $this->connection->prepare("INSERT INTO students (name, birth_date, class_id) VALUES (:name, :birth_date, :class_id)");
        
        //forma diferente de passar os valores para o prepared statement.
        $success = $statement->execute([
            ':name' => $student->name(),
            ':birth_date' => $student->birthDate()->format('Y-m-d'),
            ':class_id' => $student->getClassId()
        ]);
        
        if ($success) {
            $student->defineId($this->connection->lastInsertId());
        }
        
        return $success;
    }

    public function update(Student $student): bool
    {
        $statement = $this->connection->prepare("UPDATE students SET name = :name, birth_date = :birth_date, class_id = :class_id WHERE id = :id");
        $statement->bindValue(':name', $student->name());
        $statement->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'));
        $statement->bindValue(':class_id', $student->getClassId());
        $statement->bindValue(':id', $student->id(), PDO::PARAM_INT);

        return $statement;
    }

    public function remove(Student $student): bool
    {
        $sqlQuery = 'DELETE FROM students WHERE id = :id';
        $statement = $this->connection->prepare($sqlQuery);
        $statement->bindValue(':id', $student->id());
        
        return $statement->execute();
    }
}