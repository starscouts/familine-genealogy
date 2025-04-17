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
    if (isset($person["death"]["date"]) && isset($person["death"]["date"]["year"])) {
        if (isset($counts[(string)$person["death"]["date"]["year"]])) {
            $counts[(string)$person["death"]["date"]["year"]]++;
        } else {
            $counts[(string)$person["death"]["date"]["year"]] = 1;
        }
        if (!in_array((string)$person["death"]["date"]["year"], $names)) {
            $names[] = (string)$person["death"]["date"]["year"];
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