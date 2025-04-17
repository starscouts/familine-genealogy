<?php $_TITLE = "Accueil"; require_once $_SERVER['DOCUMENT_ROOT'] . "/private/header.php"; ?>
<div class="container" style="text-align: center;">
    <h1>Familine Généalogie</h1>
    <p><i>La généalogie familiale simplifiée et accessible à tous</i></p>

    <h2>Pour vous</h2>
    <div class="list-group">
        <a href="/me" class="list-group-item list-group-item-action">Consulter la généalogie à partir de vous</a>
    </div>
    <br>

    <h2>Statistiques</h2>
    <ul class="list-group">
        <li class="list-group-item"><?= count($data); ?> personnes</li>
        <li class="list-group-item">
            <?php

            $male = 0;
            $female = 0;
            foreach ($data as $id => $person) {
                if (isset($person["sex"])) {
                    if ($person["sex"] === "F") {
                        $female++;
                    } else {
                        $male++;
                    }
                }
            }
            $total = $male + $female;
            echo(round(($female/$total) * 100, 2) . "% de femmes pour " . round(($male/$total) * 100, 2) . "% d'hommes");

            ?>
        </li>
        <li class="list-group-item"><?php

            $uniqueNames = [];
            foreach ($data as $person) {
                if (!in_array($person["famname"], $uniqueNames)) {
                    $uniqueNames[] = $person["famname"];
                }
            }

            echo(count($uniqueNames) . " noms de familles uniques")

            ?></li>
        <li class="list-group-item"><?= round(filesize($_SERVER['DOCUMENT_ROOT'] . "/private/data/people.json") / 1024) ?> Ko de données</li>
        <li class="list-group-item">
            <?php

            $numChildren = [];
            foreach ($data as $person) {
                if (isset($person["family"])) {
                    $numChildren[] = count($person["family"]["children"]);
                }
            }
            echo(round(array_sum($numChildren)/count($numChildren), 2) . " enfants en moyenne par famille");
            echo(" <span class='text-muted'>(statistiques calculées sur " . count($numChildren) . " familles)</span>");

            ?>
        </li>
        <li class="list-group-item">
            <?php

            $deathAge = [];
            foreach ($data as $id => $person) {
                if (isset($person["death"]["date"]["year"]) && isset($person["birth"]["date"]["year"])) {
                    $deathAge[$id] = $person["death"]["date"]["year"] - $person["birth"]["date"]["year"];
                }
            }
            echo("Décès en moyenne à " . round(array_sum($deathAge)/count($deathAge), 2) . " ans");
            echo(" <span class='text-muted'>(statistiques calculées sur " . count($deathAge) . " personnes)</span>");

            ?>
        </li>
        <li class="list-group-item">
            <?php

            $deathAge = [];
            foreach ($data as $id => $person) {
                if (isset($person["death"]["date"]["year"]) && isset($person["birth"]["date"]["year"])) {
                    $deathAge[$id] = $person["death"]["date"]["year"] - $person["birth"]["date"]["year"];
                }
            }
            echo("Personne la plus vieille décédée à " . max($deathAge) . " ans");
            echo(" (<a href='/person/?_=" . array_search(max($deathAge), $deathAge) . "'>" . $data[array_search(max($deathAge), $deathAge)]["famname"] . " " . $data[array_search(max($deathAge), $deathAge)]["surname"] . "</a>, †" . $data[array_search(max($deathAge), $deathAge)]["death"]["date"]["year"] . ")");
            echo(" <span class='text-muted'>(statistiques calculées sur " . count($deathAge) . " personnes)</span>");

            ?>
        </li>
        <li class="list-group-item">
            <?php

            $deathAge = [];
            foreach ($data as $id => $person) {
                if (isset($person["death"]["date"]["year"]) && isset($person["birth"]["date"]["year"])) {
                    $deathAge[$id] = $person["death"]["date"]["year"] - $person["birth"]["date"]["year"];
                }
            }
            echo("Personne la plus jeune décédée à " . min($deathAge) . " ans");
            echo(" (<a href='/person/?_=" . array_search(min($deathAge), $deathAge) . "'>" . $data[array_search(min($deathAge), $deathAge)]["famname"] . " " . $data[array_search(min($deathAge), $deathAge)]["surname"] . "</a>, †" . $data[array_search(min($deathAge), $deathAge)]["death"]["date"]["year"] . ")");
            echo(" <span class='text-muted'>(statistiques calculées sur " . count($deathAge) . " personnes)</span>");

            ?>
        </li>
        <li class="list-group-item">
            <?php

            $numChildren = [];
            foreach ($data as $id => $person) {
                if (isset($person["family"])) {
                    $numChildren[$id] = count($person["family"]["children"]);
                }
            }
            echo("Famille la plus grande avec " . max($numChildren) . " enfants");
            echo(" (<a href='/person/?_=" . array_search(max($numChildren), $numChildren) . "'>" . $data[array_search(max($numChildren), $numChildren)]["famname"] . " " . $data[array_search(max($numChildren), $numChildren)]["surname"] . "</a>)");
            echo(" <span class='text-muted'>(statistiques calculées sur " . count($numChildren) . " familles)</span>");

            ?>
        </li>

        <li class="list-group-item">
            <?php

            $ageWhenMarried = [];
            foreach ($data as $id => $person) {
                if (isset($person["family"])) {
                    if (isset($person["family"]["marriage"]["date"]["year"]) && isset($person["birth"]["date"]["year"])) {
                        $ageWhenMarried[$id] = $person["family"]["marriage"]["date"]["year"] - $person["birth"]["date"]["year"];
                    }
                }
            }
            echo("Mariage en moyenne à " . round(array_sum($ageWhenMarried)/count($ageWhenMarried), 2) . " ans");
            echo(" <span class='text-muted'>(statistiques calculées sur " . count($ageWhenMarried) . " familles)</span>");

            ?>
        </li>
        <li class="list-group-item">
            <?php

            $ageWhenMarried = [];
            foreach ($data as $id => $person) {
                if (isset($person["family"])) {
                    if (isset($person["family"]["marriage"]["date"]["year"]) && isset($person["birth"]["date"]["year"])) {
                        $ageWhenMarried[$id] = $person["family"]["marriage"]["date"]["year"] - $person["birth"]["date"]["year"];
                    }
                }
            }
            echo("Mariage le plus tard à " . max($ageWhenMarried) . " ans");
            echo(" (<a href='/person/?_=" . array_search(max($ageWhenMarried), $ageWhenMarried) . "'>" . $data[array_search(max($ageWhenMarried), $ageWhenMarried)]["famname"] . " " . $data[array_search(max($ageWhenMarried), $ageWhenMarried)]["surname"] . "</a>)");
            echo(" <span class='text-muted'>(statistiques calculées sur " . count($ageWhenMarried) . " familles)</span>");

            ?>
        </li>
        <li class="list-group-item">
            <?php

            $ageWhenMarried = [];
            foreach ($data as $id => $person) {
                if (isset($person["family"])) {
                    if (isset($person["family"]["marriage"]["date"]["year"]) && isset($person["birth"]["date"]["year"])) {
                        $ageWhenMarried[$id] = $person["family"]["marriage"]["date"]["year"] - $person["birth"]["date"]["year"];
                    }
                }
            }
            echo("Mariage le plus tôt à " . min($ageWhenMarried) . " ans");
            echo(" (<a href='/person/?_=" . array_search(min($ageWhenMarried), $ageWhenMarried) . "'>" . $data[array_search(min($ageWhenMarried), $ageWhenMarried)]["famname"] . " " . $data[array_search(min($ageWhenMarried), $ageWhenMarried)]["surname"] . "</a>)");
            echo(" <span class='text-muted'>(statistiques calculées sur " . count($ageWhenMarried) . " familles)</span>");

            ?>
        </li>
    </ul>
    <br>

    <h2>Lancer une recherche</h2>
    <div class="list-group">
        <a href="/search/name" class="list-group-item list-group-item-action">Rechercher par prénom</a>
        <a href="/search/lastname" class="list-group-item list-group-item-action">Rechercher par nom</a>
        <a href="/search/birth" class="list-group-item list-group-item-action">Rechercher par date de naissance</a>
        <a href="/search/death" class="list-group-item list-group-item-action">Rechercher par date de décès</a>
        <a href="/search/marriage" class="list-group-item list-group-item-action">Rechercher par date de mariage</a>
        <a href="/search/city" class="list-group-item list-group-item-action">Rechercher par ville</a>
        <a href="/search/dept" class="list-group-item list-group-item-action">Rechercher par département</a>
        <a href="/search/state" class="list-group-item list-group-item-action">Rechercher par région</a>
    </div>

</div>
<br>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/private/footer.php"; ?>