<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';
require_once '../header.php';

$db = DB::getConnection();

$stmt = $db->query("SELECT * FROM v_available_books");
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Доступные книги</h2>

<table border="1">
<tr>
    <th>Название</th>
    <th>Автор</th>
    <th>Жанр</th>
</tr>

<?php foreach ($books as $book): ?>
<tr>
    <td><?= htmlspecialchars($book['title']) ?></td>
    <td><?= htmlspecialchars($book['last_name']) ?></td>
    <td><?= htmlspecialchars($book['genre_name']) ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php if($_SESSION['role'] === 'admin'):?>
<a href="report_export.php?view=v_available_books">
    Экспорт в TXT
</a>
<?php endif;?>