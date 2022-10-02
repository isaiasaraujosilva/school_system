<?php

use Alura\Pdo\Infrastructure\Repository\PdoUserRepository;
use Alura\Pdo\Infrastructure\Repository\PdoPeopleRepository;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;
use Alura\Pdo\Infrastructure\Repository\PdoTeacherRepository;
use Alura\Pdo\Infrastructure\Persistence\ConnectDatabase;

require_once '../../vendor/autoload.php';

session_start();

$connection = ConnectDatabase::connect();

$userRepository = new PdoUserRepository($connection);
$peopleRepository = new PdoPeopleRepository($connection);
$studentRepository = new PdoStudentRepository($connection);
$teacherRepository = new PdoTeacherRepository($connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($userRepository->isValidUser($_POST['user'], $_POST['password'])) {
        $user = $userRepository->getUserByCredentials($_POST['user'], $_POST['password']);
        
        $people = $peopleRepository->getPeople($user->getPeopleId());

        $_SESSION['user'] = $user->getUser();
        $_SESSION['password'] = $user->getPassword();
        $_SESSION['teacher'] = $user->getIsTeacher();
        $_SESSION['people_id'] = $user->getReferenceId();

        if ($people->getIsAdmin() === 1) {
            header('Location: /pdo/src/Pages/admin/adminPanel.php');
        } else {
            if ($user->getIsTeacher() === 0) {
                header('Location: /pdo/src/Pages/student_scope/environments/student/studentsModule.php');
                die();
            } else {
                header('Location: /pdo/src/Pages/homePage.php');
                die();
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Dev: Gustavo Albert">
    </head>

    <!-- falta configurar o erro para quando o usuario digitado for invalido (elements/err-invalid-user.html) -->
    <body>
        <div class="box" id="login">
            <form action="index.php" method="POST">
                <div class="field">
                    <input type="text" name="user" placeholder="Seu usuário">
                </div>
                <div class="field">
                    <input type="password" name="password" placeholder="Digite sua senha">
                </div>
                <button type="submit">Entrar</button>
            </form>
        </div>
    </body>
</html>