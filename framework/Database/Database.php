<?php

namespace JonathanRayln\Framework\Database;

use PDO;

/**
 * Class Database
 *
 * @package JonathanRayln\Framework\Database;
 */
class Database
{
    private static ?Database $instance = null;
    private static PDO $connection;

    public function __construct($host, $dbName, $user, $password)
    {
        self::$connection = new PDO("mysql:dbname={$dbName};host={$host}", $user, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public static function getInstance(): ?Database
    {
        if (is_null(self::$instance)) {
            self::$instance = new Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
        }
        return self::$instance;
    }

    public static function getConnection(): PDO
    {
        return self::$connection;
    }
}