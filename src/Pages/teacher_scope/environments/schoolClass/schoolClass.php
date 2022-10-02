<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoSchoolClassRepository;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once '../../../../vendor/autoload.php';

$connection = ConnectDatabase::connect();

$classRepository = new PdoSchoolClassRepository($connection);

$studentRepository = new PdoStudentRepository($connection);

$class = $classRepository->getClass(intval($_GET['id']));

$students = [];
$students += $studentRepository->getStudentsByClass(intval($_GET['id']));

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Dev: Gustavo Albert">
    </head>

    <body>
        <?php include '../../elements/schoolClassModule-redirect.html';?>
        <h3>TURMA: <?php echo "{$class->getYear()}{$class->getIdentifier()} ";?> TURNO: <?php echo strtoupper($class->getShift());?></h1>

        <div id="table-container">
        <table>
            <tr>
                <th>Nome</th>
                <th>Data de Nascimento</th>
                <th>Classe Pertencente</th>
            </tr>
            <?php foreach ($students as $student) { ?>
                <tr>
                    <th><a href="../student/student.php?id=<?php echo $student->id()?>"><?php echo $student->name() ?></a></th>
                    <th><?php echo $student->birthDate()->format('d-m-Y') ?></th>
                    <th><?php echo $student->getClassId() ?></th>
                    <th>
                        <button class="btn" id="x" onclick="window.location.href='/student/removeStudent.php?id=<?php echo $student->id()?>'">
                            <img src="../../imgs/x-icon.svg" alt="x-icon">
                        </button>
                    </th>
                </tr>
            <?php } ?>
        </table>
    </div>
    </body>
</html>