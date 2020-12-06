<?php
require_once('partials/header.php');
$title = 'Create an Admin Web Site';
$assignment = getAssignmentByName($title);

use CIS475\Services\Auth;
use CIS475\Classes\User;

if (!Auth::verifyLogin()) {
    redirect($baseUrl . "login.php");
}
$user = new User();
if (!empty($_GET['id'])) {
    $existingUser = User::find($_GET['id']);
    if ($existingUser) {
        $user = $existingUser;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $user = new User();
    if (!empty($_POST['id'])) {
        $existingUser = User::find($_POST['id']);
        if ($existingUser) {
            $user = $existingUser;
        }
    }
    $user->email = $_POST['email'];
    $user->firstName = $_POST['firstName'];
    $user->lastName = $_POST['lastName'];
    $user->phone = $_POST['phone'];
    $user->address = $_POST['address'];
    $user->zipCode = $_POST['zipCode'];
    $user->city = $_POST['city'];
    $user->state = $_POST['state'];
    //Only allow Admin users to update admin status
    if ($_SESSION['isAdmin']) {
        $user->isAdmin = isset($_POST['isAdmin']);
    }
    switch ($_POST['action']) {
        case 'create':
            $errors = User::validate($_POST);
            if (empty($errors)) {
                $user->password = sha1($_POST['password']);
                $user->save();
                $success = "User created successfully.";
            }
            break;
        case 'edit':
            $errors = User::validate($_POST, FALSE);
            if (empty($errors)) {
                if (isset($_POST['password'])) {
                    $user->password = sha1($_POST['password']);
                }
                $user->save();
                $success = "User updated successfully.";
            }
            break;
        case 'delete':
            if (isset($_POST['id'])) {
                $user = User::find($_POST['id']);
                if ($user) {
                    $user->delete();
                }
                $success = "User deleted successfully.";
            }
            break;
    }
}
//Define which states will display user info form
$userInfoViews = [
    isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id']), //Edit screen
    isset($_GET['action']) && $_GET['action'] === 'create', //New user screen
    isset($_POST['action']) && $_POST['action'] === 'create' && !empty($errors), //Create User Validation error
    isset($_POST['action']) && $_POST['action'] === 'edit' && isset($_POST['id']) && !empty($errors), //Edit User Validation error
];
?>
<main id="main">
    <div class="container">
        <div class="row d-block">
            <div class="col-12 text-center">
                <h1 class="page-title"><?= $title; ?></h1>
                <h3>Due: <?= $assignment['due_date']; ?>, <?= getAssignmentStatus($assignment['due_date']); ?></h3>
            </div>
        </div>
        <?php if (!empty($errors)): ?>
            <div class="text-center">
                <b>ERROR</b>
                <?= implode('', $errors); ?>
            </div>
        <?php elseif (!empty($success)): ?>
            <div class="text-center">
                <b><?= $success; ?></b>
            </div>
        <?php endif; ?>
        <?php if (in_array(TRUE, $userInfoViews)): ?>
            <?php include 'partials/forms/user_information.php'; ?>
        <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <div>
                        <a href="admin.php?action=create" class="btn btn-primary">Add User</a>
                        <a href="export_users.php" class="btn btn-primary">Export</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <table>
                    <thead>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Last Login</th>
                    <th>Registration Date</th>
                    <th>Is Admin</th>
                    <th class="text-center">Action</th>
                    </thead>
                    <tbody>
                    <?php foreach (User::all() as $user): ?>
                        <tr>
                            <td><?= "$user->lastName, $user->firstName"; ?></td>
                            <td><?= $user->address; ?></td>
                            <td><?= $user->email; ?></td>
                            <td><?= $user->phone; ?></td>
                            <td><?= date('Y-m-d H:i'); ?></td>
                            <td><?= date('Y-m-d H:i'); ?></td>
                            <td><?= $user->isAdmin ? 'Yes' : 'No'; ?></td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center">
                                    <a class="btn btn-primary" href="admin.php?action=edit&id=<?= $user->id; ?>">Mod</a>
                                    <form method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
                                        <input type="hidden" name="action" value="delete"/>
                                        <input type="hidden" name="id" value="<?= $user->id; ?>"/>
                                        <button class="btn btn-danger" type="submit">Del</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</main>
<section id="files">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Files Used</h3>
                <p>There are a lot of files associated with this project. It may be easier to <a href="https://github.com/tauheedali/CIS475" target="_blank">Download project from Github</a></p>
            </div>
            <div class="col-12">
                <ol>
                    <li><a href="download.php?file=update_user_model.php">update_user_model.php</a></li>
                    <li><a href="download.php?file=admin.php">admin.php</a></li>
                    <li><a href="download.php?file=login.php">login.php</a></li>
                    <li><a href="download.php?file=logout.php">logout.php</a></li>
                    <li><a href="download.php?file=export_users.php">export_users.php</a></li>
                    <li><a href="download.php?file=includes/Classes/CSVWriter.php">CSVWriter.php</a></li>
                    <li><a href="download.php?file=partials/forms/user_information.php">user_information.php</a></li>
                    <li><a href="download.php?file=includes/Classes/Phone.php">Phone.php</a></li>
                    <li><a href="download.php?file=includes/Classes/Address.php">Address.php</a></li>
                    <li><a href="download.php?file=includes/Classes/Person.php">Person.php</a></li>
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

