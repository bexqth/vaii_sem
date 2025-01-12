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
                    <div class="col c-col">
                        <h5 class="categories-title">Categories</h5>
                    </div>
                    <div class="col b-col">
                        <button id="dropButton" class="btn drop-category-button" onclick="toggleCategories()">▲</button>
                    </div>
                </div>
                <div id="categoryButtons" class="dropdown-content">
                    <button type="button" class="btn genre-button" onclick="filterBooks(0, 'All')">All</button>
                    <?php foreach ($data['genres'] as $genre): ?>
                        <button id="<?=$genre->getId()?>" type="button" class="btn genre-button" onclick="filterBooks(<?=$genre->getId()?>, '<?=$genre->getName()?>')"><?=$genre->getName()?></button>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>


        <div class="col-sm-8 col-md-8 col-lg-8 books-col">
            <div class="booklist-title-container">
                <img class="booklist-logo" src="public/images/booklist_icon.png" alt="...">
                <h2 id="booklist-title" class="booklist-title">Booklist - All</h2>
            </div>


            <div id="booksSpace" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-5 g-4 book-list-row">
                <?php for($i = 0; $i < count($data['books']); $i++) : ?>
                    <div class="col">
                        <div class="book-card card">
                            <a href="<?= $link->url("book.index", ["id" => $data['books'][$i]->getId()]) ?>">
                                <img src="<?=$data['books'][$i]->getCoverUrl()?>" class="card-img-top" alt="...">
                            </a>
                            <div class="card-body">
                                <h6 class="card-title"><?=$data['books'][$i]->getTitle()?></h6>
                                <p class="card-title"><?=$data['authors'][$i]->getName()?></p>
                            </div>
                        </div>

                    </div>
                <?php endfor; ?>

            </div>

        <div class="col-md-1 col-lg-1 right-border"></div>

    </div>

</div>

    <script src="public/js/booklistScript.js"></script>
</body>
</html>