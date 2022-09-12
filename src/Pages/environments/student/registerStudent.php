<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;
use Alura\Pdo\Infrastructure\Repository\PdoSchoolClassRepository;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once '../../../../vendor/autoload.php';

$connection = ConnectDatabase::connect();

$classRepository = new PdoSchoolClassRepository($connection);
$studentRepository = new PdoStudentRepository($connection);

$classes = $classRepository->allClasses();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student = new Student(null, $_POST['name'], new DateTimeImmutable($_POST['birth_date']), $_POST['class']);
    $studentRepository->save($student);

    header('Location: registerStudent.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Cadastrar Aluno</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Dev: Gustavo Albert">
    </head>

    <body>
        <?php include '../../elements/studentModule-redirect.html';?>
        <h1>Cadastrar novo aluno</h1>
        <form action="registerStudent.php" method="POST">
            <p>
                <label for="">Nome:</label>
                <input class="form-field" type="text" name="name" id="name">
            </p>
            <p>
                <label for="">Data de Nascimento:</label>
                <input class="form-field" type="date" name="birth_date" id="name">
            </p>
            <p>
                <label for="">Classe pertencente:</label>
                <select name="class" id="class">
                    <?php foreach ($classes as $class) {?>
                        <option value="<?php echo $class->getId()?>"><?php echo $class->getIdentifier()?></option>
                    <?php } ?>
                </select>
            </p>
            <p>
                <button class="btn">Cadastrar</button>
            </p>
        </form>
    </body>
</html>