<?php

namespace App\Helpers;

class DeviceInfoHelper
{
    public static function getDeviceInfo($userAgent)
    {
        // Ambil info dari user agent
        $parser = new \WhichBrowser\Parser($userAgent);
        $browser = $parser->browser->name . ' ' . ($parser->browser->version ? $parser->browser->version->value : 'Unknown');
        $os = $parser->os->name . ' ' . ($parser->os->version ? $parser->os->version->value : 'Unknown');
        $device = $parser->device->type;

        // Gunakan metode deteksi IP yang lebih lengkap
        $ipAddress = self::getClientIp();

        // Resolusi host name dari IP
        $hostName = gethostbyaddr($ipAddress);

        // Ambil lokasi dengan IPInfo atau sejenisnya
        $accessKey = $_ENV['API_IPINFO_KEY'];
        $location = self::getLocationFromIP($ipAddress, $accessKey);

        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? $userAgent;

        return [
            'browser' => $browser,
            'os' => $os,
            'device' => $device,
            'ip_address' => $ipAddress,
            'host_name' => $hostName,
            'location' => $location,
            'user_agent' => $user_agent
        ];
    }

    // Fungsi tambahan untuk mengambil IP asli
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


    public static function getLocationFromIP($ipAddress, $accessKey)
    {
        $url = "http://ipinfo.io/{$ipAddress}/json?token={$accessKey}";
        $response = file_get_contents($url);

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
