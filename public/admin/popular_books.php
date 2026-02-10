<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';
require_once '../auth/role_check.php';
require_once '../header.php';

requireRole('admin');

$db = DB::getConnection();

$stmt = $db -> query( "
     SELECT * FROM v_popular_books
");

echo "<h1>Популярные книги</h1>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "
        {$row['title']} —
        выдана {$row['loan_count']} раз<br>
    ";
}?>

<button onclick="location.href='../index.php'">back</button>
