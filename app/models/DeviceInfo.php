<?php

namespace App\Models;

use Core\Model;
use Core\Database;

class DeviceInfo extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(array $data): bool
    {
        $pdo = $this->db->getConnection();

        // Pastikan nilai boolean diubah ke format yang benar
        $data['stat'] = ($data['stat']) ? 'TRUE' : 'FALSE'; // Convert boolean to 'TRUE'/'FALSE' string

        // Pastikan parameter :stat ada dalam query
        $stmt = $pdo->prepare("INSERT INTO device_info 
            (id_user, identifier, browser, os, device, ip_address, host_name, 
            location_city, location_region, location_country, user_agent, stat) 
            VALUES 
            (:id_user, :identifier, :browser, :os, :device, :ip_address, :host_name, 
            :location_city, :location_region, :location_country, :user_agent, :stat)");

        return $stmt->execute($data);
    }

    public function saveOrUpdate(array $data): bool
    {
        $pdo = $this->db->getConnection();

        // Cek apakah kombinasi id_user dan identifier sudah ada
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM device_info WHERE id_user = :id_user AND identifier = :identifier");
        $stmt->execute([
            'id_user' => $data['id_user'],
            'identifier' => $data['identifier']
        ]);

        if ($stmt->fetchColumn() > 0) {
            // Jika sudah ada, update hanya kolom created_at
            $stmt = $pdo->prepare("UPDATE device_info SET created_at = NOW() 
                WHERE id_user = :id_user AND identifier = :identifier");
            return $stmt->execute([
                'id_user' => $data['id_user'],
                'identifier' => $data['identifier']
            ]);
        }

        // Jika belum ada, lakukan insert
        return $this->insert($data);
    }

    public function isDeviceKnown(int $userId, string $identifier): bool
    {
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM device_info WHERE id_user = :id_user AND identifier = :identifier AND stat = 'true'");
        $stmt->execute([
            'id_user' => $userId,
            'identifier' => $identifier,
        ]);
        return $stmt->fetchColumn() > 0;
    }

    // Fungsi baru untuk mencari perangkat berdasarkan user_id dan identifier
    public function findByUserId(int $userId)
    {
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM device_info WHERE id_user = :id_user");
        $stmt->execute([
            'id_user' => $userId
        ]);
        return $stmt->fetch();
    }

    public function getInfoDevice($userId, $identifier)
    {
        $pdo = $this->db->getConnection();

        $sql = "SELECT * FROM device_info WHERE id_user = :id_user AND identifier = :identifier LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_user' => $userId,
            ':identifier' => $identifier
        ]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateVerificationToken($id_user, $identifier, $token)
    {
        // Query UPDATE untuk menyertakan token dan token_created_at
        $sql = "UPDATE device_info 
                SET token = :token, token_created_at = NOW()
                WHERE id_user = :id_user AND identifier = :identifier";

        $pdo = $this->db->getConnection(); // Pastikan ini mengembalikan objek PDO
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':identifier', $identifier);
        $stmt->bindParam(':token', $token);

        return $stmt->execute();
    }

    public function canResendToken($id_user, $identifier): bool
    {
        $pdo = $this->db->getConnection();
        $sql = "SELECT token_created_at FROM device_info 
                WHERE id_user = :id_user AND identifier = :identifier";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_user' => $id_user,
            ':identifier' => $identifier
        ]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$result || !$result['token_created_at']) {
            return true; // belum ada token sebelumnya, boleh kirim
        }

        $createdAt = strtotime($result['token_created_at']);
        return (time() - $createdAt) >= 120; // boleh kirim jika sudah lewat 2 menit
    }

    public function verifyEmailToken($token)
    {
        $pdo = $this->db->getConnection();

        // Ambil user dan identifier berdasarkan token yang belum kadaluarsa (≤ 2 menit)
        $stmt = $pdo->prepare("
            SELECT id_user, identifier
            FROM device_info
            WHERE token = :token
            AND token_created_at >= NOW() - INTERVAL '2 minutes'
        ");
        $stmt->execute([':token' => $token]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            return false; // Token tidak valid atau sudah kadaluarsa
        }

        $id_user = $row['id_user'];
        $identifier = $row['identifier'];

        // Update status perangkat menjadi 'true'
        $update = $pdo->prepare("
            UPDATE device_info
            SET stat = 'true'
            WHERE id_user = :id_user AND identifier = :identifier
        ");
        $update->execute([
            ':id_user' => $id_user,
            ':identifier' => $identifier
        ]);

        return $id_user;
    }
}
