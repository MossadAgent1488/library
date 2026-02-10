<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';
require_once '../auth/role_check.php';
require_once '../header.php';

requireRole('admin');

$db = DB::getConnection();
$stmt = $db->query("SELECT * FROM v_active_users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Активные пользователи</h2>

<table border="1">
<tr>
    <th>Логин</th>
    <th>Роль</th>
</tr>

<?php foreach ($users as $user): ?>
<tr>
    <td><?= htmlspecialchars($user['login']) ?></td>
    <td><?= htmlspecialchars($user['role_name']) ?></td>
</tr>
<?php endforeach; ?>
</table>

<a href="report_export.php?view=v_active_users">
    Экспорт в TXT
</a>
