<?php

namespace Alura\Pdo\Domain\Controller;

use Alura\Pdo\Domain\Model\Matter;

require_once '../../vendor/autoload.php';

interface MatterController 
{
    public function getMatter(int $id): Matter;

    public function insert(Matter $matter): bool;

    public function update(Matter $matter): bool;

    public function save(Matter $matter): bool;

    public function remove(Matter $matter): bool;
}