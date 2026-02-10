<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';
require_once '../auth/role_check.php';
require_once '../header.php';

requireRole('admin');

$db = DB::getConnection(); 

$stmt = $db -> query( "
    SELECT * FROM v_loans_with_addresses
");

echo "<h1>Выдачи с адресами</h1>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "
        {$row['reader_name']} —
        {$row['title']} —
        {$row['address']}<br>
    ";
}


?>

<html>
    <button onclick="location.href = '../index.php'">back</button>
</html>