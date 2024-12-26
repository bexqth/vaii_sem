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

            <div class="col-sm-12 col-md-3 col-lg-3">
                <div id="drop-zone-profile-picture" class="drop-zone-cover">Drop an image here</div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-6">
                <label for="title">Title</label><br>
                <textarea id="title" name="title" class="input-text" required><?=$data['chosenBook']->getTitle()?></textarea><br>

                <label for="authors">Choose an author:</label><br>


                <select name="authors" id="authors" class="form-select" aria-label="Default select example">
                    <option selected><?=$data['bookAuthor']->getName()?></option>
                    <?php for($i = 0; $i < count($data['bookAuthors']); $i++) : ?>
                        <option value=<?=$i?>><?=$data['bookAuthors'][$i]->getName()?></option>
                    <?php endfor; ?>
                </select>

                <label for="description">Description</label><br>
                <textarea id="description" name="description" class="description-text" required><?=$data['chosenBook']->getDescription()?></textarea><br>

                <table>
                    <tr>
                        <th>Pages</th>
                        <th>Cover</th>
                        <th>Genre</th>
                        <th>Language</th>
                        <th>Year of publishing</th>
                    </tr>
                    <tr>
                        <td>
                            <label for="pages"></label>
                            <textarea id="pages" name="pages" class="input-text" required><?=$data['chosenBook']->getPages()?></textarea><br>
                        </td>

                        <td>Paperback</td>
                        <td>
                            <select name="genres" id="genres" class="form-select" aria-label="Default select example">
                                <option selected><?=$data['bookGenre']->getName()?></option>
                                <?php for($i = 0; $i < count($data['bookGenres']); $i++) : ?>
                                    <option value=<?=$i?>><?=$data['bookGenres'][$i]->getName()?></option>
                                <?php endfor; ?>
                            </select>
                        </td>

                        <td>English</td>
                        <td>
                            <label for="year"></label>
                            <textarea id="year" name="year" class="input-text" required><?=$data['chosenBook']->getPublicationDate()?></textarea><br>
                        </td>

                    </tr>
                </table>

                <button type="submit" name="submit" class="btn submit-button" onclick="sendFormData()">Submit</button>

            </div>
        </div>


    </div>

    <div class="col-md-2 col-lg-2"></div>

</div>

<script src="public/js/bookScript.js"></script>
</body>
</html>