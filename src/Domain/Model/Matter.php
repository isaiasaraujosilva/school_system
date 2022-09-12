<?php

namespace Alura\Pdo\Domain\Model;

class Matter
{
    private ?int $id;
    private string $matter;
    private int $workload;
    private int $classId;

    public function __construct(?int $id, string $matter, int $workload, int $classId)
    {
        $this->id = $id;
        $this->matter = $matter;
        $this->workload = $workload;
        $this->classId = $classId;
    }

//getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getMatter(): string
    {
        return $this->matter;
    }

    public function getWorkload(): int
    {
        return $this->workload;
    }

    public function getClassId(): int
    {
        return $this->classId;
    }
}