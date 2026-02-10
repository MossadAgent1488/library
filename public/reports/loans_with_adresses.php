<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';
require_once '../auth/role_check.php';

requireRole('admin');

$db = DB::getConnection();
$stmt = $db->query("SELECT * FROM v_loans_with_addresses");
$loans = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php require_once '../header.php';?>
<h2>Выдачи с адресами</h2>

<table border="1">
<tr>
    <th>Книга</th>
    <th>Читатель</th>
    <th>Адрес</th>
    <th>Дата выдачи</th>
    <th>Срок</th>
</tr>

<?php foreach ($loans as $loan): ?>
<tr>
    <td><?= htmlspecialchars($loan['title']) ?></td>
    <td><?= htmlspecialchars($loan['reader_id']) ?></td>
    <td><?= htmlspecialchars($loan['address']) ?></td>
    <td><?= $loan['issue_date'] ?></td>
    <td><?= $loan['due_date'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<a href="report_export.php?view=v_loans_with_adresses">
    Экспорт в TXT
</a>