<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';
require_once '../auth/role_check.php';
require_once '../header.php';

requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $last  = trim($_POST['last_name']);
    $first = trim($_POST['first_name']);
    $b_year = trim($_POST['birth_year']);

    if ($last === '' || $first === '') {
        die('Имя и фамилия обязательны');
    }


    $db = DB::getConnection();

    try {
        $stmt = $db->prepare("CALL AddAuthor(?, ?, ?)");
        $stmt->execute([$last, $first, $b_year]);
        $stmt->closeCursor();

        echo "Автор добавлен";

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}?>

<form method="post">    
    <label>Данные об авторе:</label>
    <input name="last_name" required placeholder="Фамилия">
    <input name="first_name" required placeholder="Имя">
    <input name="birth_year" placeholder="Год рождения">

    <button type="submit">Добавить автора</button>
</form>

<button onclick="location.href='../index.php'">Назад</button>
