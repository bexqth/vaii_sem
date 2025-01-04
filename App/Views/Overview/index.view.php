<?php

/** @var array $data */
/** @var \App\Core\LinkGenerator $link */
/** @var \App\Core\IAuthenticator $auth */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>welcome page</title>
    <link href="public/css/overviewStyle.css" rel="stylesheet">
</head>

<body>

<div class="row">
    <div class="col-md-2 col-lg-2"></div>

    <div class="col-sm-12 col-md-8 col-lg-8 review-col">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <h3>Activity</h3>

                <?php if ($data['followedPeopleActivities'] != null) :?>
                    <?php for($i = 0; $i < count($data['followedPeopleActivities']); $i++) : ?>
                        <div class="row profile-bio-row review-item-row">

                            <div class="col-3 col-sm-3 col-md-1 col-lg-1">
                                <img class="review-image" src="<?=$data['followedUsersProfiles'][$i]->getProfilePicture()?>" alt="">
                            </div>

                            <div class="author-col col-12 col-md-2 col-lg-2">
                                <h4 class="author"><?=$data['followedPeopleActivities'][$i]->getAuthor()?></h4>
                            </div>

                            <div class="text-col col-sm-12 col-md-9 col-lg-9">
                                <p class="text"><?=$data['followedPeopleActivities'][$i]->getActivityText()?></p>
                            </div>
                        </div>
                    <?php endfor; ?>
                <?php endif;?>
            </div>

            <div class="col-12 col-md-6 col-lg-6">
                <h3>Reviews</h3>
            </div>
    </div>

    <div class="col-md-2 col-lg-2"></div>
</div>

</body>
</html>