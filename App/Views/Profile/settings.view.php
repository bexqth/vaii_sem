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

        <div class="row form-container">

            <form action="" method="post">
                <div>
                    <div class="row">
                        <label for="about_text">About</label>
                    </div>
                    <div class="row">
                        <textarea id="about_text" name="about_text" class="about-text" required></textarea><br>
                    </div>

                </div>

                <div>
                    <h5>Profile picture</h5>
                    <p>Allowed Formats: JPEG, PNG. Max size: 3mb. Optimal dimensions: 230x230</p>

                    <div class="row">
                        <div class="col">

                        </div>

                        <div class="col">
                            <img src="https://i.pinimg.com/736x/e4/60/b6/e460b6c769d4d8ec53a17990ec1398a3.jpg" class="profile-picture" alt="...">
                        </div>

                    </div>
                </div>

                <div>
                    <h5>Banner</h5>
                    <p>Allowed Formats: JPEG, PNG. Max size: 6mb. Optimal dimensions: 1700x330</p>

                    <div class="row">
                        <div class="col">

                        </div>

                        <div class="col">
                            <img src="https://i.pinimg.com/736x/59/6e/d1/596ed169ce00d8a7c611c93c92d66b37.jpg" class="banner-image" alt="...">
                        </div>

                    </div>
                </div>

                <div class="row">
                    <button type="submit" name="submit" class="btn submit-button">Submit</button>
                </div>
            </form>

        </div>

    </div>

    <div class="col-md-4 col-lg-4"></div>

</body>
</html>