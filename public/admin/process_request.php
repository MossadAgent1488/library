<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';
require_once '../auth/role_check.php';
require_once '../header.php';

requireRole('admin');
$db = DB::getConnection();?>

<?php 
$stmt = $db->query("SELECT * FROM v_pending_requests");
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);?>

<h2>Активные запросы</h2>

<table border="1">
<tr>
    <th>Фамилия автора</th>
    <th>Название книги</th>
    <th></th>
    <th></th>
    
</tr><?php

foreach ($requests as $req): ?>
<form method="post" action="process_request.php">
    <tr>
    <input type="hidden" name="request_id" value="<?= $req['request_id'] ?>">
    <input type="hidden" name="book_id" value="<?= $req['book_id'] ?>">

    <td><?= htmlspecialchars($req['last_name']) ?></td>
    <td> <?= htmlspecialchars($req['title']) ?></td>

    <td><button name="action" value="approve">Одобрить</button></td>
    <td><button name="action" value="reject">Отклонить</button></td>
    </tr>
</form>
<?php endforeach; ?>

<?php

if(array_key_exists('request_id', $_POST)){
$request_id = (int)$_POST['request_id'] ?? '';
$action     = $_POST['action'] ?? '';
$user_id   = $_SESSION['user_id'];

try {
    $db->beginTransaction();

    $stmt = $db->prepare("
        SELECT reader_id, book_id
        FROM BookRequests
        WHERE request_id = ? AND status = 'pending'
        FOR UPDATE
    ");
    $stmt->execute([$request_id]);
    $request = $stmt->fetch();

    if (!$request) {
        throw new Exception("Заявка не найдена или уже обработана");
    }

    if ($action === 'approve') {

        $stmt = $db->prepare("CALL IssueBook(?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $request['book_id'],
            $request['reader_id'],
            date('Y-m-d', strtotime('+14 days')),
            '',
            '',
            $user_id
        ]);
        $stmt->closeCursor();

        $status = 'approved';

    } else {
        $status = 'rejected';
    }

    $stmt = $db->prepare("
        UPDATE BookRequests
        SET status = ?, processed_by = ?, processed_date = NOW()
        WHERE request_id = ?
    ");
    $stmt->execute([$status, $user_id, $request_id]);

    $db->commit();
    echo "Заявка обработана";

} catch (Exception $e) {
    $db->rollBack();
    echo "Ошибка: " . $e->getMessage();
}
}
?>



<?php require_once '../header.php';?>