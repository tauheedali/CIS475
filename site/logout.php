<?php
require_once('partials/header.php');

use CIS475\Services\Auth;

Auth::logout();
?>
<main id="main">
    <div class="container">
        <div class="row d-block">
            <div class="col-12">
                <h3>You've been logged out successfully.</h3>
            </div>
        </div>
    </div>
</main>
<?php require_once('partials/footer.php'); ?>

