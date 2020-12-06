<?php
require_once('partials/header.php');
$title = 'Create a PHP Form That Populates a MySQL Database';
$assignment = getAssignmentByName($title);
session_start();
?>
<section id="header">
    <div class="container">
        <div class="row d-block">
            <div class="col-12">
                <h1 class="page-title"><?= $title; ?></h1>
                <h3>Due: <?= $assignment['due_date']; ?>, <?= getAssignmentStatus($assignment['due_date']); ?></h3>
            </div>
        </div>
    </div>
</section>
<main id="main">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="text-center"><?= $_SESSION['success']; ?></div>
                <?php else: ?>
                    <?php if (isset($_SESSION['errors'])): ?>
                        <div class="text-center">
                            <b>ERROR</b>
                            <?= $_SESSION['errors']; ?>
                        </div>
                    <?php endif; ?>
                    <form novalidate method="post" action="processform.php">
                        <div>
                            <label>First Name</label>
                            <input type="text" name="firstName" maxlength="15"/>
                        </div>
                        <div>
                            <label>Last Name</label>
                            <input type="text" name="lastName" maxlength="30"/>
                        </div>
                        <div>
                            <label>Address</label>
                            <input type="text" name="address" maxlength="30"/>
                        </div>
                        <div>
                            <label>City</label>
                            <input type="text" name="city" maxlength="15"/>
                        </div>
                        <div>
                            <label>State</label>
                            <input type="text" name="state" maxlength="2"/>
                        </div>
                        <div>
                            <label>Zip</label>
                            <input type="text" name="zipCode" maxlength="10"/>
                        </div>
                        <div>
                            <label>Phone</label>
                            <input type="text" name="phone" maxlength="10"/>
                        </div>
                        <div>
                            <label>Email</label>
                            <input type="email" name="email" maxlength="60"/>
                        </div>
                        <div>
                            <label>Comments</label>
                            <textarea name="comments" style="width: 100%;height: 150px"></textarea>
                        </div>
                        <div>
                            <button type="submit">Submit</button>
                        </div>
                    </form>
                <?php endif; ?>
                <?php session_unset(); ?>
            </div>
        </div>
    </div>
</main>
<section id="files">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Files Used</h3>
            </div>
            <div class="col-12">
                <ol>
                    <li><a href="download.php?file=index.php">index.php</a></li>
                    <li><a href="download.php?file=partials/header.php">header.php</a></li>
                    <li><a href="download.php?file=partials/footer.php">footer.php</a></li>
                    <li><a href="download.php?file=php_mysql_form.php">php_mysql_form.php</a></li>
                    <li><a href="download.php?file=processform.php">processform.php</a></li>
                    <li><a href="download.php?file=includes/config.php">config.php</a></li>
                    <li><a href="download.php?file=includes/vars.php">vars.php</a></li>
                    <li><a href="download.php?file=includes/functions.php">functions.php</a></li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section id="projects">
    <div class="container">
        <h2>What I'm Working On</h2>
        <hr/>
        <?php displayAssignments(); ?>
    </div>
</section>
<?php require_once('partials/footer.php'); ?>

