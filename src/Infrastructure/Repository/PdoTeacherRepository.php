<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Controller\TeacherController;
use Alura\Pdo\Domain\Model\Teacher;
use DateTimeImmutable;
use PDO;

require_once '../../vendor/autoload.php';

class PdoTeacherRepository implements TeacherController
{

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getTeacher(int $id): Teacher
    {
        $sqlQuery = 'SELECT * FROM teachers WHERE id = :id';

        $statement = $this->connection->prepare($sqlQuery);
        $statement->execute([
            ':id' => $id
        ]);

        $teacher = $statement->fetch(PDO::FETCH_ASSOC);

        $peopleStatement = $this->connection->prepare('SELECT * FROM people WHERE id = :id');
        $peopleStatement->execute([
            ':id' => $teacher['people_id']
        ]);

        $people = $peopleStatement->fetch(PDO::FETCH_ASSOC);

        return new Teacher(
            $teacher['id'], 
            $people['id'], 
            $people['name'], 
            $people['gender'], 
            new DateTimeImmutable($people['birth_date']), 
            $teacher['matter_id'], 
            $people['admin']);
    }

    public function save(Teacher $teacher): bool
    {
        if ($teacher->getId() === null){
            return $this->insert($teacher);
        }

        return $this->update($teacher);
    }

    public function insert(Teacher $teacher): bool
    {
        $sqlInsert = 'INSERT INTO teachers (people_id, matter_id) VALUES (:people_id, :matter_id);';

        $statement = $this->connection->prepare($sqlInsert);

        return $statement->execute([
            ':people_id' => $teacher->getPeopleId(),
            ':matter_id' => $teacher->getMatterId()
        ]);
    }

    public function update(Teacher $teacher): bool
    {
        $sqlUpdate = 'UPDATE teachers SET matter_id = :matter_id WHERE id = :id;';

        $statement = $this->connection->prepare($sqlUpdate);

        return $statement->execute([
            ':matter_id' => $teacher->getMatterId(),
            ':id' => $teacher->getId()
        ]);
    }

    public function remove(Teacher $teacher): bool
    {
        $sqlRemove = 'DELETE FROM teachers WHERE id = :id';

        $statement = $this->connection->prepare($sqlRemove);
        return $statement->execute([
            ':id' => $teacher->getId()
        ]);
    }
}