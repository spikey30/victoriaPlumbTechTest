<?php

require_once 'DeathstarApiService.php';


$deathStarApiService = new App\DeathstarApiService();

$statusCode = '';
$path = 'f';

while ($statusCode != 200) {
    $result = $deathStarApiService->makeRequest($path);
    $statusCode = $result['status_code'];
    $map = $result['result']['map'];
    $message = $result['result']['message'];


    if ($statusCode == 417) {
        // remove last path command from path string
        $path = substr($path, 0, -1);

        //get last line of map
        $mapExploded = explode("\n", $map);
        $lastLineOfMap = end($mapExploded);

        //get crash co ordinates
        $crashPosition = substr($message, strlen($message) -2, -1);

        // call get direction function to get left or right direction to travel next
        $direction = $deathStarApiService->getDirection($crashPosition, $lastLineOfMap);
        $path .= $direction;
    }
    // if no crash move forward
    $path .= 'f';
}

$response = [
    'correct_path' => $path,
    'correct_map' => $map,
];

echo json_encode($response);
