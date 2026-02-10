<?php
require_once 'DB.php';
require_once 'auth/auth_check.php';
require_once 'header.php';

$user_id = $_SESSION['user_id'];

$db = DB::getConnection();

$stmt = $db->query("SELECT ml.*
    FROM v_reader_loan_history AS ml
    JOIN Users AS u ON u.reader_id = ml.reader_id
    WHERE u.user_id = '".$user_id."'");

$loans = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<h2>История выдач</h2>

<table border="1">
<tr>
    <th>Название книги</th>
    <th>Дата выдачи</th>
    <th>Крайний срок возврата</th>
    <th>Дата возврата</th>
</tr>

<?php foreach ($loans as $loan): ?>
<tr>
    <td><?= htmlspecialchars($loan['title']) ?></td>
    <td><?= htmlspecialchars($loan['loan_date']) ?></td>
    <td><?= htmlspecialchars($loan['due_date']) ?></td>
    <td><?= htmlspecialchars($loan['return_date']) ?></td>
</tr>
<?php endforeach; ?>
</table>