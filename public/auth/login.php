<?php session_start();
require_once 'DB.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login = trim($_POST['login']);
    $password = $_POST['password'];

    if ($login === '' || $password === '') {
        die("Введите логин и пароль");
    }

    $db = DB::getConnection();

    try {

        $stmt = $db->prepare("
            SELECT 
                u.user_id,
                u.password_hash,
                u.reader_id,
                r.role_name,
                u.login
            FROM Users u
            JOIN Roles r ON u.role_id = r.role_id
            WHERE u.login = ? AND u.is_active = TRUE
        ");
        $stmt->execute([$login]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            throw new Exception("Неверный логин или пароль");
        }

        if (!empty($user['reader_id'])) {
            $stmt = $db->prepare("
                SELECT 1
                FROM v_blacklisted_readers
                WHERE reader_id = ?
            ");
            $stmt->execute([$user['reader_id']]);

            if ($stmt->fetchColumn()) {
                throw new Exception("Вы заблокированы библиотекой");
            }
        }

        $_SESSION['user_id'] = $user['user_id'];
        if (!empty($user['reader_id'])) $_SESSION['reader_id'] = $user['reader_id'];
        $_SESSION['role'] = $user['role_name'];
        $_SESSION['login'] = $user['login'];

        header('Location: ../index.php');
        exit;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
require_once '../header.php';
?>



<form method="post">
    <h2>Вход</h2>
    Логин: <input name="login" required><br>
    Пароль: <input type="password" name="password" required><br>
    <button type="submit">Войти</button>
</form>

<?php require_once '../footer.php'; ?>