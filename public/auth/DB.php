<?php
class DB {
    public static function getConnection() {
        return new PDO(
            "mysql:host=MySQL-8.4; dbname=LibraryDB; charset=utf8mb4",
            "admin",
            "admin",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
}
?>