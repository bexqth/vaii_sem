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
    <title>Profile</title>
    <link href="public/css/useroverviewStyle.css" rel="stylesheet">
</head>

<body>

<div class="row">
    <div class="col-md-2 col-lg-2"></div>

    <div class="col-sm-12 col-md-8 col-lg-8 review-col">
        <div class="row banner-image-row">
            <?php if($data['userProfile']->getBannerPicture() == null) :?>
                <img src="https://live.staticflickr.com/3678/8986672784_bbf77b2aeb_b.jpg" class="banner-image" alt="...">
            <?php else : ?>
                <img src="<?= $data['userProfile']->getBannerPicture()?>" class="banner-image" alt="...">
            <?php endif; ?>


            <div class="row profile-picture-container">
                <div class="col-lg-2">

                    <?php if($data['userProfile']->getProfilePicture() == null) :?>
                        <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" class="profile-picture" alt="...">
                    <?php else : ?>
                        <img src="<?= $data['userProfile']->getProfilePicture()?>" class="profile-picture" alt="...">
                    <?php endif; ?>

                </div>
                <div class="col-lg-10">
                    <h2 class="user-name"><?=$data['user']->getUsername()?></h2>
                </div>

            </div>

        </div>

        <div class="row">
            <div class="col">
                <h3>Activity</h3>
            </div>

            <div class="col">
                <h3>Reviews</h3>

                <?php foreach ($data['reviews'] as $review) : ?>
                    <div class="row profile-bio-row review-item-row">
                        <div class="col-12 col-md-2 col-lg-2">
                            <h5><?=$review->getRating()?>/10</h5>
                            <h6>1 months ago</h6>

                            <?php if($auth->isLogged() && $auth->isAdmin()):?>
                                <a href="<?= $link->url('review.delete', ['id' => $review->getId()]) ?>"  class="btn btn-danger"><i class="bi bi-trash"></i></a>
                            <?php endif; ?>

                        </div>

                        <div class="col-sm-12 col-md-9 col-lg-9">
                            <p><?=$review->getReviewText()?></p>
                        </div>
                    </div>

                <?php endforeach; ?>


            </div>
        </div>


    </div>

    <div class="col-md-2 col-lg-2"></div>
</div>

</body>
</html>