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
                <button type="button" class="btn button-status">Add to list</button>
            </div>
        </div>

        <h2 class="review-title">Reviews</h2>

        <div class="row lock-review-row">
            <div class="col lock-review-col text-end">
                <img class="lock-review-image"  src="public/images/lock-icon1.png" alt="">
            </div>
            <div class="col lock-review-col">
                <p class="lock-review-text">Sign in to write a review</p>
            </div>

        </div>

        <div class="row review-item-row">
            <div class="col-3 col-sm-3 col-md-1 col-lg-1">
                <img class="review-image" src="https://img.freepik.com/free-vector/young-bearded-man_24877-82119.jpg?t=st=1729269110~exp=1729272710~hmac=5aa0e1a15e8903f3a823c43f12e069450343e0ff3ac8dc6bde57761725b4da1d&w=826" alt="">
            </div>
            <div class="col-12 col-md-2 col-lg-2">
                <h5>9/10</h5>
                <h6>User 1</h6>
                <h6>1 months ago</h6>
            </div>

            <div class="col-sm-12 col-md-9 col-lg-9">
                <p>To Kill a Mockingbird is a timeless masterpiece that delves deep into the themes of racial injustice and moral growth. Harper Lee’s storytelling is both poignant and powerful, capturing the innocence of childhood while confronting the harsh realities of prejudice. The characters, especially Atticus Finch, are wonderfully crafted and leave a lasting impression. The novel’s ability to evoke empathy and provoke thought makes it a must-read. The only reason it doesn’t get a perfect score is due to some slower-paced sections, but overall, it’s an exceptional read</p>
            </div>
        </div>

        <div class="row review-item-row">
            <div class="col-3 col-sm-3 col-md-1 col-lg-1">
                <img class="review-image" src="https://img.freepik.com/free-vector/happy-young-man-smiling_24877-81914.jpg?t=st=1729269121~exp=1729272721~hmac=458492a2f014331f7cffb1af5ee5b2ceed57110dfbfbfd5c5e6b7e099fbd0c81&w=826" alt="">
            </div>
            <div class="col-12 col-md-2 col-lg-2">
                <h5>8/10</h5>
                <h6>User 2</h6>
                <h6>2 months ago</h6>
            </div>

            <div class="col-sm-12 col-md-9 col-lg-9">
                <p>Harper Lee’s To Kill a Mockingbird is a compelling exploration of human nature and morality. The narrative, seen through the eyes of young Scout Finch, is both engaging and insightful. The book’s portrayal of racial tensions in the American South is both heartbreaking and eye-opening. While the story is impactful, some readers might find the pacing a bit uneven. Despite this, the novel’s strengths far outweigh its minor flaws, making it a highly recommended read for anyone interested in classic literature.</p>
            </div>
        </div>

    </div>

    <div class="col-md-2 col-lg-2"></div>

</div>


</body>
</html>