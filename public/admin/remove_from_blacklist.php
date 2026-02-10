<form method="post">
    <input type="hidden" name="reader_id" value="5">
    <button type="submit">Снять блокировку</button>
</form>

<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';
require_once '../auth/role_check.php';
require_once '../header.php';

requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $reader_id = (int)$_POST['reader_id'];

    if (!$reader_id) {
        die('Некорректный идентификатор читателя');
    }

    try {
        $db = DB::getConnection();

        $stmt = $db->prepare("CALL RemoveFromBlacklist(?)");
        $stmt->execute([$reader_id]);
        $stmt->closeCursor();

        echo "Читатель удалён из чёрного списка";

    } catch (PDOException $e) {
        echo "Ошибка снятия блокировки: " . $e->getMessage();
    }
}
