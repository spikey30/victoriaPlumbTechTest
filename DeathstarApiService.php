<?php

namespace App;

class DeathstarApiService
{
    private $curlClient;

    private $baseUrl = 'http://deathstar.victoriaplum.com/alliance.php';

    public function __construct()
    {
        $this->curlClient = curl_init();
        curl_setopt($this->curlClient, CURLOPT_RETURNTRANSFER, 1);
    }


    public function makeRequest($path)
    {
            $url = $this->buildUrl($path);

            curl_setopt($this->curlClient, CURLOPT_URL, $url);

            $result = curl_exec($this->curlClient);
            $info = curl_getinfo($this->curlClient);

            return [
                'result' => json_decode($result, true),
                'status_code' => $info['http_code'],
            ];
    }

    private function buildUrl($path)
    {
        $url = $this->baseUrl . '?path=' . $path . '&name=test';
        return $url;
    }

    public function getDirection($crashPosition, $lastLineOfMap)
    {
        $inc = 0;
        $direction = '';

        // split map last line into characters
        $explodedLastline = str_split($lastLineOfMap);
        while (true) {
            $inc++;

            if ($explodedLastline[$crashPosition -$inc] != '#') {
                $direction = 'l';
                break;
            }

            if ($explodedLastline[$crashPosition +$inc] != '#') {
                $direction = 'r';
                break;
            }
        }

        return $direction;
    }
}
