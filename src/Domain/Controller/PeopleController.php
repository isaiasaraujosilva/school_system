<?php

namespace Alura\Pdo\Domain\Controller;

use Alura\Pdo\Domain\Model\People;

require_once '../../vendor/autoload.php';

interface PeopleController 
{
    public function insert(People $people): bool;

    public function update(People $people): bool;

    public function save(People $people): bool;

    public function remove(People $people): bool;
}