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

$_TITLE = $person["famname"] . " " . $person["surname"] . " (#" . $id . ")"; require_once $_SERVER['DOCUMENT_ROOT'] . "/private/header.php"; ?>
<div class="container">
    <h1>
        <?= $person["famname"] . " " . $person["surname"] . " <span class='text-muted'>#" . $id . "</span>" ?>
        <a style="float:right;position: relative;top: 7px;" href="/tree/?_=<?= $id ?>" class="btn btn-outline-primary">Voir l'arbre</a>
    </h1>
    <br>

    <table class="table table-bordered table-dark">
        <tbody>
        <tr>
            <td colspan="2">
                <b>Noms et prénoms</b>
            </td>
        </tr>
        <tr>
            <td class="text-muted">Nom de famille</td>
            <td><a href="/search/lastname/?q=<?= ucfirst(strtolower($person["famname"])) ?>"><?= strtoupper($person["famname"]) ?></a></td>
        </tr>
        <tr>
            <td class="text-muted">Premier prénom</td>
            <td><a href="/search/name/?q=<?= ucfirst(strtolower($person["surname"])) ?>"><?= $person["surname"] ?></a></td>
        </tr>
        <tr>
            <td class="text-muted">Prénoms alternatifs</td>
            <td><?php

                if (count($person["altnames"]) < 1) {
                    echo("Non applicable");
                } else {
                    foreach ($person["altnames"] as $name) {
                        echo('<a href="/search/name/?q=' . ucfirst(strtolower($name)) . '">' . $name . '</a><br>');
                    }
                }

                ?></td>
        </tr>
        <tr>
            <td class="text-muted">Nom complet</td>
            <td><?= strtoupper($person["famname"]) ?> <?= strtoupper($person["surname"]) ?> <?= strtoupper(implode(" ", $person["altnames"])) ?></td>
        </tr>
        </tbody>
    </table>

    <table class="table table-bordered table-dark">
        <tbody>
            <tr>
                <td colspan="2">
                    <b>Informations générales</b>
                </td>
            </tr>
            <tr>
                <td class="text-muted">Identifiant généalogique</td>
                <td>#<?= $id ?></td>
            </tr>
            <tr>
                <td class="text-muted">Sexe</td>
                <td><?php

                    if ($person["sex"] === "F") {
                        echo("Féminin");
                    } else {
                        echo("Masculin");
                    }

                    ?></td>
            </tr>
            <?php if (isset($person["birth"]["date"]["day"])): ?>
            <tr>
                <td class="text-muted">Date de naissance</td>
                <td><?= strftime("%A %e %B", strtotime($person["birth"]["date"]["day"] . "-" . $person["birth"]["date"]["month"] . "-" . $person["birth"]["date"]["year"])) ?> <a href="/search/birth/?q=<?= $person["birth"]["date"]["year"] ?>"><?= strftime("%Y", strtotime("1-1-" . $person["birth"]["date"]["year"])) ?></a></td>
            </tr>
            <?php elseif (isset($person["birth"]["date"]["month"])): ?>
            <tr>
                <td class="text-muted">Mois de naissance</td>
                <td><?= strftime("%B", strtotime("1-" . $person["death"]["date"]["month"] . "-" . $person["death"]["date"]["year"])) ?> <a href="/search/birth/?q=<?= $person["birth"]["date"]["year"] ?>"><?= strftime("%Y", strtotime("1-1-" . $person["birth"]["date"]["year"])) ?></a></td>
            </tr>
            <?php elseif (isset($person["birth"]["date"]["year"])): ?>
            <tr>
                <td class="text-muted">Année de naissance</td>
                <td><a href="/search/birth/?q=<?= $person["birth"]["date"]["year"] ?>"><?= strftime("%Y", strtotime("1-1-" . $person["birth"]["date"]["year"])) ?></a></td>
            </tr>
            <?php else: ?>
                <tr>
                    <td class="text-muted">Date de naissance</td>
                    <td>Non renseignée</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <table class="table table-bordered table-dark">
        <tbody>
        <tr>
            <td colspan="2">
                <b>Lieux et endroits</b>
            </td>
        </tr>
        <tr>
            <td class="text-muted">Lieu de naissance</td>
            <td><?php

                getplace($person["birth"]["place"]);

                ?></td>
        </tr>
        <tr>
            <td class="text-muted">Lieu de décès</td>
            <td><?php

                getplace($person["death"]["place"]);

                ?></td>
        </tr>
        <?php if (isset($person["family"]) && isset($person["family"]["marriage"])): ?>
        <tr>
            <td class="text-muted">Lieu de mariage</td>
            <td><?php

                getplace($person["family"]["marriage"]["place"]);

                ?></td>
        </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <table class="table table-bordered table-dark">
        <tbody>
        <tr>
            <td colspan="2">
                <b>Dates</b>
            </td>
        </tr>
        <?php if (isset($person["birth"]["date"]["day"])): ?>
            <tr>
                <td class="text-muted">Date de naissance</td>
                <td><?= strftime("%A %e %B", strtotime($person["birth"]["date"]["day"] . "-" . $person["birth"]["date"]["month"] . "-" . $person["birth"]["date"]["year"])) ?> <a href="/search/birth/?q=<?= $person["birth"]["date"]["year"] ?>"><?= strftime("%Y", strtotime("1-1-" . $person["birth"]["date"]["year"])) ?></a></td>
            </tr>
        <?php elseif (isset($person["birth"]["date"]["month"])): ?>
            <tr>
                <td class="text-muted">Mois de naissance</td>
                <td><?= strftime("%B", strtotime("1-" . $person["birth"]["date"]["month"] . "-" . $person["birth"]["date"]["year"])) ?> <a href="/search/birth/?q=<?= $person["birth"]["date"]["year"] ?>"><?= strftime("%Y", strtotime("1-1-" . $person["birth"]["date"]["year"])) ?></a></td>
            </tr>
        <?php elseif (isset($person["birth"]["date"]["year"])): ?>
            <tr>
                <td class="text-muted">Année de naissance</td>
                <td><a href="/search/birth/?q=<?= $person["birth"]["date"]["year"] ?>"><?= strftime("%Y", strtotime("1-1-" . $person["birth"]["date"]["year"])) ?></a></td>
            </tr>
        <?php else: ?>
            <tr>
                <td class="text-muted">Date de naissance</td>
                <td>Non renseigné</td>
            </tr>
        <?php endif; ?>
        <?php if (isset($person["death"]["date"]["day"])): ?>
            <tr>
                <td class="text-muted">Date de décès</td>
                <td><?= strftime("%A %e %B", strtotime($person["death"]["date"]["day"] . "-" . $person["death"]["date"]["month"] . "-" . $person["death"]["date"]["year"])) ?> <a href="/search/death/?q=<?= $person["death"]["date"]["year"] ?>"><?= strftime("%Y", strtotime("1-1-" . $person["death"]["date"]["year"])) ?></a></td>
            </tr>
        <?php elseif (isset($person["death"]["date"]["month"])): ?>
            <tr>
                <td class="text-muted">Mois de décès</td>
                <td><?= strftime("%B", strtotime("1-" . $person["death"]["date"]["month"] . "-" . $person["death"]["date"]["year"])) ?> <a href="/search/death/?q=<?= $person["death"]["date"]["year"] ?>"><?= strftime("%Y", strtotime("1-1-" . $person["death"]["date"]["year"])) ?></a></td>
            </tr>
        <?php elseif (isset($person["death"]["date"]["year"])): ?>
            <tr>
                <td class="text-muted">Année de décès</td>
                <td><a href="/search/death/?q=<?= $person["death"]["date"]["year"] ?>"><?= strftime("%Y", strtotime("1-1-" . $person["death"]["date"]["year"])) ?></a></td>
            </tr>
        <?php else: ?>
            <tr>
                <td class="text-muted">Date de décès</td>
                <td>Non applicable</td>
            </tr>
        <?php endif; ?>
        <?php if (isset($person["family"]) && isset($person["family"]["marriage"])): ?>
            <?php if (isset($person["family"]["marriage"]["date"]["day"])): ?>
                <tr>
                    <td class="text-muted">Date de mariage</td>
                    <td><?= strftime("%A %e %B", strtotime($person["family"]["marriage"]["date"]["day"] . "-" . $person["family"]["marriage"]["date"]["month"] . "-" . $person["family"]["marriage"]["date"]["year"])) ?> <a href="/search/marriage/?q=<?= $person["family"]["marriage"]["date"]["year"] ?>"><?= strftime("%Y", strtotime("1-1-" . $person["family"]["marriage"]["date"]["year"])) ?></a></td>
                </tr>
            <?php elseif (isset($person["family"]["marriage"]["date"]["month"])): ?>
                <tr>
                    <td class="text-muted">Mois de mariage</td>
                    <td><?= strftime("%B", strtotime("1-" . $person["family"]["marriage"]["date"]["month"] . "-" . $person["family"]["marriage"]["date"]["year"])) ?> <a href="/search/marriage/?q=<?= $person["family"]["marriage"]["date"]["year"] ?>"><?= strftime("%Y", strtotime("1-1-" . $person["family"]["marriage"]["date"]["year"])) ?></a></td>
                </tr>
            <?php elseif (isset($person["family"]["marriage"]["date"]["year"])): ?>
                <tr>
                    <td class="text-muted">Année de mariage</td>
                    <td><a href="/search/marriage/?q=<?= $person["family"]["marriage"]["date"]["year"] ?>"><?= strftime("%Y", strtotime("1-1-" . $person["family"]["marriage"]["date"]["year"])) ?></a></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td class="text-muted">Date de mariage</td>
                    <td>Non applicable</td>
                </tr>
            <?php endif; ?>
        <?php else: ?>
            <tr>
                <td class="text-muted">Date de mariage</td>
                <td>Non applicable</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <table class="table table-bordered table-dark">
        <tbody>
        <tr>
            <td colspan="2">
                <b>Liens de parenté</b>
            </td>
        </tr>
        <tr>
            <td class="text-muted"><?= $person["sex"] === "F" ? "Époux" : "Épouse" ?></td>
            <td><?php

                $soid = $person["sex"] === "F" ? "husband" : "wife";

                if (isset($person["family"]) && isset($person["family"][$soid])) {
                    echo("<a href='/person/?_=" . $person["family"][$soid] . "'>" . $data[$person["family"][$soid]]["famname"] . " " . $data[$person["family"][$soid]]["surname"] . " (#" . $person["family"][$soid] . ")</a>");
                } else {
                    echo("Non applicable");
                }

                if (isset($person["family"]["marriage"]) && isset($person["family"]["marriage"]["date"]["year"]) && isset($person["birth"]["date"]["year"])) {
                    echo(" (marié" . ($person["sex"] === "F" ? "e" : "") . " à " . ($person["family"]["marriage"]["date"]["year"] - $person["birth"]["date"]["year"]) . " ans)");
                } else if (!isset($person["family"]["marriage"])) {
                    echo(" (pas de mariage)");
                }

                ?></td>
        </tr>
        <tr>
            <td class="text-muted">Enfant<?php

                if (isset($person["family"]) && isset($person["family"]["children"])) {
                    if (count($person["family"]["children"]) > 1) {
                        echo("s");
                    }
                }

                ?></td>
            <td><?php

                $found = false;
                if (isset($person["family"]) && isset($person["family"]["children"])) {
                    foreach ($person["family"]["children"] as $child) {
                        $found = true;
                        echo("<a href='/person/?_=" . $child . "'>" . $data[$child]["famname"] . " " . $data[$child]["surname"] . " (#" . $child . ")</a>");
                        if (isset($person["birth"]["date"]["year"]) && isset($data[$child]["birth"]["date"]["year"])) {
                            echo(" (né" . ($data[$child]["sex"] === "F" ? "e" : "") . " à " . ($data[$child]["birth"]["date"]["year"] - $person["birth"]["date"]["year"]) . " ans)");
                        }
                        echo("<br>");
                    }
                }

                if (!$found) {
                    echo("Non applicable");
                }

                ?></td>
        </tr>
        <tr>
            <td class="text-muted">Père</td>
            <td><?php

                $found = false;
                foreach ($data as $potid => $potential) {
                    if (isset($potential["family"]) && count($potential["family"]["children"]) > 0 && in_array($id, $potential["family"]["children"]) && $potential["sex"] !== "F") {
                        $found = true;
                        echo("<a href='/person/?_=" . $potid . "'>" . $potential["famname"] . " " . $potential["surname"] . " (#" . $potid . ")</a><br>");
                    }
                }

                if (!$found) {
                    echo("Non renseigné");
                }

                ?></td>
        </tr>
        <tr>
            <td class="text-muted">Mère</td>
            <td><?php

                $found = false;
                foreach ($data as $potid => $potential) {
                    if (isset($potential["family"]) && count($potential["family"]["children"]) > 0 && in_array($id, $potential["family"]["children"]) && $potential["sex"] === "F") {
                        $found = true;
                        echo("<a href='/person/?_=" . $potid . "'>" . $potential["famname"] . " " . $potential["surname"] . " (#" . $potid . ")</a><br>");
                    }
                }

                if (!$found) {
                    echo("Non renseigné");
                }

                ?></td>
        </tr>
        </tbody>
    </table>

    <style>
        .table {
            border-radius: 5px;
        }

        .table td {
            width: 50%;
        }

        .table td:nth-child(1) {
            text-align: right;
        }

        .table td[colspan="2"] {
            text-align: center;
        }
    </style>

</div>
<br>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/private/footer.php"; ?>