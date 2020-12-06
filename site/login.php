<?php
require_once('partials/header.php');
$title = 'Create a User Login Site';
$assignment = getAssignmentByName($title);

use CIS475\Services\Auth;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validationErrors = Auth::validate($_POST);
    if (empty($validationErrors)) {
        $result = Auth::login($_POST['email'], $_POST['password']);
        redirect('admin.php');
    }
}
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
            <div class="col-12" id="login-form">
                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                    <?php if (empty($validationErrors) && !$result->error): ?>
                        <div class="text-center"><b><?= $result->message; ?></b></div>
                    <?php elseif (!empty($validationErrors) || $result->error): ?>
                        <div class="text-center">
                            <b>ERROR</b>
                            <?= implode('', $validationErrors); ?>
                            <p><?= $result->message; ?></p>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <form id="user-login" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
                        <div>
                            <label>Username</label>
                            <input type="text" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>" required/>
                        </div>
                        <div>
                            <label>Password</label>
                            <input type="password" name="password" value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>" required/>
                        </div>
                        <div>
                            <button type="submit">Submit</button>
                        </div>
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
                    <li><a href="download.php?file=login.php">login.php</a></li>
                    <li><a href="download.php?file=includes/Classes/User.php">User.php</a></li>
                    <li><a href="download.php?file=includes/Services/Auth.php">Auth.php</a></li>
                    <li><a href="download.php?file=includes/Classes/Database.php">Database.php</a></li>
                    <li><a href="download.php?file=index.php">index.php</a></li>
                    <li><a href="download.php?file=partials/header.php">header.php</a></li>
                    <li><a href="download.php?file=partials/footer.php">footer.php</a></li>
                    <li><a href="download.php?file=autoload.php">autoload.php</a></li>
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

