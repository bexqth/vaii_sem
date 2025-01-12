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
    <title>Profile</title>
    <link href="public/css/settingspageStyle.css" rel="stylesheet">
</head>

<body>

<div class="row">
    <div class="col-md-4 col-lg-4"></div>

    <div class="col-sm-12 col-md-4 col-lg-4 form-col">

        <div id="successMessage" class="alert alert-success" style="display: none;">
        </div>

        <div id="errorMessage" class="alert alert-danger" style="display: none;">
        </div>

        <div class="row form-container">
            <div>
                <div class="row">
                    <label for="about_text">About</label>
                </div>
                <div class="row">
                    <textarea id="about_text" name="about_text" class="about-text" required><?= $data["profile"]->getBio()?></textarea>
                </div>
            </div>

            <div>
                <h5>Profile picture</h5>
                <p>Allowed Formats: JPEG, PNG. Optimal dimensions: 230x230</p>

                <div class="row profile-picture-row">
                    <div class="col">
                        <div id="drop-zone-profile-picture" class="drop-zone-profile-picture">Drop an image here</div>
                    </div>
                    <div class="col">
                        <?php if ($data['profile']->getProfilePicture() == null) :?>
                            <img id="profile-picture" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" class="profile-picture" alt="...">
                        <?php else : ?>
                            <img id="profile-picture" src="<?= $data["profile"]->getProfilePicture()?>" class="profile-picture" alt="...">
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div>
                <h5>Banner</h5>
                <p>Allowed Formats: JPEG, PNG. Optimal dimensions: 1700x330</p>

                <div class="row profile-banner-row">
                    <div>
                        <div id="drop-zone-banner" class="drop-zone-banner-picture">Drop an image here</div>
                    </div>
                    <div class="current-banner">
                        <?php if ($data['profile']->getBannerPicture() == null) :?>
                            <img id="banner-image" src="https://live.staticflickr.com/3678/8986672784_bbf77b2aeb_b.jpg" class="banner-image" alt="...">
                        <?php else : ?>
                            <img id="banner-image" src="<?= $data["profile"]->getBannerPicture()?>" class="banner-image" alt="...">
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <button type="submit" name="submit" class="btn submit-button" onclick="sendFormData()">Submit</button>
            </div>
        </div>

    <div class="col-md-4 col-lg-4"></div>


    <script src="public/js/settingsScript.js"></script>
</body>

</html>