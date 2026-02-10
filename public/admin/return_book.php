<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';
require_once '../auth/role_check.php';
require_once '../header.php';

requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $loan_id = (int)$_POST['loan_id'];

    if (!$loan_id) {
        die('Некорректный идентификатор выдачи');
    }

    try {
        $db = DB::getConnection();

        $stmt = $db->prepare("CALL ReturnBook(?)");
        $stmt->execute([
            $loan_id
        ]);

        $stmt->closeCursor();

        echo "Книга успешно возвращена";

    } catch (PDOException $e) {
        echo "Ошибка возврата: " . $e->getMessage();
    }
}
