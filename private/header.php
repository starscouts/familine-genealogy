<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/../session.php";

/** @var string $_FULLNAME
 *  @var string $_USER
 *  @var array $_PROFILE
 *  @var array $_CONFIG
 */

if (isset($_PROFILE["projectRoles"]) && is_array($_PROFILE["projectRoles"]) && isset($_PROFILE["projectRoles"][0]) && is_array($_PROFILE["projectRoles"][0]) && isset($_PROFILE["projectRoles"][0]["role"]) && is_array($_PROFILE["projectRoles"][0]["role"]) && isset($_PROFILE["projectRoles"][0]["role"]["key"]) && is_string($_PROFILE["projectRoles"][0]["role"]["key"]) && $_PROFILE["projectRoles"][0]["role"]["key"] === "system-admin") {
    $_ADMIN = true;
} else {
    $_ADMIN = false;
}

?>
<?php

$_USER = $_PROFILE['login'];

global $_USER;

if (!isset($_TITLE)) {
    $_TITLE = "Accueil";
}

$data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/private/data/people.json"), true);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/dllib/jquery.flexdatalist.min.css" rel="stylesheet" type="text/css">
    <script src="/dllib/jquery.js"></script>
    <script src="/dllib/org.js"></script>
    <title><?= $_TITLE ?> | Familine Généalogie</title>
    <style>
        :root {
            --primary-color: #217ca3;
            --shadow-color: rgba(0, 157, 255, 0.25);
            --border-color: #80bbff;
            --primary: var(--primary-color);
        }

        .btn-outline-primary {
            border-color: var(--primary-color) !important;
            color: var(--primary-color) !important;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color) !important;
            color: white !important;
        }

        .btn-primary, .alert-primary, .bg-primary, .table-primary, .badge-primary, .dropdown-item:active, .dropdown-item.active {
            background-color: var(--primary-color) !important;
        }

        .border-primary, .btn-primary {
            border-color: var(--primary-color) !important;
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        a:not(.navbar-brand):not(.dropdown-item):not(.btn):not(.nav-link), a:not(.navbar-brand):not(.dropdown-item):not(.btn):not(.nav-link):hover, a:not(.navbar-brand):not(.dropdown-item):not(.btn):not(.nav-link):active, a:not(.navbar-brand):not(.dropdown-item):not(.btn):not(.nav-link):focus {
            color: var(--primary-color) !important;
        }

        a:not(.navbar-brand):not(.dropdown-item):not(.btn):not(.nav-link):hover {
            opacity: .75;
        }

        a:not(.navbar-brand):not(.dropdown-item):not(.btn):not(.nav-link):active, a:not(.navbar-brand):not(.dropdown-item):not(.btn):not(.nav-link):focus {
            opacity: .5;
        }

        .form-control:focus, .btn:focus {
            border-color: var(--border-color) !important;
            box-shadow: 0 0 0 .2rem var(--shadow-color) !important;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/styles/common.css">
    <link rel="icon" href="https://<?= $_CONFIG["Global"]["cdn"] ?>/icns/familine-recall.svg">
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-light navbar-light">
        <a class="navbar-brand" href="/">Familine Généalogie</a>
        <ul class="navbar-nav" style="width: 100%;">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    Rechercher
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/search/name">Par prénom</a>
                    <a class="dropdown-item" href="/search/lastname">Par nom</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/search/birth">Par date de naissance</a>
                    <a class="dropdown-item" href="/search/death">Par date de décès</a>
                    <a class="dropdown-item" href="/search/marriage">Par date de mariage</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/search/city">Par ville</a>
                    <a class="dropdown-item" href="/search/dept">Par département</a>
                    <a class="dropdown-item" href="/search/state">Par région</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/me">Ma famille</a>
            </li>
        </ul>

        <span class="navbar-text" style="width:100%;text-align:right;">
            @<?= $_USER ?>
        </span>
    </nav>
    <br>
