<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once '../../../../vendor/autoload.php';

$connection = ConnectDatabase::connect();
$repository = new PdoStudentRepository($connection);

$students = [];
$students += $repository->allStudents();

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

    <?php include '../../elements/header-redirect.html'; ?>
    
    <h2>Estudantes matriculados</h2>
    
    <div id="container">
        <table>
            <tr>
                <th>Nome</th>
                <th>Data de Nascimento</th>
                <th>Classe Pertencente</th>
            </tr>
            <?php foreach ($students as $student) { ?>
                <tr>
                    <th><a href="student.php?id=<?php echo $student->id()?>"><?php echo $student->name() ?></a></th>
                    <th><?php echo $student->birthDate()->format('d-m-Y') ?></th>
                    <th><?php echo $student->getClassId() ?></th>
                    <th>
                        <button class="btn" id="x" onclick="window.location.href='removeStudent.php?id=<?php echo $student->id()?>'">
                            <img src="../../imgs/x-icon.svg" alt="x-icon">
                        </button>
                    </th>
                </tr>
            <?php } ?>
        </table>
    </div>

    <a href="registerStudent.php">Cadastrar Aluno</a>
</body>

</html>