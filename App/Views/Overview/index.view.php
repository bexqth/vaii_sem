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
    <div class="col-xl-2 col-xxl-2"></div>

    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-8 col-xxl-8 review-col">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <h3>Activity</h3>
                <h4>People you follow</h4>
                <?php if ($data['followedPeopleActivities'] != null) :?>
                    <?php for($i = 0; $i < count($data['followedPeopleActivities']); $i++) : ?>
                        <div class="row profile-bio-row review-item-row">

                            <div class="col-md-2 col-lg-2 image-col">
                                <?php if($data['followedUsersProfiles'][$i]->getProfilePicture() == null):?>
                                    <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" class="review-image" alt="">
                                <?php else: ?>
                                    <img class="review-image" src="<?=$data['followedUsersProfiles'][$i]->getProfilePicture()?>" alt="">
                                <?php endif; ?>
                            </div>

                            <div class="author-col col-sm-12 col-md-2 col-lg-2">
                                <a href="<?= $link->url("profile.index", ["userId" => $data['followedUsersProfiles'][$i]->getUserId()]) ?>" class="author"><?=$data['followedPeopleActivities'][$i]->getAuthor()?></a>
                            </div>

                            <div class="text-col col-sm-12 col-md-8 col-lg-8">
                                <p class="text"><?=$data['followedPeopleActivities'][$i]->getActivityText()?></p>
                            </div>
                        </div>
                    <?php endfor; ?>
                <?php endif;?>
            </div>

            <div class="col-12 col-md-6 col-lg-6">
                <h3>Books to see</h3>
                <div class="row">
                    <h4>Recently added</h4>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-3 g-4 book-list-row">
                        <?php foreach ($data['recentlyAddedBooks'] as $book): ?>
                            <div class="col">
                                <div class="book-card card">
                                    <a href="<?= $link->url("book.index", ["id" => $book->getId()]) ?>">
                                        <img src="<?=$book->getCoverUrl()?>" class="card-img-top" alt="...">
                                    </a>
                                    <div class="card-body">
                                        <h6 class="card-title"><?=$book->getTitle()?></h6>
                                        <h6 class="card-title">Added: <?=$book->getFormatedDateOfCreation()?></h6>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="row">
                    <h4>Best review</h4>

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-3 g-4 book-list-row">
                        <?php foreach ($data['bestReviewedBooks'] as $book): ?>
                            <div class="col">
                                <div class="book-card card">
                                    <a href="<?= $link->url("book.index", ["id" => $book->getId()]) ?>">
                                        <img src="<?=$book->getCoverUrl()?>" class="card-img-top" alt="...">
                                    </a>
                                    <div class="card-body">
                                        <h6 class="card-title"><?=$book->getTitle()?></h6>
                                        <h6 class="card-title"><?=$book->getAverageRating()?>/10</h6>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                 </div>

                 <div class="row">
                     <h4>You might like</h4>

                     <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-3 g-4 book-list-row">
                         <?php foreach ($data['similarBooks'] as $book): ?>
                             <div class="col">
                                 <div class="book-card card">
                                     <a href="<?= $link->url("book.index", ["id" => $book->getId()]) ?>">
                                         <img src="<?=$book->getCoverUrl()?>" class="card-img-top" alt="...">
                                     </a>
                                     <div class="card-body">
                                         <h6 class="card-title"><?=$book->getTitle()?></h6>
                                         <h6 class="card-title"><?=$book->getAverageRating()?>/10</h6>
                                     </div>
                                 </div>
                             </div>
                         <?php endforeach; ?>
                     </div>
                 </div>

             </div>
     </div>

     <div class="col-xl-2 col-xxl-2"></div>
 </div>

 </body>
 </html>