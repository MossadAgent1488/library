<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';
require_once '../auth/role_check.php';
require_once '../header.php';

requireRole('admin');

$db = DB::getConnection();
$stmt = $db->query("SELECT * FROM v_pending_requests");
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Активные запросы</h2>

<table border="1">
<tr>
    <th>Номер запроса</th>
    <th>Дата запроса</th>
    <th>Фамилия читателя</th>
    <th>Имя читателя</th>
    <th>Название книги</th>
    <th>Номер книги</th>
    
</tr>

<?php foreach ($requests as $request): ?>
<tr>
    <td><?= htmlspecialchars($request['request_id']) ?></td>
    <td><?= htmlspecialchars($request['request_date']) ?></td>
    <td><?= htmlspecialchars($request['last_name']) ?></td>
    <td><?= htmlspecialchars($request['first_name']) ?></td>
    <td><?= htmlspecialchars($request['title']) ?></td>
    <td><?= htmlspecialchars($request['book_id']) ?></td>
</tr>
<?php endforeach; ?>
</table>

<a href="report_export.php?view=v_pending_requests">
    Экспорт в TXT
</a>
