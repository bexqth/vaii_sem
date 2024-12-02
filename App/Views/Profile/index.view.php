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
            <img src="https://i.pinimg.com/736x/59/6e/d1/596ed169ce00d8a7c611c93c92d66b37.jpg" class="banner-image" alt="Welcome Image">

            <div class="row profile-picture-container">
                <div class="col-lg-2">
                    <img src="https://i.pinimg.com/736x/e4/60/b6/e460b6c769d4d8ec53a17990ec1398a3.jpg" class="profile-picture" alt="...">
                </div>
                <div class="col-lg-10">
                    <h2 class="user-name"><?=$data['user']->getUsername()?></h2>
                </div>

            </div>

        </div>

        <div class="row content-row">
            <div class="col-lg-3">
                <div class="row profile-bio-row">
                    <p class="bio-text">Hello! I'm John, a passionate software developer with over 10 years of experience.
                        I love coding, hiking, and spending time with my family.
                        Always eager to learn new technologies and take on exciting challenges.
                        Let's connect and build something amazing together!
                    </p>
                </div>

                <div class="row genre-row">
                    <h5>Genre overview</h5>
                        <div class="progress">
                            <div class="progress-bar custom-progress-bar-1" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar custom-progress-bar-2" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar custom-progress-bar-3" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                </div>
            </div>
            <div class="col-lg-9">
                <h4 class="list-title">Reading</h4>
                <div class="row list list-reading-row">
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

                    <?php for($i = 0; $i < count($data['readingBooks']); $i++) : ?>
                        <div class="row book-list-row">
                            <div class="col-lg-1 book-list-image-col"><img src="<?=$data['readingBooks'][$i]->getCoverUrl()?>" class="book-list-image" alt=""></div>
                            <div class="col-lg-7 list-text-col">
                                <p class="list-text"><?=$data['readingBooks'][$i]->getTitle()?></p>
                            </div>
                            <div class="col-lg-2 list-text-col">
                                <p class="list-text">0/<?=$data['readingBooks'][$i]->getPages()?></p>
                            </div>
                            <div class="col-lg-2 list-text-col">
                                <?php if ($data['readingReviews'][$i] == null) : ?>
                                    <p class="list-text">/10</p>
                                <?php else : ?>
                                    <p class="list-text"><?=$data['readingReviews'][$i]->getRating()?>/10</p>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php endfor; ?>

                </div>

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

                    <?php for($i = 0; $i < count($data['finishedBooks']); $i++) : ?>
                        <div class="row book-list-row">
                            <div class="col-lg-1 book-list-image-col"><img src="<?=$data['readingBooks'][$i]->getCoverUrl()?>" class="book-list-image" alt=""></div>
                            <div class="col-lg-7 list-text-col">
                                <p class="list-text"><?=$data['readingBooks'][$i]->getTitle()?></p>
                            </div>
                            <div class="col-lg-2 list-text-col">
                                <p class="list-text">0/<?=$data['readingBooks'][$i]->getPages()?></p>
                            </div>
                            <div class="col-lg-2 list-text-col">
                                <?php if ($data['readingReviews'][$i] == null) : ?>
                                    <p class="list-text">/10</p>
                                <?php else : ?>
                                    <p class="list-text"><?=$data['readingReviews'][$i]->getRating()?>/10</p>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php endfor; ?>
                </div>

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

                    <?php for($i = 0; $i < count($data['planningBooks']); $i++) : ?>
                        <div class="row book-list-row">
                            <div class="col-lg-1 book-list-image-col"><img src="<?=$data['readingBooks'][$i]->getCoverUrl()?>" class="book-list-image" alt=""></div>
                            <div class="col-lg-7 list-text-col">
                                <p class="list-text"><?=$data['readingBooks'][$i]->getTitle()?></p>
                            </div>
                            <div class="col-lg-2 list-text-col">
                                <p class="list-text">0/<?=$data['readingBooks'][$i]->getPages()?></p>
                            </div>
                            <div class="col-lg-2 list-text-col">
                                <?php if ($data['readingReviews'][$i] == null) : ?>
                                    <p class="list-text">/10</p>
                                <?php else : ?>
                                    <p class="list-text"><?=$data['readingReviews'][$i]->getRating()?>/10</p>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php endfor; ?>
                </div>

            </div>

        </div>


    </div>

    <div class="col-md-2 col-lg-2"></div>
</div>

</body>
</html>