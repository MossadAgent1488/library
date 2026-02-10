<?php

function createTXT(string $title, array $headers, array $rows): void
{
    header('Content-Type: text/plain; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $title . '.txt"');

   
    echo $title . PHP_EOL;
    echo str_repeat('=', mb_strlen($title)) . PHP_EOL . PHP_EOL;


    echo implode(" | ", $headers) . PHP_EOL;
    echo str_repeat('-', 80) . PHP_EOL;


    foreach ($rows as $row) {
        $line = array_map(
            fn($cell) => str_replace(["\r", "\n"], ' ', (string)$cell),
            $row
        );
        echo implode(" | ", $line) . PHP_EOL;
    }

    exit;
}
?>