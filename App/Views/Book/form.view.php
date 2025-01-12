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
    <link href="public/css/bookFormStyle.css" rel="stylesheet">
</head>
<body>

<div class="row">

    <div class="col-md-1 col-lg-2"></div>

    <div class="col-sm-12 col-md-10 col-lg-8 books-col">

        <div id="successMessage" class="alert alert-success" style="display: none;">
        </div>
        <div id="errorMessage" class="alert alert-danger" style="display: none;">
        </div>

        <div class="row book-row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 main-col">
                <div class="row images-row">
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <?php if ($data["chosenBook"] !== null) { ?>
                            <img id="book-cover"  src="<?=$data['chosenBook']->getCoverUrl()?>" class="book-cover" alt="">
                        <?php } else { ?>
                            <img id="book-cover"  src="https://m.media-amazon.com/images/I/41Rat4zbeiL._AC_UF894,1000_QL80_.jpg" class="book-cover" alt="">
                        <?php } ?>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div id="drop-zone-cover" class="drop-zone-cover">Drop an image here</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 main-col">
                <div class="row">

                    <div class="title-div">
                        <label class="tb-title title" for="title">Title</label><br>
                    </div>
                    <div class="tb-content">
                        <?php if ($data["chosenBook"] !== null) { ?>
                            <textarea id="title" name="title" class="input-text" required><?=$data['chosenBook']->getTitle()?></textarea><br>
                        <?php } else { ?>
                            <textarea id="title" name="title" class="input-text" required></textarea><br>
                        <?php } ?>
                    </div>

                    <div class="author-div">
                        <label class="tb-title author" for="authors">Choose an author:</label><br>
                    </div>
                    <div class="tb-content">
                        <?php if ($data["chosenBook"] !== null) { ?>
                            <select name="authors" id="authors" class="form-select" aria-label="Default select example">
                                <option selected><?=$data['bookAuthor']->getName()?></option>
                                <?php for($i = 0; $i < count($data['bookAuthors']); $i++) : ?>
                                    <option value=<?=$i?>><?=$data['bookAuthors'][$i]->getName()?></option>
                                <?php endfor; ?>
                            </select>
                        <?php } else { ?>
                            <select name="authors" id="authors" class="form-select" aria-label="Default select example">
                                <?php for($i = 0; $i < count($data['bookAuthors']); $i++) : ?>
                                    <option value=<?=$i?>><?=$data['bookAuthors'][$i]->getName()?></option>
                                <?php endfor; ?>
                            </select>
                        <?php } ?>
                    </div>


                    <div class="desc-div">
                        <label class="tb-title desc" for="description">Description</label><br>
                    </div>
                    <div class="tb-content">
                        <?php if ($data["chosenBook"] !== null) { ?>
                            <textarea  id="description" name="description" class="description-text input-text " required><?=$data['chosenBook']->getDescription()?></textarea><br>
                        <?php } else { ?>
                            <textarea id="description" name="description" class="description-text input-text" required></textarea><br>
                        <?php } ?>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md tb-col">
                            <div class="row">
                                <label class="tb-title" for="pages">Pages</label><br>
                            </div>
                            <div class="row tb-content">
                                <?php if ($data["chosenBook"] !== null) { ?>
                                    <textarea id="pages" name="pages" class="input-text" required><?=$data['chosenBook']->getPages()?></textarea><br>
                                <?php } else { ?>
                                    <textarea id="pages" name="pages" class="input-text" required></textarea><br>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md tb-col">
                            <div class="row">
                                <label class="tb-title" for="genres">Genre</label><br>
                            </div>
                            <div class="row tb-content">
                                <?php if ($data["chosenBook"] !== null) { ?>
                                    <select name="genres" id="genres" class="form-select" aria-label="Default select example">
                                        <option selected><?=$data['bookGenre']->getName()?></option>
                                        <?php for($i = 0; $i < count($data['bookGenres']); $i++) : ?>
                                            <option value=<?=$i?>><?=$data['bookGenres'][$i]->getName()?></option>
                                        <?php endfor; ?>
                                    </select>
                                <?php } else { ?>
                                    <select name="genres" id="genres" class="form-select" aria-label="Default select example">
                                        <?php for($i = 0; $i < count($data['bookGenres']); $i++) : ?>
                                            <option value=<?=$i?>><?=$data['bookGenres'][$i]->getName()?></option>
                                        <?php endfor; ?>
                                    </select>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md tb-col">
                            <div class="row">
                                <label class="tb-title" for="isbn">ISBN</label><br>
                            </div>
                            <div class="row tb-content">
                                <?php if ($data["chosenBook"] !== null) { ?>
                                    <textarea id="isbn" name="isbn" class="input-text" required><?=$data['chosenBook']->getIsbn()?></textarea><br>
                                <?php } else { ?>
                                    <textarea id="isbn" name="isbn" class="input-text" required></textarea><br>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md tb-col">
                            <div class="row">
                                <label class="tb-title" for="year">Published</label><br>
                            </div>
                            <div class="row tb-content">
                                <?php if ($data["chosenBook"] !== null) { ?>
                                    <textarea id="year" name="year" class="input-text" required><?=$data['chosenBook']->getPublicationDate()?></textarea><br>
                                <?php } else { ?>
                                    <textarea id="year" name="year" class="input-text" required></textarea><br>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <?php if ($data["chosenBook"] !== null) { ?>
                <button type="submit" name="submit" class="btn submit-button" onclick="sendBookFormData(<?=$data["chosenBook"]->getId()?>)">Submit</button>
            <?php } else { ?>
                <button type="submit" name="submit" class="btn submit-button" onclick="sendBookFormData(0)">Submit</button>
            <?php } ?>

            </div>
        </div>


    </div>

    <div class="col-md-1 col-lg-2"></div>

<script src="public/js/bookFormScript.js"></script>
</body>
</html>