<?php

/** @var string $contentHTML */
/** @var \App\Core\IAuthenticator $auth */
/** @var \App\Core\LinkGenerator $link */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title><?= \App\Config\Configuration::APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/styl.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="public/js/script.js"></script>
</head>
<body>
<ul class="nav justify-content-end">
    <li class="website-name">Booksite</li>
    <li class="nav-item">
        <a class="nav-link" href="<?= $link->url("home.index") ?>">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= $link->url("booklist.index") ?>">Booklist</a>
    </li>

    <?php if ($auth->isLogged()) { ?>
        <div class="dropdown show">
            <a class="btn dropdown-button dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= $auth->getLoggedUserName() ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="<?= $link->url("profile.index") ?>"><i class="bi bi-person"></i>Profile</a>
                <a class="dropdown-item" href="#"><i class="bi bi-envelope"></i> Notifications</a>
                <a class="dropdown-item" href="<?= $link->url("profile.settings") ?>"><i class="bi bi-gear"></i> Settings</a>
                <a class="dropdown-item" href="<?= $link->url("auth.logout") ?>"><i class="bi bi-door-closed"></i>Logout</a>
            </div>
        </div>

    <?php } else { ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= $link->url("auth.login") ?>">Login</a>
        </li>
    <?php } ?>

</ul>

<div class="container-fluid mt-3">
    <div class="web-content">
        <?= $contentHTML ?>
    </div>
</div>
</body>
</html>
