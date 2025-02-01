<?php

namespace App\Utils;

use GuzzleHttp\Client;

class Utils {
    public static function call(string $url, string $apiKey, string $method, string $source)
    {
        $client = new Client([
            'base_uri' => $url,
            'headers' => [
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => $apiKey
            ]
        ]);
        
        $response = $client->request($method, $source);
        
        if ($response->getStatusCode() != 200) {
        }

        $body = $response->getBody();

        $data = json_decode($body, true);

        if (!empty($data['errors'])) {
            http_response_code(500);
            echo json_encode([
                "erro" => is_array($data['errors']) ? implode("; ", $data['errors']) : $data['errors']
            ]);
            exit;
        }
        
        if (!empty($data['api']['error'])) {
            http_response_code(503);
            echo json_encode([
                "erro" => $data['api']['error']
            ]);
            exit;
        }

        return $data;
    }
}