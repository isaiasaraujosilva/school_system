<?php

namespace Alura\Pdo\Domain\Model;

class People 
{
    protected ?int $peopleId;
    protected string $name;
    protected string $gender;
    protected \DateTimeInterface $birthDate;
    protected int $isAdmin;

    public function __construct(?int $peopleId, string $name, string $gender,\DateTimeInterface $birthDate, int $isAdmin)
    {
        $this->peopleId = $peopleId;
        $this->name = $name;
        $this->gender = $gender;
        $this->birthDate = $birthDate;
        $this->isAdmin = $isAdmin;
    }

//getters    
    public function getPeopleId()
    {
        return $this->peopleId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getBirthDate()
    {
        return $this->birthDate;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getIsAdmin()
    {
        return $this->isAdmin;
    }
}

?>