<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/../session.php";

/** @var string $_FULLNAME
 *  @var string $_USER
 *  @var array $_PROFILE
 *  @var array $_CONFIG
 */

$data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/private/data/people.json"), true);

if (isset($_GET['q']) && trim($_GET['q']) !== "") {
    $q = $_GET['q'];
} else {
    die();
}

$results = [];

foreach ($data as $id => $person) {
    if (isset($person["birth"]["place"]) && isset($person["birth"]["place"]["state"])) {
        if ($person["birth"]["place"]["state"] === $q) {
            $results[] = $id;
        }
    }
}
if (count($results) === 0): ?>
<ul class="list-group">
    <li class="list-group-item">Aucun résultat correspondant</li>
</ul>
<?php else: ?>
<div class="list-group">
    <?php foreach ($results as $result): $p = $data[$result]; ?>
    <a href="/person/?_=<?= $result ?>" class="list-group-item list-group-item-action"><?= $p["famname"] ?> <?= $p["surname"] ?> <span class="text-muted">#<?= $result ?></span></a>
    <?php endforeach; ?>
</div>
<?php endif; ?>