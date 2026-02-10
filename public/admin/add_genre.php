<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';
require_once '../auth/role_check.php';
require_once '../header.php';

requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['genre_name']);

    if ($name === '') {
        die('Название жанра не может быть пустым');
    }

    try {
        $db = DB::getConnection();

        $stmt = $db->prepare("CALL AddGenre(?)");
        $stmt->execute([$name]);
        $stmt->closeCursor();

        echo "Жанр успешно добавлен";

    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
?>

<form method="post">    
    <label>Данные о жанре:</label>
    <input name="genre_name" required placeholder="Название жанра">
    

    <button type="submit">Добавить жанр</button>
</form>

<button onclick="location.href='../index.php'">Назад</button>