<?php

namespace App\Helpers;

class DeviceInfoHelper
{
    public static function getDeviceInfo($userAgent)
    {
        $parser = new \WhichBrowser\Parser($userAgent);
        $browser = $parser->browser->name . ' ' . ($parser->browser->version ? $parser->browser->version->value : 'Unknown');
        $os = $parser->os->name . ' ' . ($parser->os->version ? $parser->os->version->value : 'Unknown');
        $device = $parser->device->type;
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $hostName = gethostbyaddr($ipAddress);
        
        $accessKey = $_ENV['API_IPINFO_KEY'];
        $location = self::getLocationFromIP($ipAddress, $accessKey);

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

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
