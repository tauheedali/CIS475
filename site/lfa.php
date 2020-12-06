<?php
require_once('partials/header.php');
$title = 'Create a PHP Page That Uses Loops, Functions and Arrays';
$assignment = getAssignmentByName($title);
?>
<main id="main">
    <div class="container">
        <div class="row d-block">
            <div class="col-12 text-center">
                <h1 class="page-title"><?= $title; ?></h1>
                <h3>Due: <?= $assignment['due_date']; ?>, <?= getAssignmentStatus($assignment['due_date']); ?></h3>
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
                    <li><a href="download.php?file=lfa.php">lfa.php</a></li>
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

