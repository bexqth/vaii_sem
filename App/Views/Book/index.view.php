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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book</title>
    <link href="public/css/bookTemplateStyle.css" rel="stylesheet">
</head>
<body>

<div class="row">

    <div class="col-md-2 col-lg-2"></div>

    <div class="col-sm-12 col-md-8 col-lg-8 books-col">

        <div id="successMessage" class="alert alert-success" style="display: none;">
        </div>

        <div id="errorMessage" class="alert alert-danger" style="display: none;">
        </div>

        <div class="row book-row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <img src="<?=$data['chosenBook']->getCoverUrl()?>" class="book-cover" alt="">

            </div>

            <div class="col-sm-12 col-md-9 col-lg-9">
                <h3><?=$data['chosenBook']->getTitle()?></h3>
                <h4><?=$data['bookAuthor']->getName()?></h4>

                <?php if ($auth->isLogged() && !$auth->isAdmin()) : ?>
                    <h6 class="progress-title">Your progress:

                        <?php if ($data['readingProgress'] == null) : ?>
                            <input type="number" id="pagesReadInput" name="pagesRead" class="progress-input" value="0" min="0" readonly>
                        <?php else : ?>
                            <input type="number" id="pagesReadInput" name="pagesRead" class="progress-input" value=<?=$data["readingProgress"]->getPagesRead()?> min="0" readonly>
                        <?php endif; ?>

                        /<?= $data['chosenBook']->getPages() ?> pages
                        <button id="editPagesButton" class="btn btn-sm editPagesButton" onclick="updateProgress(<?=$data['chosenBook']->getId()?>, <?=$data["chosenBook"]->getPages()?>)"><i class="bi bi-plus-lg"></i></button>
                    </h6>

                    <div class="progress">
                        <div class="progress-bar" id="progressBar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="<?= $data['chosenBook']->getPages() ?>"
                             style="width: <?= $data['progressPercentage']?>%">
                        </div>
                    </div>

                <?php endif; ?>

                <p class="book-description"><?=$data['chosenBook']->getDescription()?></p>

                <table>
                    <tr>
                        <th>Pages</th>
                        <th>Cover</th>
                        <th>Genre</th>
                        <th>Language</th>
                        <th>Year of publishing</th>
                    </tr>
                    <tr>
                        <td><?=$data['chosenBook']->getPages()?></td>
                        <td>Paperback</td>
                        <td><?=$data['bookGenre']->getName()?></td>
                        <td>English</td>
                        <td><?=$data['chosenBook']->getPublicationDate()?></td>
                    </tr>
                </table>

                <?php if ($auth->isLogged() && !$auth->isAdmin()) : ?>
                    <div class="btn-group">
                        <button id="statusButton" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php if ($data['bookStatus'] == null) : ?>
                                Set status
                            <?php else : ?>
                                <?=$data['bookStatus']?>
                            <?php endif; ?>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button id="readingButton" class="dropdown-item" type="button" onclick="addToReading(1, <?=$data['chosenBook']->getId()?>, 'reading')">Set as reading</button>
                            <button id="finishedButton" class="dropdown-item" type="button" onclick="addToReading(2, <?=$data['chosenBook']->getId()?>, 'finished')">Set as finished</button>
                            <button id="planningButton" class="dropdown-item" type="button" onclick="addToReading(3, <?=$data['chosenBook']->getId()?>, 'planning')">Set as planning</button>
                        </div>

                        <div>
                            <?php if($data['isFavorite'] === true) :?>
                                <button id="favorite-button" type="button" class="btn favorite-button" onclick="updateFavoriteButton(<?=$data['chosenBook']->getId()?>, true)"><i class="bi bi-heart-fill"></i></button>
                            <?php else : ?>
                                <button id="favorite-button" type="button" class="btn favorite-button" onclick="updateFavoriteButton(<?=$data['chosenBook']->getId()?>, false)"><i class="bi bi-heart"></i></button>
                            <?php endif; ?>
                        </div>

                    </div>

                <?php elseif ($auth->isLogged() && $auth->isAdmin()) : ?>
                    <a href="<?= $link->url('book.form', ['id' => $data['chosenBook']->getId()]) ?>" class="btn btn-primary"><i class="bi bi-pencil-fill"></i></a>
                    <a href="<?= $link->url('book.delete', ['id' => $data['chosenBook']->getId()]) ?>"  class="btn btn-danger"><i class="bi bi-trash"></i></a>
                <?php endif; ?>

            </div>
        </div>

        <div class="row book-row">
            <div class="col-md-6">
                <h5>Status Distribution</h5>
                <div class="status-distribution">
                    <div class="row">
                        <div class="col sb-col">
                            <div class="row">
                                <h6 class="sb-title sb-title-reading">Reading</h6>
                            </div>
                            <div class="row">
                                <h6><?=$data['readingCount']?> users</h6>
                            </div>
                        </div>
                        <div class="col sb-col">
                            <div class="row">
                                <h6 class="sb-title sb-title-finished">Finished</h6>
                            </div>
                            <div class="row">
                                <h6><?=$data['finishedCount']?> users</h6>
                            </div>
                        </div>
                        <div class="col sb-col">
                            <div class="row">
                                <h6 class="sb-title sb-title-planning">Planning</h6>
                            </div>
                            <div class="row">
                                <h6><?=$data['planningCount']?> users</h6>
                            </div>
                        </div>
                </div>

            </div>

            </div>

            <div class="col-md-6">
                <h5>Following</h5>
                <?php for($i = 0; $i < count($data['followingUsers']); $i++) : ?>
                    <div class="row">

                        <div class="row followings-row">

                            <div class="col-3 col-sm-3 col-md-1 col-lg-1">
                                <img class="review-image" src="<?= $data['followingsProfilePics'][$i]?>" alt="">
                            </div>

                            <div class="author-col col-12 col-md-2 col-lg-2">
                                <h5><?=$data['followingUsers'][$i]?></h5>
                            </div>

                            <div class="text-col col-sm-12 col-md-9 col-lg-9">
                                <h5><?=$data['followingsStatuses'][$i]?></h5>
                            </div>
                        </div>

                    </div>
                <?php endfor; ?>
            </div>

        </div>

        <h2 class="review-title">Reviews</h2>
        <?php if ($auth->isLogged() && $auth->isUser()) : ?>
            <div class="row lock-review-row">
                    <a href="<?= $link->url('review.index', ["id" => $data['chosenBook']->getId()]) ?>" class="btn">Leave a review</a>
            </div>
        <?php elseif ($auth->isLogged() && $auth->isAdmin()): ?>
            <div>

            </div>
        <?php else : ?>
            <div class="row lock-review-row">
                <div class="col lock-review-col text-end">
                    <img class="lock-review-image"  src="public/images/lock-icon1.png" alt="">
                </div>

                <div class="col lock-review-col">
                    <p class="lock-review-text">Sign in to write a review</p>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($data['chosenBookReviews'] != null) :?>
            <?php for($i = 0; $i < count($data['chosenBookReviews']); $i++) : ?>
                <div class="row profile-bio-row review-item-row">
                    <div class="col-3 col-sm-3 col-md-1 col-lg-1">
                        <img class="review-image" src="<?= $data['reviewUsers'][$i]->getProfilePicture()?>" alt="">
                    </div>
                    <div class="col-12 col-md-2 col-lg-2">
                        <h5><?=$data['chosenBookReviews'][$i]->getRating()?>/10</h5>
                        <a href="<?= $link->url("profile.index", ["userId" => $data['reviewUsers'][$i]->getUserId()]) ?>"><?=$data['chosenBookReviews'][$i]->getReviewAuthor()?></a>
                        <h6><?=$data["chosenBookReviews"][$i]->getCreatedAtString()?></h6>

                        <?php if(($auth->isLogged() && $data['chosenBookReviews'][$i]->getReviewAuthor() == $auth->getLoggedUserName())):?>
                            <a href="<?= $link->url('review.edit', ['id' => $data['chosenBookReviews'][$i]->getId()]) ?>" class="btn btn-primary"><i class="bi bi-pencil-fill"></i></a>
                        <?php endif; ?>
                        <?php if(($auth->isLogged() && $auth->isAdmin()) || ($auth->isLogged() && !$auth->isAdmin() && $data['chosenBookReviews'][$i]->getReviewAuthor() == $auth->getLoggedUserName())):?>
                            <a href="<?= $link->url('review.delete', ['id' => $data['chosenBookReviews'][$i]->getId()]) ?>"  class="btn btn-danger"><i class="bi bi-trash"></i></a>
                        <?php endif; ?>

                    </div>

                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <p><?=$data['chosenBookReviews'][$i]->getReviewText()?></p>
                    </div>
                </div>

            <?php endfor; ?>
        <?php endif;?>

    </div>

    <div class="col-md-2 col-lg-2"></div>

</div>

<script src="public/js/bookScript.js"></script>
</body>
</html>