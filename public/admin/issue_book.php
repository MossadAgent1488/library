<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';
require_once '../auth/role_check.php';
require_once '../header.php';

requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $book_id   = (int)$_GET['book_id'];
    $reader_id = (int)$_POST['reader_id'];
    $due_date  = $_POST['due_date'];
    $issue_city = $_POST['issue_city'];
    $issue_address = $_POST['issue_address'];

    $issued_by = $_SESSION['user_id']; 

    if (!$book_id || !$reader_id || !$due_date) {
        die('Некорректные данные');
    }

    try {
        $db = DB::getConnection();

        $stmt = $db->prepare("CALL IssueBook(?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $book_id,
            $reader_id,
            $due_date,
            $issue_city,
            $issue_address, 
            $issued_by           
        ]);

        $stmt->closeCursor();

        echo "Книга успешно выдана";

    } catch (PDOException $e) {
        echo "Ошибка выдачи книги: " . $e->getMessage();
    }
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form method="post">    
    <label>Дата возврата:</label>
    <input type="reader_id" name="reader_id" required>
    <input type="date" name="due_date" required>

    <input name="issue_city" required>
    <input name="issue_adress" required>

    <button type="submit">Выдать книгу</button>
</form>


</body>
</html>

