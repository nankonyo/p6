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
    
}
