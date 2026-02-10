<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';
require_once '../auth/role_check.php';
require_once '../header.php';

requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title        = trim($_POST['title']);
    $isbn         = trim($_POST['isbn']);
    $author_id    = (int)$_POST['author_id'];
    $genre_id     = (int)$_POST['genre_id'];
    $publish_year = (int)$_POST['publish_year'];

    if ($title === '' || $isbn === '') {
        die('Название и ISBN обязательны');
    }

    try {
        $db = DB::getConnection();

        $stmt = $db->prepare("CALL AddBook(?, ?, ?, ?, ?)");
        $stmt->execute([
            $title,
           
            $author_id,
            $genre_id,
            $publish_year,
             $isbn
        ]);
        $stmt->closeCursor();

        echo "Книга успешно добавлена";

    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
?>

<form method="post">    
    <label>Данные о книге:</label>
    <input name="title" required placeholder="Название">
    <input name="isbn" required placeholder="ISBN">
    <input name="author_id" required placeholder="Номер автора">
    <input name="genre_id" required placeholder="Номер жанра">
    <input name="publish_year" placeholder="Год публикации">

    <button type="submit">Добавить книгу</button>
</form>

<button onclick="location.href='../index.php'">Назад</button>