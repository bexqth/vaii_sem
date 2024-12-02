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
        <div class="row book-row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <img src="<?=$data['chosenBook']->getCoverUrl()?>" class="book-cover" alt="">
            </div>

            <div class="col-sm-12 col-md-9 col-lg-9">
                <h3><?=$data['chosenBook']->getTitle()?></h3>
                <h4><?=$data['chosenBook']->getAuthor()?></h4>
                <h6 class="progress-title">Your progress: 0/320 pages</h6>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
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
                        <td><?=$data['chosenBook']->getGenre()?></td>
                        <td>English</td>
                        <td><?=$data['chosenBook']->getPublicationDate()?></td>
                    </tr>
                </table>
                <!--<button type="button" class="btn button-status">Add to list</button>-->
                <div class="btn-group">
                    <button id="statusButton" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if ($data['bookStatus'] == null) : ?>
                            Set status
                        <?php else : ?>
                            <?=$data['bookStatus']?>
                        <?php endif; ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button id="readingButton" class="dropdown-item" type="button" onclick="addToReading(<?=$data['chosenBook']->getId()?>, 'Reading')">Set as reading</button>
                        <button id="finishedButton" class="dropdown-item" type="button" onclick="addToReading(<?=$data['chosenBook']->getId()?>, 'Finished')">Set as finished</button>
                        <button id="planningButton" class="dropdown-item" type="button" onclick="addToReading(<?=$data['chosenBook']->getId()?>, 'Planning')">Set as planning</button>
                    </div>
                </div>

            </div>
        </div>

        <h2 class="review-title">Reviews</h2>

        <div class="row lock-review-row">
            <?php if ($auth->isLogged()) { ?>
                <a href="<?= $link->url('review.index', ["id" => $data['chosenBook']->getId()]) ?>" class="btn">Leave a review</a>
            <?php } else { ?>
                <div class="col lock-review-col text-end">
                    <img class="lock-review-image"  src="public/images/lock-icon1.png" alt="">
                </div>

                <div class="col lock-review-col">
                    <p class="lock-review-text"><i class="bi bi-chat-left-text"></i>Sign in to write a review</p>
                </div>
            <?php } ?>

        </div>

        <?php foreach ($data['chosenBookReviews'] as $review) : ?>
            <div class="row review-item-row">
                <div class="col-3 col-sm-3 col-md-1 col-lg-1">
                    <img class="review-image" src="https://img.freepik.com/free-vector/young-bearded-man_24877-82119.jpg?t=st=1729269110~exp=1729272710~hmac=5aa0e1a15e8903f3a823c43f12e069450343e0ff3ac8dc6bde57761725b4da1d&w=826" alt="">
                </div>
                <div class="col-12 col-md-2 col-lg-2">
                    <h5><?=$review->getRating()?>/10</h5>
                    <h6><?=$review->getReviewAuthor()?></h6>
                    <h6>1 months ago</h6>

                    <?php if($auth->isLogged() && $review->getReviewAuthor() == $auth->getLoggedUserName()):?>
                        <a href="<?= $link->url('review.edit', ['id' => $review->getId()]) ?>" class="btn btn-primary"><i class="bi bi-pencil-fill"></i></a>
                        <a href="<?= $link->url('review.delete', ['id' => $review->getId()]) ?>"  class="btn btn-danger"><i class="bi bi-trash"></i></a>
                        <!-- <button type="button" class="btn btn-primary"><i class="bi bi-pencil-fill"></i></button>
                        <button type="button" class="btn btn-danger"><i class="bi bi-trash"></i></button> -->
                    <?php endif; ?>

                </div>

                <div class="col-sm-12 col-md-9 col-lg-9">
                    <p><?=$review->getReviewText()?></p>
                </div>
            </div>

        <?php endforeach; ?>


    </div>

    <div class="col-md-2 col-lg-2"></div>

</div>

<script src="public/js/bookScript.js"></script>
</body>
</html>