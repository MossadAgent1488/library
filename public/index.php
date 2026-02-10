<?php
require_once 'header.php';
?>

<h2>Добро пожаловать в библиотеку</h2>

<?php if (empty($_SESSION['user_id'])): ?>
    <p>Пожалуйста, войдите или зарегистрируйтесь.</p>
<?php else: ?>
    <p>Вы вошли как <strong><?= htmlspecialchars($_SESSION['login']) ?></strong></p>
<?php endif; ?>

<?php require_once 'footer.php'; ?>
