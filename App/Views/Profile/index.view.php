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
    <link href="public/css/profilepageStyle.css" rel="stylesheet">
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

            <?php if($data['userProfile']->getUserId() != $auth->getLoggedUserId() && $auth->isUser()) :?>
                <?php if($data['isFollowing'] === true) :?>
                    <button id="follow-button" type="button" class="btn follow-button" onclick="updateFollowButton(<?=$data['userProfile']->getId()?>, true)"><i class="bi bi-heart-fill"></i></button>
                <?php else : ?>
                    <button id="follow-button" type="button" class="btn follow-button" onclick="updateFollowButton(<?=$data['userProfile']->getId()?>, false)"><i class="bi bi-heart"></i></button>
                <?php endif; ?>
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

        <div class="row content-row">
            <div class="col-lg-3">
                <div class="row profile-bio-row">
                    <p class="bio-text"> <?= $data['userProfile']->getBio()?>
                    </p>
                </div>

                <div class="row profile-bio-row">
                    <h5>Socials</h5>
                    <div class="col">
                        <h6 id="followers"><?=$data['user']->getFollowers()?> followers</h6>
                    </div>
                    <div class="col">
                        <h6 id="followings"><?=$data['user']->getFollowings()?> followings</h6>
                    </div>
                </div>


                <div class="row genre-row">
                    <h5>Top genres overview</h5>
                    <?php if ($data['nTopGenresNames'] != null) :?>
                        <?php for($i = 0; $i < count($data['nTopGenresNames']); $i++) : ?>
                            <div class="row">
                                <div class="col">
                                    <p class="sb-title"><?=$data['nTopGenresNames'][$i]?></p>
                                </div>

                                <div class="col">
                                    <p><?=$data['nTopGenresCount'][$i]?> Entries</p>
                                </div>
                            </div>
                        <?php endfor; ?>
                    <?php endif;?>
                </div>

                <div class="row profile-bio-row">
                    <h5>Favorite books</h5>
                    <div class="row profile-bio-row row-cols-2 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 g-2">
                        <?php if ($data['favoriteBooks'] != null) { ?>
                            <?php foreach ($data['favoriteBooks'] as $book): ?>
                                <div class="col">
                                    <div class="book-card card">
                                        <a href="<?= $link->url("book.index", ["id" => $book->getId()]) ?>">
                                            <img src="<?=$book->getCoverUrl()?>" class="card-img-top" alt="...">
                                        </a>
                                        <div class="card-body">
                                            <p class="card-title"><?=$book->getTitle()?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php } ?>
                    </div>
                </div>

            </div>

            <div class="list-col col-lg-9">
                <div class="reading-list-row">
                    <h4 class="list-title">Reading</h4>
                    <div class="row list list-reading-row">
                        <div class="row">
                            <div class="col-md-1 col-lg-1"></div>
                            <div class="col-md-7 col-lg-7">
                                <h5>Title</h5>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <h5>Progress</h5>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <h5>Score</h5>
                            </div>
                        </div>

                        <?php if ($data['readingBooks'] != null) :?>
                            <?php for($i = 0; $i < count($data['readingBooks']); $i++) : ?>
                                <div class="row book-list-row">
                                    <div class="col-md-1 col-lg-1 book-list-image-col"><img src="<?=$data['readingBooks'][$i]->getCoverUrl()?>" class="book-list-image" alt=""></div>
                                    <div class="col-md-7 col-lg-7 list-text-col">
                                        <p class="list-text"><?=$data['readingBooks'][$i]->getTitle()?></p>
                                    </div>
                                    <div class="col-md-2 col-lg-2 list-text-col">
                                        <p class="list-text"><?=$data['readingProgresses'][$i]?>/<?=$data['readingBooks'][$i]->getPages()?></p>
                                    </div>
                                    <div class="col-md-2 col-lg-2 list-text-col">
                                        <?php if ($data['readingReviews'][$i] == null) : ?>
                                            <p class="list-text">/10</p>
                                        <?php else : ?>
                                            <p class="list-text"><?=$data['readingReviews'][$i]->getRating()?>/10</p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            <?php endfor; ?>
                        <?php endif;?>
                    </div>

                </div>

                <div class="reading-list-row">
                    <h4 class="list-title">Finished</h4>
                    <div class="row list list-read-row">
                        <div class="row">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-7">
                                <h5>Title</h5>
                            </div>
                            <div class="col-lg-2">
                                <h5>Progress</h5>
                            </div>
                            <div class="col-lg-2">
                                <h5>Score</h5>
                            </div>
                        </div>

                        <?php if ($data['finishedBooks'] != null) :?>
                            <?php for($i = 0; $i < count($data['finishedBooks']); $i++) : ?>
                                <div class="row book-list-row">
                                    <div class="col-lg-1 book-list-image-col"><img src="<?=$data['finishedBooks'][$i]->getCoverUrl()?>" class="book-list-image" alt=""></div>
                                    <div class="col-lg-7 list-text-col">
                                        <p class="list-text"><?=$data['finishedBooks'][$i]->getTitle()?></p>
                                    </div>
                                    <div class="col-lg-2 list-text-col">
                                        <p class="list-text"><?=$data['finishedProgresses'][$i]?>/<?=$data['finishedBooks'][$i]->getPages()?></p>
                                    </div>
                                    <div class="col-lg-2 list-text-col">
                                        <?php if ($data['finishedReviews'][$i] == null) : ?>
                                            <p class="list-text">/10</p>
                                        <?php else : ?>
                                            <p class="list-text"><?=$data['finishedReviews'][$i]->getRating()?>/10</p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            <?php endfor; ?>
                        <?php endif;?>
                    </div>
                </div>

                <div class="reading-list-row">
                    <h4 class="list-title">Planning to read</h4>
                    <div class="row list list-planning-row">
                        <div class="row">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-7">
                                <h5>Title</h5>
                            </div>
                            <div class="col-lg-2">
                                <h5>Progress</h5>
                            </div>
                            <div class="col-lg-2">
                                <h5>Score</h5>
                            </div>
                        </div>

                        <?php if ($data['planningBooks'] != null) :?>
                            <?php for($i = 0; $i < count($data['planningBooks']); $i++) : ?>
                                <div class="row book-list-row">
                                    <div class="col-lg-1 book-list-image-col"><img src="<?=$data['planningBooks'][$i]->getCoverUrl()?>" class="book-list-image" alt=""></div>
                                    <div class="col-lg-7 list-text-col">
                                        <p class="list-text"><?=$data['planningBooks'][$i]->getTitle()?></p>
                                    </div>
                                    <div class="col-lg-2 list-text-col">
                                        <p class="list-text"><?=$data['planningProgresses'][$i]?>/<?=$data['planningBooks'][$i]->getPages()?></p>
                                    </div>
                                    <div class="col-lg-2 list-text-col">
                                        <?php if ($data['planningReviews'][$i] == null) : ?>
                                            <p class="list-text">/10</p>
                                        <?php else : ?>
                                            <p class="list-text"><?=$data['planningReviews'][$i]->getRating()?>/10</p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            <?php endfor; ?>
                        <?php endif;?>
                </div>
            </div>
        </div>


        </div>
    </div>

    <div class="col-md-2 col-lg-2"></div>
</div>
<script src="public/js/profileScript.js"></script>
</body>
</html>