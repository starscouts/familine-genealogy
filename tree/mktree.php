<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/../session.php";

$data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/private/data/people.json"), true);

if (isset($_GET['_']) && trim($_GET['_']) !== "" && isset($data[$_GET['_']])) {
    $id = $_GET['_'];
    $person = $data[$_GET['_']];
} else {
    // TODO: handle error
    die();
}

// Father
$found = false;
foreach ($data as $potid => $potential) {
    if (isset($potential["family"]) && count($potential["family"]["children"]) > 0 && in_array($id, $potential["family"]["children"]) && $potential["sex"] !== "F") {
        $found = true;
        $dad = $potential["famname"] . " " . $potential["surname"];
        $dadId = $potid;
    }
}

if (!$found) {
    $dad = "???";
}

// Mother
$found = false;
foreach ($data as $potid => $potential) {
    if (isset($potential["family"]) && count($potential["family"]["children"]) > 0 && in_array($id, $potential["family"]["children"]) && $potential["sex"] === "F") {
        $found = true;
        $mom = $potential["famname"] . " " . $potential["surname"];
        $momId = $potid;
    }
}

if (!$found) {
    $mom = "???";
}

// Mother's data
if (isset($momId)) {
    // Father
    $found = false;
    foreach ($data as $potid => $potential) {
        if (isset($potential["family"]) && count($potential["family"]["children"]) > 0 && in_array($momId, $potential["family"]["children"]) && $potential["sex"] !== "F") {
            $found = true;
            $momDad = $potential["famname"] . " " . $potential["surname"];
            $momDadId = $potid;
        }
    }

    if (!$found) {
        $momDad = "???";
    }

    // Mother
    $found = false;
    foreach ($data as $potid => $potential) {
        if (isset($potential["family"]) && count($potential["family"]["children"]) > 0 && in_array($momId, $potential["family"]["children"]) && $potential["sex"] === "F") {
            $found = true;
            $momMom = $potential["famname"] . " " . $potential["surname"];
            $momMomId = $potid;
        }
    }

    if (!$found) {
        $momMom = "???";
    }
} else {
    $momMom = "???";
    $momDad = "???";
}

// Father's data
if (isset($dadId)) {
    // Father
    $found = false;
    foreach ($data as $potid => $potential) {
        if (isset($potential["family"]) && count($potential["family"]["children"]) > 0 && in_array($dadId, $potential["family"]["children"]) && $potential["sex"] !== "F") {
            $found = true;
            $dadDad = $potential["famname"] . " " . $potential["surname"];
            $dadDadId = $potid;
        }
    }

    if (!$found) {
        $dadDad = "???";
    }

    // Mother
    $found = false;
    foreach ($data as $potid => $potential) {
        if (isset($potential["family"]) && count($potential["family"]["children"]) > 0 && in_array($dadId, $potential["family"]["children"]) && $potential["sex"] === "F") {
            $found = true;
            $dadMom = $potential["famname"] . " " . $potential["surname"];
            $dadMomId = $potid;
        }
    }

    if (!$found) {
        $dadMom = "???";
    }
} else {
    $dadMom = "???";
    $dadDad = "???";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tree maker 🌳</title>
    <link rel="stylesheet" href="../lib/tree_maker-min.css">
    <script type="text/javascript" src="../lib/tree_maker-min.js"></script>
</head>
<body>
<div id="my_tree"></div>
<script type="text/javascript">
    let tree = {
        0: {
            1: {
                3: '',
                4: ''
            },
            2: {
                5: '',
                6: ''
            }
        }
    };

    let treeParams = {
        0: {trad: "<b><?= $person["famname"] ?> <?= $person["surname"] ?></b>", id: "<?= $id ?>"},
        1: {trad: "<?= $mom ?>", id: "<?= $momId ?>"},
        2: {trad: "<?= $dad ?>", id: "<?= $dadId ?>"},
        3: {trad: "<?= $momMom ?>", id: "<?= $momMomId ?>"},
        4: {trad: "<?= $momDad ?>", id: "<?= $momDadId ?>"},
        5: {trad: "<?= $dadMom ?>", id: "<?= $dadMomId ?>"},
        6: {trad: "<?= $dadDad ?>", id: "<?= $dadDadId ?>"},
    };

    treeMaker(tree, {
        id: 'my_tree', card_click: function (element) {
            if (treeParams[element.id.substr(5)].trad !== "???") window.parent.location.href = "/tree/?_=" + treeParams[element.id.substr(5)].id;
        },
        treeParams: treeParams,
        'link_width': '4px',
        'link_color': '#fff',
    });
</script>
<style>
    body, html {
        font-family: sans-serif;
    }
    .tree__container__step__card__p {
        background: white;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }
</style>
</body>
</html>
