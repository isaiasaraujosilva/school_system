<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Controller\MatterController;
use Alura\Pdo\Domain\Model\Matter;
use PDO;

require_once '../../vendor/autoload.php';

class PdoMatterRepository implements MatterController 
{

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getMatter(int $id): Matter
    {
        $sqlQuery = "SELECT * FROM matters WHERE id = {$id}";

        $statement = $this->connection->query($sqlQuery);
        $matterData = $statement->fetch(PDO::FETCH_ASSOC);

        return new Matter($matterData['id'], $matterData['matter'], $matterData['workload'], $matterData['class_id']);
    }

    public function insert(Matter $matter): bool
    {
        $sqlInsert = 'INSERT INTO matters (matter, workload, class_id) VALUES (:matter, :workload, :class_id)';
        
        $statement = $this->connection->prepare($sqlInsert);
        
        return $statement->execute([
            ':matter' => $matter->getMatter(),
            ':workload' => $matter->getWorkload(),
            ':class_id' => $matter->getClassId()
        ]);
    }

    public function update(Matter $matter): bool
    {
        $sqlUpdate = 'UPDATE matters SET matter = :matter, workload = :workload, class_id = :class_id WHERE id = :id';

        $statement = $this->connection->prepare($sqlUpdate);
        
        return $statement->execute([
            ':matter' => $matter->getMatter(),
            ':workload'=> $matter->getWorkload(),
            ':class_id' => $matter->getClassId()
        ]);
    }

    public function save(Matter $matter): bool
    {
        if ($matter->getId() === null) {
            return $this->insert($matter);
        }

        return $this->update($matter);
    }

    public function remove(Matter $matter): bool
    {
        $sqlRemove = 'DELETE FROM matters WHERE id = :id';

        $statement = $this->connection->prepare($sqlRemove);
        $statement->bindValue(':id', $matter->getId(), PDO::PARAM_INT);

        return $statement->execute();
    }
}