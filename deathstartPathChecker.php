<?php
/**
 * Created by PhpStorm.
 * User: owner
 * Date: 11/02/2020
 * Time: 18:07
 */

require 'DeathstarApiService.php';


$deathStarApiService = new DeathstarApiService();

$statusCode = '';
$path = 'f';

while ($statusCode != 200) {
    $result = $deathStarApiService->makeRequest($path);
    $statusCode = $result['status_code'];
    $map = $result['result']['map'];
    $message = $result['result']['message'];


    if ($statusCode == 417){
        // remove last path command from path string
        $path = substr($path, 0, -1);

        //get last line of map
        $mapExploded = explode("\n",$map);
        $lastLineOfMap = end($mapExploded);

        //get crash co ordinates
        $crashPosition = substr($message, strlen($message) -2,-1);

        // call get direction function to get left or right direction to travel next
        $direction = getDirection($crashPosition,$lastLineOfMap);
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

function getDirection($crashPosition,$lastLineOfMap){
    $inc = 0;
    $direction = '';

    // split map last line into characters
    $explodedLastline = str_split($lastLineOfMap);
    while(true) {
        $inc++;

        if($explodedLastline[$crashPosition -$inc] != '#') {
            $direction = 'l';
            break;
        }

        if($explodedLastline[$crashPosition +$inc] != '#') {
            $direction = 'r';
            break;
        }
    }

    return $direction;
}