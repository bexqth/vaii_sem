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
    <link href="public/css/reviewFormStyle.css" rel="stylesheet">
</head>

<body>

<div class="row">
    <div class="col-md-2 col-lg-2"></div>

    <div class="col-sm-12 col-md-8 col-lg-8 review-col">
        <h3 class="review-title">Book review</h3>

        <div class="row">
            <div class="col-md-3">
                <div class="image-row">
                    <img src="<?=$data['chosenBook']->getCoverUrl()?>" class="book-cover" alt="...">
                </div>
            </div>

            <div class="col-md-9">
                <div class="book-info-row">
                    <h3><?=$data['chosenBook']->getTitle()?></h3>
                    <h4><?=$data['chosenBook']->getAuthor()?></h4>
                </div>
                <div class="row">

                    <?php
                    if (isset($data['review'])) {
                        $actionUrl = $link->url('review.add', ["id" => $data['chosenBook']->getId(), "reviewId" => $data['review']->getId()]);
                    } else {
                        $actionUrl = $link->url('review.add', ["id" => $data['chosenBook']->getId()]);
                    }
                    ?>

                    <form action="<?= $actionUrl ?>" method="post">
                        <div class="row">
                            <label for="review_text">Write your review:</label>
                        </div>
                        <div class="row">
                            <?php if ($data["review"] == null) { ?>
                                <textarea id="review_text" name="review_text" class="review-text" required></textarea><br>
                            <?php } else { ?>
                                <textarea id="review_text" name="review_text" class="review-text" required><?= $data["review"]->getReviewText()?></textarea><br>
                            <?php } ?>

                        </div>
                        <div class="row">
                            <label for="rating">Rating (1-10):</label>
                        </div>
                        <div class="row">
                            <?php if ($data["review"] == null) { ?>
                                <input type="number" id="rating" name="rating" min="1" max="10" class="score-selection" required><br>
                            <?php } else { ?>
                                <input type="number" id="rating" name="rating" min="1" max="10" class="score-selection"  value="<?=$data['review']->getRating()?>" required><br>
                            <?php } ?>

                        </div>
                        <div class="row">
                            <button type="submit" name="submit" class="btn submit-button">Submit</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <div class="col-md-2 col-lg-2"></div>
</div>

</body>
</html>