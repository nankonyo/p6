<?php

namespace App\Models;

use Core\Model;

class User extends Model
{
    public function __construct()
    {
        parent::__construct(); // Memanggil konstruktor dari Core\Model
    }

    public function generateUniqueUsername(string $base): string
    {
        $pdo = $this->db->getConnection();

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
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }
    
    public function findAccount(string $input): ?array
    {
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :input OR username = :input OR phone = :input LIMIT 1");
        $stmt->execute(['input' => $input]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function publicRegister(array $data)
    {
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare("INSERT INTO users 
            (username, email,  password, id_role, created_at, updated_at, is_active) 
            VALUES 
            (:username, :email, :password, :id_role, :created_at, :updated_at, :is_active)");

        $data['created_at'] = $data['updated_at'] = date('Y-m-d H:i:s');

        return $stmt->execute($data);
    }

    public function isEmailVerified($id)
    {
        $pdo = $this->db->getConnection(); // ambil objek PDO
        $stmt = $pdo->prepare("SELECT email_ver_stat FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result ? (bool) $result['email_ver_stat'] : false;
    }

    public function getEmailById($id): ?string
    {
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare("SELECT email FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result['email'] ?? null;
    }

    public function findById(int $id): ?array
    {
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user ?: null;
    }
}
