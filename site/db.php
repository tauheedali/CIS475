<?php require_once('partials/header.php'); ?>
<?php if (isset($_POST['submit'])) {
    // setup connection
    $conn = dbConnect();
    // call your function to drop and create the table
    $success = dbCreate($conn);
    if ($success) {
        // call your function to read the cda216_io.txt file
        fileRead();
        // call your function to populate the table (insert the data)
        dbInsert($conn);
        $successMessage = 'Months have been imported';
    } else {
        echo $conn->error;
    }
    // close the database connection
    $conn->close();
}
$title = 'Create and Populate a MySQL Table';
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
        <div class="row">
            <div class="col-12 text-center">
                <?php if (isset($successMessage)): ?>
                    <b><?= $successMessage; ?></b>
                <?php endif; ?>
                <form id="myForm" name="myForm" method="POST" class="text-center" action="<?= $_SERVER['PHP_SELF']; ?>">
                    <button type="submit" name="submit" value="submit" class="btn btn-lg btn-primary" style="padding: 20px">Import Months</button>
                </form>
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
                    <li><a href="download.php?file=db.php">db.php</a></li>
                    <li><a href="download.php?file=images/db.png">db.png</a></li>
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

