<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/../session.php";

/** @var string $_FULLNAME
 *  @var string $_USER
 *  @var array $_PROFILE
 *  @var array $_CONFIG
 */

$data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/private/data/people.json"), true);

header("Content-Type: application/json");

$arr = [];
$names = [];
$counts = [];

foreach ($data as $id => $person) {
    if (isset($person["birth"]["place"]) && isset($person["birth"]["place"]["state"])) {
        if (isset($counts[$person["birth"]["place"]["state"]])) {
            $counts[$person["birth"]["place"]["state"]]++;
        } else {
            $counts[$person["birth"]["place"]["state"]] = 1;
        }
        if (!in_array($person["birth"]["place"]["state"], $names)) {
            $names[] = $person["birth"]["place"]["state"];
        }
    }
}

foreach ($names as $name) {
    $arr[] = [
        'name' => $name,
        'occurrences' => $counts[$name] . " personne" . ($counts[$name] > 1 ? "s" : "")
    ];
}

echo(json_encode($arr));