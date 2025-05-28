<?php

namespace App\Helpers;

class DeviceInfoHelper
{
    public static function getDeviceInfo($userAgent)
    {
        // Cek apakah info sudah tersimpan di session
        if (isset($_SESSION['device_info'])) {
            $deviceInfo = $_SESSION['device_info'];
            $deviceInfo['from_cache'] = true;
            return $deviceInfo;
        }

        // Ambil info dari user agent
        $parser = new \WhichBrowser\Parser($userAgent);
        $browser = $parser->browser->name . ' ' . ($parser->browser->version ? $parser->browser->version->value : 'Unknown');
        $os = $parser->os->name . ' ' . ($parser->os->version ? $parser->os->version->value : 'Unknown');
        $device = $parser->device->type;

        // Ambil IP client
        $ipAddress = self::getClientIp();

        // Resolusi host name
        $hostName = gethostbyaddr($ipAddress);

        // Ambil lokasi dari IP dengan API
        $accessKey = $_ENV['API_IPINFO_KEY'] ?? '';
        $location = self::getLocationFromIP($ipAddress, $accessKey);

        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? $userAgent;

        $deviceInfo = [
            'browser' => $browser,
            'os' => $os,
            'device' => $device,
            'ip_address' => $ipAddress,
            'host_name' => $hostName,
            'location' => $location,
            'user_agent' => $user_agent,
            'from_cache' => false
        ];

        // Simpan ke session
        $_SESSION['device_info'] = $deviceInfo;

        return $deviceInfo;
    }

    // Ambil IP asli dari client
    private static function getClientIp()
    {
        $keys = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($keys as $key) {
            if (array_key_exists($key, $_SERVER)) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                        return $ip;
                    }
                }
            }
        }

        return $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
    }

    // Ambil lokasi berdasarkan IP
    public static function getLocationFromIP($ipAddress, $accessKey)
    {
        if (empty($accessKey)) {
            return ['city' => 'Unknown', 'region' => 'Unknown', 'country' => 'Unknown'];
        }

        $url = "http://ipinfo.io/{$ipAddress}/json?token={$accessKey}";
        $response = @file_get_contents($url);

        if ($response === FALSE) {
            return ['city' => 'Unknown', 'region' => 'Unknown', 'country' => 'Unknown'];
        }

        $data = json_decode($response, true);
        return [
            'city' => $data['city'] ?? 'Unknown',
            'region' => $data['region'] ?? 'Unknown',
            'country' => $data['country'] ?? 'Unknown'
        ];
    }

    // Buat hash identifier dari data perangkat
    public static function generateIdentifier(array $deviceInfo)
    {
        $raw = implode('|', [
            $deviceInfo['browser'],
            $deviceInfo['os'],
            $deviceInfo['device'],
            $deviceInfo['ip_address'],
            $deviceInfo['host_name'],
            $deviceInfo['location']['city'],
            $deviceInfo['location']['region'],
            $deviceInfo['location']['country']
        ]);

        return hash('sha256', $raw);
    }
}
