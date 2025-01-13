<?php

/** @var array $data */
/** @var \App\Core\LinkGenerator $link */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Followers</title>
    <link href="public/css/userlistStyle.css" rel="stylesheet">
</head>
<body>

<div class="flex-container">
    <div class="row">
        <div class="col-md-2 col-lg-2 col-xl-4"></div>

        <div class="col-sm-12 col-md-8 col-lg-8 col-xl-4 form-col">

            <div class="container">
                <h2>Followers</h2>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Username</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php for($i = 0; $i < count($data['users']); $i++) : ?>
                            <tr>
                                <td><a class="" href="<?= $link->url("profile.index", ["userId" => $data['profiles'][$i]->getUserId()]) ?>"><?=$data['users'][$i]->getUsername()?></a></td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>


        </div>

        <div class="col-md-2 col-lg-2 col-xl-4"></div>

    </div>

</body>
</html>