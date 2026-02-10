<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';

$db = DB::getConnection();
$stmt = $db->query("SELECT * FROM v_popular_books");
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php require_once '../header.php';?>
<h2>Популярные книги</h2>

<table border="1">
<tr>
    <th>Название</th>
    <th>Количество выдач</th>
</tr>

<?php foreach ($books as $book): ?>
<tr>
    <td><?= htmlspecialchars($book['title']) ?></td>
    <td><?= $book['loan_count'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<a href="report_export.php?view=v_popular_books">
    Экспорт в TXT
</a>
