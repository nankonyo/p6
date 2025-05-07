<?php

namespace App\Models;

use Core\Model; // Pastikan sudah ada
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

        $stmt = $pdo->prepare("INSERT INTO device_info 
            (id_user, identifier, browser, os, device, ip_address, host_name, 
            location_city, location_region, location_country, user_agent) 
            VALUES 
            (:id_user, :identifier, :browser, :os, :device, :ip_address, :host_name, 
            :location_city, :location_region, :location_country, :user_agent)");

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
}
