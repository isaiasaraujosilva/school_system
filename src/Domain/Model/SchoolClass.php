<?php

namespace Alura\Pdo\Domain\Model;

require_once '../../../../vendor/autoload.php';

class SchoolClass 
{
    private ?int $id;
    private string $year;
    private string $identifier;
    private string $shift;
    
    public function __construct(?int $id, string $year, string $identifier, string $shift)
    {
        $this->id = $id;
        $this->year = $year;
        $this->identifier = $identifier;
        $this->shift = $shift;
    }

    public function defineId(int $id): void
    {
        if (!is_null($this->id)) {
            throw new \DomainException('Você só pode definir o ID uma vez.');
        }

        $this->id = $id;
    }

//getters    
    public function getId()
    {
        return $this->id;
    }
    
    public function getYear(): string
    {
        return $this->year;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
    
    public function getMatter(): string
    {
        return $this->matter;
    }
   
    public function getShift(): string
    {
        return $this->shift;
    }
}