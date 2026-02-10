<?php
require_once 'DB.php';
require_once 'auth/auth_check.php';
require_once 'header.php';

$db = DB::getConnection();

    $stmt = $db->query("SELECT * FROM v_available_books");
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

$reader_id = $_SESSION['reader_id'];
if (array_key_exists('book_id',$_POST)){
$book_id   = (int)$_POST['book_id'];

try {
    

    $stmt = $db->prepare("
        INSERT INTO BookRequests (reader_id, book_id)
        VALUES (?, ?)
    ");
    $stmt->execute([$reader_id, $book_id]);

    echo "Запрос на выдачу книги отправлен";

} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}}
?>

<h2>Доступные книги</h2>

<table border="1">
<tr>
    <th>Название</th>
    <th>Автор</th>
    <th>Жанр</th>
    <th></th>
</tr>

<?php foreach ($books as $book): ?>
<form method="post" action="request_book.php">
<tr>
    <input type = "hidden" name = "book_id" value ="<?php echo $book['book_id'];?>">
    <td><?= htmlspecialchars($book['title']) ?></td>
    <td><?= htmlspecialchars($book['last_name']) ?></td>
    <td><?= htmlspecialchars($book['genre_name']) ?></td>
    <td><input type="submit" value="Заказать"></td>
</tr>
</form>
<?php endforeach; ?>
</table>

<?php require_once 'footer.php'; ?>