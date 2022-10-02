<?php

namespace Alura\Pdo\Domain\Model;

class Teacher extends People
{
    private ?int $id;
    private int $peopleId;
    private int $matterId;

    public function __construct(?int $id, int $peopleId, string $name, string $gender, \DateTimeInterface $birthDate,int $matterId, int $isAdmin)
    {
        parent::__construct($peopleId, $name, $gender, $birthDate, $isAdmin);
        $this->id = $id;
        $this->peopleId = $peopleId;
        $this->matterId = $matterId;
    }

//getters
    public function getId()
    {
        return $this->id;
    }
    
    public function getPeopleId()
    {
        return $this->peopleId;
    }

    public function getMatterId()
    {
        return $this->matterId;
    }
}