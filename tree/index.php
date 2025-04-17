<?php

setlocale(LC_ALL, 'fr_FR.UTF-8');
$data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/private/data/people.json"), true);

function getplace($place) {
    $info = false;

    if (isset($place["city"])) {
        $info = true;
        echo("<a href='/search/city/?q=" . $place["city"] . "'>" . $place["city"] . "</a><br>");
    }

    if (isset($place["dept"])) {
        $info = true;
        echo("<a href='/search/dept/?q=" . $place["dept"] . "'>" . $place["dept"] . "</a><br>");
    }

    if (isset($place["country"])) {
        $info = true;
        echo($place["country"] . "<br>");
    }

    if (!$info) {
        echo("Non renseigné");
    }
}

if (isset($_GET['_']) && trim($_GET['_']) !== "" && isset($data[$_GET['_']])) {
    $id = $_GET['_'];
    $person = $data[$_GET['_']];
} else {
    header("Location: /");
    die();
}

$_TITLE = "Arbre généalogique | " . $person["famname"] . " " . $person["surname"] . " (#" . $id . ")"; require_once $_SERVER['DOCUMENT_ROOT'] . "/private/header.php"; ?>
<div class="container">
    <h1>
        <?= $person["famname"] . " " . $person["surname"] . " <span class='text-muted'>#" . $id . "</span>" ?>
        <a style="float:right;position: relative;top: 7px;" href="/person/?_=<?= $id ?>" class="btn btn-outline-primary">Voir les détails</a>
    </h1>
    <br>
    <br>

    <iframe src="/tree/mktree.php?_=<?= $id ?>" style="border:none;width:100%;height:50vh;border-radius:5px;"></iframe>
</div>
<br>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/private/footer.php"; ?>