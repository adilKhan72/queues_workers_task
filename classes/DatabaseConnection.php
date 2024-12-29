<?php
// /classes/DatabaseConnection.php

class DatabaseConnection {
    private static ?PDO $instance = null;

    private function __construct() {
        // Private to prevent instantiation
    }

    public static function getInstance(array $dbConfig): PDO {
        if (self::$instance === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                $dbConfig['host'],
                $dbConfig['port'],
                $dbConfig['database'],
                $dbConfig['charset']
            );

            try {
                self::$instance = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$instance;
    }

    public function __clone() {
        // Prevent cloning
        throw new \Exception("Cannot clone a singleton instance");
    }

    public function __wakeup() {
        // Prevent unserializing
        throw new \Exception("Cannot unserialize a singleton instance");
    }
}
