<?php 

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once '../../../../vendor/autoload.php';

$connection = ConnectDatabase::connect();
$repository = new PdoStudentRepository($connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student = $repository->getStudent(intval($_POST['id']));
    $repository->remove($student);
    header('Location: studentsModule.php');
} else {
    $student = $repository->getStudent(intval($_GET['id']));
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Remover Aluno</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Dev: Gustavo Albert">
    </head>

    <body>
        <div class="container">
            <h1><?php echo $student->name()?></h1>
            <h4><?php echo $student->birthDate()->format('d-m-Y')?></h4>
            <p><?php echo $student->getClassId()?></p>
        </div>
        <div id="confirmation-box">
            <form action="removeStudent.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <button class="btn">Confirmar</button>
            </form>
            <button class="btn" onclick="window.location.href = 'studentsModule.php'">Cancelar</button>
        </div>
    </body>
</html>