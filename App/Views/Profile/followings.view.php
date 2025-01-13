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
    <link href="public/css/followlistStyle.css" rel="stylesheet">
</head>
<body>

<div class="flex-container">
    <div class="row">
        <div class="col-md-2 col-lg-2 col-xl-4"></div>

        <div class="col-sm-12 col-md-8 col-lg-8 col-xl-4 form-col">

            <div class="container">
                <h2>Followings</h2>
                <?php for($i = 0; $i < count($data['users']); $i++) : ?>
                    <div class="row profile-bio-row review-item-row">
                        <div class="image-col col-sm-2 col-md-2 col-lg-2">
                            <?php if($data['profiles'][$i]->getProfilePicture() == null):?>
                                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" class="review-image" alt="">
                            <?php else: ?>
                                <img class="review-image" src="<?=$data['profiles'][$i]->getProfilePicture()?>" alt="">
                            <?php endif; ?>
                        </div>

                        <div class="author-col col-sm-10 col-md-10 col-lg-10">
                            <a class="" href="<?= $link->url("profile.index", ["userId" => $data['users'][$i]->getId()]) ?>"><?=$data['users'][$i]->getUsername()?></a>
                        </div>
                    </div>
                <?php endfor; ?>

            </div>

        </div>

        <div class="col-md-2 col-lg-2 col-xl-4"></div>

    </div>

</body>
</html>