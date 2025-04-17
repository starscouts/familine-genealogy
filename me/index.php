<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/../session.php";

/** @var string $_FULLNAME
 *  @var string $_USER
 *  @var array $_PROFILE
 *  @var array $_CONFIG
 */

$first = strtolower(explode(" ", $_FULLNAME)[1]);
$last = strtolower(explode(" ", $_FULLNAME)[0]);

$data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/private/data/people.json"), true);

$found = null;
foreach ($data as $id => $person) {
    if (strtolower($person["surname"]) === $first && strtolower($person["famname"]) === $last) {
        $found = $id;
    }
}

$id = $found;

if (isset($found)):
    header("Location: /person/?_=" . $id);
    die();
else: ?>
    <?php $_TITLE = "Erreur"; require_once $_SERVER['DOCUMENT_ROOT'] . "/private/header.php"; ?>
    <div class="container">
        <h1>Erreur</h1>
        <div class="alert alert-danger">
            Aucune entrée vous correspondant n'a été trouvée dans la généalogie. Si vous pensez qu'il s'agit d'une erreur, utilisez la fonction de recherche pour vous trouver.
        </div>
    </div>
    <br>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/private/footer.php"; ?>
<?php endif; ?>
