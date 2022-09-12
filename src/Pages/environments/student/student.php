<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once '../../../../vendor/autoload.php';

$connection = ConnectDatabase::connect();
$repository = new PdoStudentRepository($connection);

$student = $repository->getStudent(intval($_GET['id']));
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Perfil de Aluno</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Dev: Gustavo Albert">
    </head>

    <body>
        <?php include '../../elements/header-redirect.html';?>
        <h1><?php echo $student->name()?></h1>
        <h4><?php echo $student->birthDate()->format('d-m-Y')?></h4>
        <p><?php echo $student->getClassId()?></p>             
    </body>

</html>