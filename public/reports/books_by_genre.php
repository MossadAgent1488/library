<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';


$db = DB::getConnection();
$stmt = $db->query("SELECT * FROM v_books_by_genre ORDER BY genre_name");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php require_once '../header.php';?>
<h2>Книги по жанрам</h2>

<table border="1">
<tr>
    <th>Жанр</th>
    <th>Количество книг</th>
</tr>

<?php foreach ($data as $row): ?>
<tr>
    <td><?= htmlspecialchars($row['genre_name']) ?></td>
    <td><?= htmlspecialchars($row['book_count']) ?></td>
</tr>
<?php endforeach; ?>
</table>

<a href="report_export.php?view=v_books_by_genre">
    Экспорт в TXT
</a>