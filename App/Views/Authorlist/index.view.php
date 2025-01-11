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
    <title>Authors</title>
    <link href="public/css/authorlistStyle.css" rel="stylesheet">
</head>
<body>

<div class="row">

    <div class="col-md-2 col-lg-2"></div>

    <div class="col-sm-12 col-md-8 col-lg-8 review-col">
        <div class="row row-container">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="list-col">
                        <h3>Authors</h3>
                        <button class="btn" onclick="createNewAuthor()">New author</button>
                        <div id="authors-list">
                            <?php foreach ($data['authors'] as $author): ?>
                                <div class="author-row">
                                    <button class="btn" onclick="selectAuthor('<?=$author->getName()?>', <?=$author->getId()?>)"><?=$author->getName()?></button>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    </div>

                </div>

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="form-col">
                        <h3 id="author-title">Create new author</h3>
                        <div class="row">
                            <img class="author-icon" src="public/images/author3_icon.png" alt="...">
                        </div>

                        <div class="row">
                            <label for="author-name"></label>
                            <textarea id="author-name" name="description" class="author-name" required></textarea><br>
                        </div>

                        <button type="submit" name="submit" class="btn submit-button" onclick="submit()">Submit</button>
                    </div>


                </div>

       </div>
    </div>

    <div class="col-md-2 col-lg-2"></div>

</div>

<script src="public/js/authorlistScript.js"></script>
</body>
</html>