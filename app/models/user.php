<?php

namespace App\Models;

use Core\Database;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function generateUniqueUsername(string $base): string
    {
        $pdo = $this->db->getConnection();

        // Normalisasi base username: lowercase + alfanumerik
        $base = preg_replace('/[^a-z0-9]/', '', strtolower($base));
        if (empty($base)) {
            $base = 'user';
        }

        $username = $base;
        $i = 1;

        while (true) {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);

            if ($stmt->fetchColumn() == 0) {
                return $username;
            }

            $username = $base . $i;
            $i++;
        }
    }

    public function isEmailExists(string $email): bool
    {
        $pdo = $this->db->getConnection();
        
        // Cek apakah email sudah terdaftar di database
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        return $stmt->fetchColumn() > 0;
    }

    public function isPhoneExists(string $phone): bool
    {
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE phone = :phone");
        $stmt->execute(['phone' => $phone]);
        return $stmt->fetchColumn() > 0;
    }

    public function publicRegister(array $data)
    {
        $pdo = $this->db->getConnection();

        $stmt = $pdo->prepare("INSERT INTO users 
            (username, email, phone, password, id_role, created_at, updated_at, is_active) 
            VALUES 
            (:username, :email, :phone, :password, :id_role, :created_at, :updated_at, :is_active)");

        $data['created_at'] = $data['updated_at'] = date('Y-m-d H:i:s');

        return $stmt->execute($data);
    }

    public function findByEmailOrPhone(string $input): ?array
    {
        $pdo = $this->db->getConnection();

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :input OR phone = :input LIMIT 1");
        $stmt->execute(['input' => $input]);

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user ?: null;
    }


}
