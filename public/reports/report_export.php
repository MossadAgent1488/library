<?php
require_once '../DB.php';
require_once '../auth/auth_check.php';
require_once '../txt/txt_helper.php';

$allowedViews = [
    'v_available_books'        => 'available_books',
    'v_unavailable_books'      => 'unavailable_books',
    'v_popular_books'          => 'popular_books',
    'v_overdue_loans'           => 'overdue_loans',
    'v_active_users'            => 'active_users',
    'v_books_by_genre'          => 'books_by_genre',
    'v_loans_with_addresses'    => 'loans_with_addresses'
];

$view = $_GET['view'] ?? null;

if (!isset($allowedViews[$view])) {
    die('Недопустимый отчёт');
}

$db = DB::getConnection();

$stmt = $db->query("SELECT * FROM {$view}");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$rows) {
    die('Нет данных для отчёта');
}

$headers = array_keys($rows[0]);
$data = array_map('array_values', $rows);

createTXT($allowedViews[$view], $headers, $data);
