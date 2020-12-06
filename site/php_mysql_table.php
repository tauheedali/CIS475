<?php
require_once('partials/header.php');
$title = 'Create an HTML/PHP Table From a MySQL Table';
$assignment = getAssignmentByName($title);
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
                <h2>My approach to this assignment</h2>
                <p>For this assignment, I decided to create a display function called <code>getMonthsTable</code>
                    that handled the entire process of fetching from the MYSQL database then rendering the HTML table from the result.
                    As a personal preference, I used shorthand PHP echo tags <code><?= htmlentities('<?= ?>'); ?></code> and toggled in and out of PHP by using the alternate control structure notation. I prefer this
                    coding style because I think that it makes the code more readable than accumulating a string or having <code>echo</code> statements for each line.
                </p>
                <p>To decide the color of each row, I assigned the color of each row by adding the appropriate classes with the ternary operator: <br/>
                    <code><?= htmlentities("<tr class=\"<?= \$index % 2 == 0 ? 'bg-light text-dark' : 'bg-secondary text-white'; ?>\">"); ?></code><br/>
                    As with my other preferences, I believe that this approach helps to keep the code concise and the HTML easy to read.
                </p>
                <em> - Tauheed</em>
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
                    <li><a href="download.php?file=php_mysql_table.php">php_mysql_table.php</a></li>
                    <li><a href="download.php?file=includes/vars.php">vars.php</a></li>
                    <li><a href="download.php?file=includes/functions.php">functions.php</a></li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section id="months">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php getMonthsTable(); ?>
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

