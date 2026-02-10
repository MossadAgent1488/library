<?php
function requireRole(string $role) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        die('Доступ запрещён');
    }
}
