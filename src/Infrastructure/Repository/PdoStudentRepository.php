<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Controller\StudentController;
use Alura\Pdo\Domain\Model\Student;
use DateTimeImmutable;
use DateTimeInterface;
use PDO;
use PDOStatement;

require_once '../../vendor/autoload.php';

class PdoStudentRepository implements StudentController
{

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getStudent(int $id): Student 
    {
        $sqlQuery = "SELECT * FROM students WHERE id = :id;";
        
        $statement = $this->connection->prepare($sqlQuery);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $peopleStatement = $this->connection->prepare('SELECT * FROM people WHERE id = :id;');
        $peopleStatement->bindValue(':id', $result['people_id']);
        $peopleStatement->execute();

        $peopleResult = $statement->fetch(PDO::FETCH_ASSOC);

        return new Student(
            $result['id'], 
            $result['people_id'], 
            $peopleResult['name'], 
            $peopleResult['gender'], 
            new DateTimeImmutable($peopleResult['birth_date']), 
            $result['class_id'],
            $peopleResult['admin']
        );
    }

    public function allStudents(): array
    {
        $statement = $this->connection->query('SELECT * FROM students;');      

        return $this->getListOfStudents($statement);
    }

    public function studentsBirthAt(DateTimeInterface $date): array
    {
        $statement = $this->connection->prepare("SELECT * FROM students WHERE birth_date = :birth_date;");
        $statement->bindValue(':birth_date', $date->format('Y-m-d'));
        $statement->execute();
        
        return $this->getListOfStudents($statement);
    }

    public function getStudentsByClass(int $id): array
    {
        $sqlQuery = 'SELECT * FROM students WHERE class_id = :id;';

        $statement = $this->connection->prepare($sqlQuery);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $this->getListOfStudents($statement);
    }

    public function getStudentByPeopleId(int $peopleId): Student
    {
        $sqlQuery = 'SELECT * FROM students WHERE people_id = :people_id;';

        $statement = $this->connection->prepare($sqlQuery);
        
        $statement->execute([
            ':people_id' => $peopleId 
        ]);

        $student = $statement->fetch(PDO::FETCH_ASSOC);

        return $this->getStudent($student['id']);
    }

    public function getListOfStudents(PDOStatement $statement): array
    {
        $studentsData = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        $studentsList = [];

        foreach ($studentsData as $student) {
            $statement = $this->connection->prepare('SELECT * FROM people WHERE id = :id;');
            $statement->execute([':id' => $student['people_id']]);

            $people = $statement->fetch(PDO::FETCH_ASSOC);

            $studentsList[] = new Student(
                $student['id'],
                $people['id'],
                $people['name'],
                $people['gender'],
                new DateTimeImmutable($people['birth_date']),
                $student['class_id'],
                $people['admin']
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
        $sqlInsert = 'INSERT INTO students (people_id ,class_id) VALUES (:people_id ,:class_id)';

        $statement = $this->connection->prepare($sqlInsert);
        
        return $statement->execute([
            ':people_id' => $student->getPeopleId(),
            ':class_id' => $student->getClassId()
        ]);
    }

    public function update(Student $student): bool
    {
        $sqlUpdate = 'UPDATE students SET class_id = :class_id WHERE id = :id';

        $statement = $this->connection->prepare($sqlUpdate);
        $statement->bindValue(':class_id', $student->getClassId());
        $statement->bindValue(':id', $student->id(), PDO::PARAM_INT);

        return $statement;
    }

    public function remove(Student $student): bool
    {
        $sqlRemove = 'DELETE FROM students WHERE id = :id';

        $statement = $this->connection->prepare($sqlRemove);
        $statement->bindValue(':id', $student->id());
        
        return $statement->execute();
    }
}