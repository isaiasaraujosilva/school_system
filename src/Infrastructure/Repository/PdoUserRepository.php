<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Controller\UserController;
use Alura\Pdo\Domain\Model\User;
use DateTimeImmutable;
use PDO;

require_once '../../vendor/autoload.php';

class PdoUserRepository implements UserController
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getUser(int $id): User
    {
        $sqlQuery = 'SELECT * FROM users WHERE id = :id;';
        
        $statement = $this->connection->prepare($sqlQuery);
        $statement->bindValue(':id', $id);
        $statement->execute();
        
        $userData = $statement->fetch(PDO::FETCH_ASSOC);

        $peopleStatement = $this->connection->prepare('SELECT * FROM people WHERE id = :id;');
        $peopleStatement->bindValue(':id', $userData['people_id']);
        $peopleStatement->execute();

        $people = $peopleStatement->fetch(PDO::FETCH_ASSOC);

        return new User(
            $userData['id'], 
            $userData['user'], 
            $userData['password'], 
            $userData['teacher'], 
            $userData['people_id'], 
            $people['id'], 
            $people['name'], 
            $people['gender'], 
            new DateTimeImmutable($people['birth_date']), 
            $people['admin']
        );
    }

    public function isValidUser(string $user, string $password): bool 
    {
        $sqlQuery = 'SELECT id, user FROM users WHERE user = :user AND password = :password;';

        $statement = $this->connection->prepare($sqlQuery);
        $statement->execute([
            ':user' => $user,
            ':password' => $password
        ]);
        
        $row = $statement->rowCount();

        if (!is_null($row)) {
            return true;
        }

        return false;
    }

    public function getUserByCredentials(string $user, string $password): User
    {
        $sqlQuery = 'SELECT * FROM users WHERE user = :user AND password = :password;';
        

        $statement = $this->connection->prepare($sqlQuery);
        $statement->execute([
            ':user' => $user,
            ':password' => $password
        ]);

        $bdUser = $statement->fetch(PDO::FETCH_ASSOC);

        $peopleStatement = $this->connection->prepare('SELECT * FROM people WHERE id = :id;');
        $peopleStatement->bindValue(':id', $bdUser['people_id']);
        $peopleStatement->execute();

        $people = $peopleStatement->fetch(PDO::FETCH_ASSOC);

        return new User(
            $bdUser['id'], 
            $bdUser['user'], 
            $bdUser['password'], 
            $bdUser['teacher'], 
            $bdUser['people_id'], 
            $people['id'], 
            $people['name'], 
            $people['gender'], 
            new DateTimeImmutable($people['birth_date']), 
            $people['admin']);
    }

    public function save(User $user): bool
    {
        if ($user->getId() === null) {
            return $this->insert($user);
        }

        return $this->update($user);
    }

    public function insert(User $user): bool
    {
        $sqlQuery = 'INSERT INTO users (user, password, teacher, people_id) VALUES (:user, :password, :teacher, :people_id);';

        $statement = $this->connection->prepare($sqlQuery);

        return $statement->execute([
            ':user' => $user->getId(),
            ':password' => $user->getPassword(),
            ':teacher' => $user->getIsTeacher()
        ]);
    }

    public function update(User $user): bool
    {
        $sqlQuery = 'UPDATE users SET password = :password WHERE id = :id;';

        $statement = $this->connection->prepare($sqlQuery);

        return $statement->execute([
            ':password' => $user->getPassword(),
            ':id' => $user->getId()
        ]);
    }

    public function remove(User $user): bool
    {
        $sqlRemove = 'DELETE FROM users WHERE id = :id;';

        $statement = $this->connection->prepare($sqlRemove);
        $statement->bindValue(':id', $user->getId());

        return $statement->execute();
    }
}