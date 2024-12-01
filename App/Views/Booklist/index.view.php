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
    <title>Booklist</title>
    <link href="public/css/booklistpageStyle.css" rel="stylesheet">
</head>
<body>

<div class="flex-container">
    <div class="row">

        <div class="col-md-1 col-lg-1"></div>

        <div class="col-sm-4 col-md-2 col-lg-2 book-genres-col">
            <div class="btn-group-vertical w-100" role="group" aria-label="Vertical button group">
                <div class="row dropdown-container">
                    <div class="col">
                        <h5 class="categories-title">Categories</h5>
                    </div>
                    <div class="col">
                        <button id="dropButton" class="btn drop-category-button" onclick="toggleCategories()">▲</button>
                    </div>
                </div>
                <div id="categoryButtons" class="dropdown-content">
                    <button type="button" class="btn">All</button>
                    <button type="button" class="btn">Art</button>
                    <button type="button" class="btn">Literary Fiction</button>
                    <button type="button" class="btn">Historical Fiction</button>
                    <button type="button" class="btn">Science Fiction</button>
                    <button type="button" class="btn">Fantasy</button>
                    <button type="button" class="btn">Mystery</button>
                    <button type="button" class="btn">Thriller</button>
                    <button type="button" class="btn">Romance</button>
                    <button type="button" class="btn">Horror</button>
                    <button type="button" class="btn">Biography</button>
                    <button type="button" class="btn">History</button>
                    <button type="button" class="btn">Poetry</button>
                    <button type="button" class="btn">Drama</button>
                    <button type="button" class="btn">Classics</button>
                </div>
            </div>
        </div>


        <div class="col-sm-8 col-md-8 col-lg-8 books-col">
            <div class="booklist-title-container">
                <img class="booklist-logo" src="public/images/booklist_icon.png" alt="...">
                <h2 class="booklist-title">Booklist</h2>
            </div>


            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4 book-list-row">

                <?php foreach ($data['books'] as $book) : ?>

                <div class="col">
                    <div class="card">
                        <a href="<?= $link->url("book.index", ["id" => $book->getId()]) ?>">
                            <img src="<?=$book->getCoverUrl()?>" class="card-img-top" alt="...">
                        </a>
                        <div class="card-body">
                            <h6 class="card-title"><?=$book->getTitle()?></h6>
                            <p class="card-title"><?=$book->getAuthor()?></p>
                        </div>
                    </div>

                </div>

                <?php endforeach; ?>

        </div>

        <div class="col-md-1 col-lg-1 right-border"></div>

    </div>

</div>

    <script src="public/js/booklistScript.js"></script>
</body>
</html>