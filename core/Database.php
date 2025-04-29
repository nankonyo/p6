<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    // Deklarasi properti kelas
    private $driver;
    private $host;
    private $port;
    private $dbname;
    private $username;
    private $password;
    private $charset;
    private $connection;

    public function __construct()
    {
        // Mengambil konfigurasi koneksi dari variabel lingkungan
        $this->driver   = $_ENV['DB_CONNECTION'] ?? 'mysql'; // default mysql
        $this->host     = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $this->port     = $_ENV['DB_PORT'] ?? ($this->driver === 'pgsql' ? '5432' : '3306');
        $this->dbname   = $_ENV['DB_DATABASE'] ?? '';
        $this->username = $_ENV['DB_USERNAME'] ?? 'root';
        $this->password = $_ENV['DB_PASSWORD'] ?? '';
        $this->charset  = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

        // Membuat DSN (Data Source Name) untuk koneksi ke database
        $dsn = $this->getDsn();

        try {
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            die();
        }
    }

    // Method untuk mendapatkan koneksi
    public function getConnection()
    {
        return $this->connection;
    }

    // Method untuk mendapatkan DSN yang sesuai dengan jenis database
    private function getDsn()
    {
        if ($this->driver === 'pgsql') {
            return "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";
        } elseif ($this->driver === 'mysql') {
            return "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset={$this->charset}";
        }
        // Bisa ditambahkan driver lainnya (misalnya SQLite, SQLServer) jika perlu
        throw new PDOException("Unsupported database driver: {$this->driver}");
    }
}
