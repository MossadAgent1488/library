<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';
require_once '../auth/role_check.php';
require_once '../header.php';

requireRole('admin');

$db = DB::getConnection();
$stmt = $db->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Активные пользователи</h2>

<table border="1">
<tr>
    <th>Логин</th>
    <th>Пароль</th>
    <th>Номер читателя</th>
    <th>Номер роли</th>
    <th>Активность</th>
</tr>

<?php foreach ($users as $user): ?>
<tr>
    <td><?= htmlspecialchars($user['login']) ?></td>
    <td><?= htmlspecialchars($user['password']) ?></td>
    <td><?= htmlspecialchars($user['reader_id']) ?></td>
    <td><?= htmlspecialchars($user['role_id']) ?></td>
    <td><?= htmlspecialchars($user['is_active']) ?></td>
</tr>
<?php endforeach; ?>
</table>
