<?php $_TITLE = "Recherche par ville de naissance"; require_once $_SERVER['DOCUMENT_ROOT'] . "/private/header.php"; ?>
<div class="container">
    <h2>Rechercher par ville de naissance</h2>
    <p id="preview">Patientez...</p>
    <script src="/dllib/jquery.flexdatalist.min.js"></script>
    <div class="input-group mt-3 mb-3">
        <div class="input-group-prepend">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                Par ville
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="/search/name">Par prénom</a>
                <a class="dropdown-item" href="/search/lastname">Par nom</a>
                <a class="dropdown-item" href="/search/birth">Par date de naissance</a>
                <a class="dropdown-item" href="/search/death">Par date de décès</a>
                <a class="dropdown-item" href="/search/marriage">Par date de mariage</a>
                <a class="dropdown-item active" href="/search/city">Par ville</a>
                <a class="dropdown-item" href="/search/dept">Par département</a>
                <a class="dropdown-item" href="/search/state">Par région</a>
            </div>
        </div>
        <input onchange="reload();" class="form-control" type="text"
               placeholder="Commencer à taper une ville..."
               id="search">
    </div>
    <script>
        setInterval(() => {
            if (document.getElementById("search").value.trim() !== "") {
                document.getElementById("preview").innerText = "Affiche toutes les personnes nées à " + document.getElementById("search").value;
            } else {
                document.getElementById("preview").innerText = "Sélectionnez une ville";
            }
        }, 100)

        function reload() {
            window.fetch("./results/?q=" + encodeURI(document.getElementById("search").value.trim())).then((a) => {
                a.text().then((b) => {
                    document.getElementById("results").innerHTML = b;
                })
            })
        }

        window.addEventListener("load", () => {
            i = Math.random().toString().substr(2);
            document.getElementById('search').classList.add(i);
            $('#search.' + i).flexdatalist({
                cache: false,
                minLength: 0,
                selectionRequired: true,
                visibleProperties: ["name","occurrences"],
                searchIn: 'name',
                data: "data.json"
            });
        })
    </script>
    <style>
        .flexdatalist-results li {
            cursor: pointer;
        }
        .flexdatalist-results li .item-occurrences {
            color: rgba(0, 0, 0, .25);
        }
        .flexdatalist-results li:hover {
            opacity: .75;
        }
        .flexdatalist-results li:active {
            opacity: .5;
        }
    </style>
    <div id="results"></div>
</div>
<br>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/private/footer.php"; ?>