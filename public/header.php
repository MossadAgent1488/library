<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ru">
    <link id="theme-style" rel="stylesheet" href="/public/assets/css/style.css">


<head>
    <meta charset="UTF-8">
    <title>Библиотека</title>
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>

<header>
    <h1>📚 Библиотека</h1>

<script defer src="/public/assets/js/theme.js"></script>  


    <nav>
        <a href="/public/index.php">Главная</a>

        <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="/public/reports/available_books.php">Каталог</a>
            <a href="/public/help.php">Справка</a>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="/public/admin/add.php">Добавить</a>
                <a href="/public/admin/dashboard.php">Статистика</a>
                <a href="/public/admin/process_request.php">Запросы</a>
                <a href="/public/admin/issued_books.php">Выдачи</a>
                <a href="/public/auth/logout.php">Выход</a>
            <?php endif; if($_SESSION['role'] === 'user'): ?>
            <a href="/public/request_book.php">Сделать заказ</a>
            <a href="/public/my_loans.php">Мои выдачи</a>
            <a href="/public/auth/logout.php">Выход</a>
        <?php endif;  else: ?>
            <a href="/public/auth/login.php">Вход</a>
            <a href="/public/auth/register.php">Регистрация</a>
        <?php endif; ?>
    </nav>
</header>

<main>