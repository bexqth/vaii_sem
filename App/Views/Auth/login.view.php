<?php

$layout = 'root';
/** @var Array $data */
/** @var \App\Core\LinkGenerator $link */
?>

<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Prihlásenie</h5>
                    <div class="text-center text-danger mb-3">
                        <?= @$data['message'] ?>
                    </div>
                    <form class="form-signin" method="post" action="<?= $link->url("login") ?>">
                        <div class="form-label-group mb-3">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                        </div>

                        <div class="form-label-group mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required> </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary" type="submit" name="submit">Prihlásiť
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
