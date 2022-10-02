<?php

namespace Alura\Pdo\Domain\Model;

require_once '../../../../vendor/autoload.php';

class Student extends People
{
    private ?int $id;
    private int $classId;
    private int $peopleId;

    public function __construct(?int $id, ?int $peopleId, string $name, string $gender, \DateTimeInterface $birthDate, int $classId, int $isAdmin)
    {
        parent::__construct($peopleId, $name, $gender,$birthDate, $isAdmin);
        $this->id = $id;
        $this->classId = $classId;
        $this->peopleId = $peopleId;
    }

    public function age(): int
    {
        return $this->getBirthDate()
            ->diff(new \DateTimeImmutable())
            ->y;
    }

//getters
    public function id(): ?int
    {
        return $this->id;
    }

    public function getClassId()
    {
        return $this->classId;
    }

    public function getPeopleId()
    {
        return $this->peopleId;
    }
}
