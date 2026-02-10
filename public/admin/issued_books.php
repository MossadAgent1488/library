<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';
require_once '../header.php';

try {
    $db = DB::getConnection();

    $stmt = $db->query("SELECT * FROM v_issued_books");
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>

<h2>Выданные книги</h2>

<table border="1">
<tr>
    <th>Название</th>
    <th>Фамилия</th>
    <th>Имя</th>
    <th>Отчество</th>
    <th>Дата выдачи</th>
    <th>Крайний срок выдачи</th>
    <th></th>
</tr>

<?php foreach ($books as $book): ?>
<form method="post" action="return_book.php">
<tr>
    <input type = "hidden" name = "loan_id" value ="<?php echo $book['loan_id'];?>">
    <td><?= htmlspecialchars($book['title']) ?></td>
    <td><?= htmlspecialchars($book['last_name']) ?></td>
    <td><?= htmlspecialchars($book['first_name']) ?></td>
    <td><?= htmlspecialchars($book['middle_name']) ?></td>
    <td><?= htmlspecialchars($book['loan_date']) ?></td>
    <td><?= htmlspecialchars($book['due_date']) ?></td>
    <td><input type="submit" value="Подтвердить возврат"></td>
</tr>
</form>
<?php endforeach; ?>
</table>