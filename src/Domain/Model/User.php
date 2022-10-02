<?php

namespace Alura\Pdo\Domain\Model;

use DomainException;

class User extends People
{
    private ?int $id;
    private string $user;
    private string $password;
    private int $isTeacher;
    private int $referenceId;

    public function __construct(?int $id, string $user, string $password, int $isTeacher, int $referenceId, int $peopleId, string $name, string $gender, \DateTimeInterface $birthDate, int $isAdmin)
    {
        parent::__construct($peopleId, $name, $gender,$birthDate, $isAdmin);
        $this->id = $id;
        $this->user = $user;
        $this->password = sha1($password);
        if ($isTeacher>=0 and $isTeacher<=1) {
            $this->isTeacher = $isTeacher;
        } else {
            throw new DomainException('Você não pode atribuir estes valores para o campo isTeacher.');
        }
        $this->referenceId = $referenceId;
    }

//getters
    public function getId()
    {
        return $this->id;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function getIsTeacher()
    {
        return $this->isTeacher;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getReferenceId()
    {
        return $this->referenceId;
    }
}