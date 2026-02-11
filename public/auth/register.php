<?php require_once '../header.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
    <input name="last_name" placeholder="Фамилия" required>
    <input name="first_name" placeholder="Имя" required>
    <input name="middle_name" placeholder="Отчество">
    <input name="phone" placeholder="Телефон" required>
    <input name="email" placeholder="Email" required>
    <input name="address_city" placeholder="Город">
    <input name="address_street" placeholder="Улица">
    <input name="address_house" placeholder="Дом">
    <input name="address_apartment" placeholder="Квартира">

    <input name="login" placeholder="Логин" required>
    <input type="password" name="password" placeholder="Пароль" required>

    <button type="submit">Зарегистрироваться</button>
</form>

</body>
</html>



<?php
require_once 'DB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $last_name   = trim($_POST['last_name']);
    $first_name  = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name'] ?? '');
    $phone     = trim($_POST['phone']);
    $email     = trim($_POST['email']);
    $address_city     = trim($_POST['address_city']);
    $address_street     = trim($_POST['address_street']);
    $address_house    = trim($_POST['address_house']);
    $address_apartment    = trim($_POST['address_apartment']);
    $date = date('Y-m-d');

    $login    = trim($_POST['login']);
    $password = $_POST['password'];

    if ($last_name === '' || $first_name === '' || $login === '' || $password === '') {
        die('Заполните все обязательные поля');
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $db = DB::getConnection();
    $r_id = $db->query("SELECT COUNT(*) FROM Readers");
        $ro_id = $r_id->fetchAll(); echo (int)($ro_id[0][0]);

    try {
        $db = DB::getConnection();

        $stmt = $db->prepare("CALL AddReader(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $last_name,
            $first_name,
            $middle_name,
            $phone,
            $email,
            $address_city,
            $address_street,
            $address_house,
            $address_apartment
        ]);

        $stmt = $db->prepare("CALL AddUser(?, ?, ?)");
        $r_id = $db->query("SELECT COUNT(*) FROM Readers");
        $ro_id = $r_id->fetchAll();
        $stmt->execute([
            $login,
            $password_hash,
            (int)($ro_id[0][0])+1
        ]);

        $stmt->closeCursor();

        echo "Регистрация прошла успешно";

    } catch (PDOException $e) {
        echo "Ошибка регистрации: " . $e->getMessage();
    }
}?>

<?php require_once '../footer.php';?>
