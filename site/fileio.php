<?php
require_once('partials/header.php');
$title = 'Create a PHP Page That Reads and Writes a File';
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
                <?php if (isset($_POST['submit'])): ?>
                    <table>
                        <thead>
                        <tr>
                            <th>Number</th>
                            <th>Name</th>
                            <th>Days</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach (readTextFile() as $key =>$month): ?>
                            <tr class="<?= $key % 2 ? 'bg-info text-white': 'odd text-dark';?>">
                                <td><?= $month['monthNumber']; ?></td>
                                <td><?= $month['monthName']; ?></td>
                                <td><?= $month['monthDays']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <form id="myForm" name="myForm" method="POST" class="text-center" action="<?= $_SERVER['PHP_SELF']; ?>">
                        <button type="submit" name="submit" value="submit" class="btn btn-lg btn-primary" style="padding: 20px">Import Months</button>
                    </form>
                <?php endif; ?>
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
                    <li><a href="download.php?file=fileio.php">fileio.php</a></li>
                    <li><a href="download.php?file=cis475_ior.txt">cis475_ior.txt</a></li>
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

