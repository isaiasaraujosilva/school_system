<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoSchoolClassRepository;

require_once '../../../../vendor/autoload.php';

$connection = ConnectDatabase::connect();

$repository = new PdoSchoolClassRepository($connection);

$classes = [];
$classes += $repository->allClasses();

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Turmas</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Dev: Gustavo Albert">
    </head>

    <body>
        <?php include '../../elements/header-redirect.html'; ?>
        <h2>Turmas</h2>

        <div id="table-container">
            <table>
                <tr>
                    <th>Ano</th>    
                    <th>ID</th>
                    <th>Turno</th>
                </tr>
                <?php foreach ($classes as $class) { ?>
                    <tr>
                        <th><?php echo $class->getYear(); ?></th>
                        <th><?php echo $class->getIdentifier(); ?></th>
                        <th><?php echo $class->getShift(); ?></th>
                        <th><button class="btn" id="go-to-class" onclick="window.location.href = 'schoolClass.php?id=<?php echo $class->getId()?>'">
                            <img src="../../imgs/go-to-class.svg" alt="go-to-class-icon">
                        </button></th>
                    </tr>
                <?php }?>
            </table>
        </div>
    </body>
</html>