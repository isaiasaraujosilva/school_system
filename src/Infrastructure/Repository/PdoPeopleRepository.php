<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Controller\PeopleController;
use Alura\Pdo\Domain\Model\People;
use DateTimeImmutable;
use PDO;

require_once '../../vendor/autoload.php';

class PdoPeopleRepository implements PeopleController
{

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getPeople(int $id): People
    {
        $sqlQuery = 'SELECT * FROM people WHERE id = :id';

        $statement = $this->connection->prepare($sqlQuery);
        $statement->execute([
            ':id' => $id,
        ]);

        $people = $statement->fetch(PDO::FETCH_ASSOC);

        return new People($people['id'], $people['name'], $people['gender'], new DateTimeImmutable($people['birth_date']), $people['admin']);
    }

    public function save(People $people): bool
    {
        if ($people->getPeopleId() === null) {
            return $this->insert($people);
        }

        return $this->update($people);
    }

    public function insert(People $people): bool
    {
        $sqlInsert = 'INSERT INTO people (name, birth_date, gender, admin) VALUES (:name, :birth_date, :gender, :admin);';

        $statement = $this->connection->prepare($sqlInsert);
        
        return $statement->execute([
            ':name' => $people->getName(),
            ':birth_date' => $people->getBirthDate(),
            ':gender' => $people->getGender(),
            ':admin' => $people->getIsAdmin()
        ]);
    }

    public function update(People $people): bool
    {
        $sqlUpdate = 'UPDATE people SET name = :name, birth_date = :birth_date, gender = :gender WHERE id = :id;';

        $statement = $this->connection->prepare($sqlUpdate);
        
        return $statement->execute([
            ':name' => $people->getName(),
            ':birth_date' => $people->getBirthDate(),
            ':gender' => $people->getGender(),
            ':id' => $people->getPeopleId()
        ]);
    }

    public function remove(People $people): bool
    {
        $sqlRemove = 'DELETE FROM people WHERE id = :id';

        $statement = $this->connection->prepare($sqlRemove);
        return $statement->execute([
            ':id' => $people->getPeopleId()
        ]);
    }
}