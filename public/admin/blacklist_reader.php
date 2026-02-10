<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';
require_once '../auth/role_check.php';

requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $reader_id = (int)$_POST['reader_id'];
    $reason    = trim($_POST['reason']);

    if (!$reader_id || $reason === '') {
        die('Некорректные данные');
    }

    try {
        $db = DB::getConnection();

        $stmt = $db->prepare("CALL BlacklistReader(?, ?)");
        $stmt->execute([
            $reader_id,
            $reason
        ]);

        $stmt->closeCursor();

        echo "Читатель добавлен в чёрный список";

    } catch (PDOException $e) {
        echo "Ошибка блокировки: " . $e->getMessage();
    }
}
?>

<form method="post">
    <input type="number" min="1" name="reader_id">

    <textarea name="reason" placeholder="Причина блокировки" required></textarea>

    <button type="submit">Заблокировать</button>
</form>