<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once '../../../../vendor/autoload.php';

session_start();

$connection = ConnectDatabase::connect();

$repository = new PdoStudentRepository($connection);

$student = $repository->getStudentByPeopleId($_SESSION['people_id']);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Alunos</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dev: Gustavo Albert">
</head>

<body>
    
    <h2>Olá, seja bem vindo</h2>
    <!-- começar e preparar esta tela para o estudante (student_panel) -->
    <ul>
        <li><a href="student.php?id=<?php echo $student->id() ?>">Meu Perfil</a></li>
        <li><a href="">Boletim</a></li>
        <li><a href="">Matérias</a></li>
    </ul>
</body>

</html>