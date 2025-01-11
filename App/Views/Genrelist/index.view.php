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
    <title>Genres</title>
    <link href="public/css/genrelistStyle.css" rel="stylesheet">
</head>
<body>

<div class="row">

    <div class="col-md-2 col-lg-2"></div>

    <div class="col-sm-12 col-md-8 col-lg-8 books-col">
        <div class="row row-container">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="list-col">
                    <h3>Genres</h3>
                    <button class="btn" onclick="createNewGenre()">New genre</button>
                    <div id="genre-list">
                        <?php foreach ($data['genres'] as $genre): ?>
                            <div class="genre-row">
                                <button class="btn" onclick="selectGenre('<?=$genre->getName()?>', <?=$genre->getId()?>)"><?=$genre->getName()?></button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-6">
                <div class="form-col">
                    <h3 id="genre-title">Create new author</h3>
                    <div class="row">
                        <img class="genre-icon" src="public/images/genre_icon.png" alt="...">
                    </div>

                    <div class="row">
                        <label for="genre-name"></label>
                        <textarea id="genre-name" name="description" class="genre-name" required></textarea><br>
                    </div>

                    <button type="submit" name="submit" class="btn submit-button" onclick="submit()">Submit</button>
                </div>
            </div>
    </div>

    <div class="col-md-2 col-lg-2"></div>

</div>
    <script src="public/js/genrelistScript.js"></script>
</body>
</html>