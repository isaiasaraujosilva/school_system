<?php

namespace Alura\Pdo\Domain\Controller;

use Alura\Pdo\Domain\Model\Teacher;

require_once '../../vendor/autoload.php';

interface TeacherController 
{
    public function insert(Teacher $teacher): bool;

    public function update(Teacher $teacher): bool;

    public function save(Teacher $teacher): bool;

    public function remove(Teacher $teacher): bool;
}