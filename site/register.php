<?php
require_once('partials/header.php');
$title = 'Create a User Registration Site';
$assignment = getAssignmentByName($title);

use CIS475\Classes\User;
use CIS475\Classes\Address;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = User::validate($_POST);
    if (empty($errors)) {
        $user = new User();
        $user->email = $_POST['email'];
        $user->password = sha1($_POST['password']);
        $user->firstName = $_POST['firstName'];
        $user->lastName = $_POST['lastName'];
        $user->phone = $_POST['phone'];
        $user->address = $_POST['address'];
        $user->zipCode = $_POST['zipCode'];
        $user->city = $_POST['city'];
        $user->state = $_POST['state'];
        $user->isAdmin = FALSE;
        $user->registrationDate = date('Y-m-d h:i:s');
        $user->save();
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
            <div class="col-12" id="registration-form">
                <?php if (empty($errors) && $_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                    <div class="text-center"><b>Thanks for registering!</b></div>
                <?php else: ?>
                    <?php if (!empty($errors)): ?>
                        <div class="text-center">
                            <b>ERROR</b>
                            <?= implode('', $errors); ?>
                        </div>
                    <?php endif; ?>
                    <form id="user-registration" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
                        <div>
                            <label>First Name</label>
                            <input type="text" name="firstName" value="<?= $_POST['firstName']; ?>" required/>
                        </div>
                        <div>
                            <label>Last Name</label>
                            <input type="text" name="lastName" value="<?= $_POST['lastName']; ?>" required/>
                        </div>
                        <div>
                            <label>Address</label>
                            <input type="text" name="address" value="<?= $_POST['address']; ?>" required/>
                        </div>
                        <div>
                            <label>City</label>
                            <input type="text" name="city" value="<?= $_POST['city']; ?>" required/>
                        </div>
                        <div>
                            <label>State</label>
                            <select name="state" required>
                                <option value=""> -- Select a State --</option>
                                <?php foreach (Address::getStates() as $code => $state): ?>
                                    <option value="<?= $code; ?>" <?= $_POST['state'] == $code ? 'selected' : ''; ?>><?= $state; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label>Zip</label>
                            <input type="text" name="zipCode" value="<?= $_POST['zipCode']; ?>" required/>
                        </div>
                        <div>
                            <label>Phone</label>
                            <input type="text" name="phone" value="<?= $_POST['phone']; ?>" required/>
                        </div>
                        <div>
                            <label>Email</label>
                            <input type="email" name="email" value="<?= $_POST['email']; ?>" required/>
                        </div>
                        <div>
                            <label>Password</label>
                            <input type="password" name="password" value="" required/>
                        </div>
                        <div>
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" value="" required/>
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
                    <li><a href="download.php?file=register.php">register.php</a></li>
                    <li><a href="download.php?file=includes/Classes/User.php">User.php</a></li>
                    <li><a href="download.php?file=includes/Classes/Address.php">Address.php</a></li>
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
<script>
let registrationForm = document.getElementById('user-registration');
registrationForm.addEventListener('submit', validateForm);

function validateForm(e) {
    const password = document.getElementsByName('password')[0].value;
    const passwordConfirmation = document.getElementsByName('password_confirmation')[0].value;
    let errorMessage = null;
    for (const element of document.getElementsByClassName('form-error')) {
        element.parentNode.removeChild(element);
    }
    if (passwordConfirmation === password) {
        const strongPassword = /^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,}$/g;

        if (!password.match(strongPassword)) {
            errorMessage = 'Password must contain 1 Uppercase letter, 1 Lowercase letter, 1 Number, 1 Symbol and be at least 8 characters long';
        }
    } else {
        errorMessage = 'Passwords do not match';
    }
    if (errorMessage) {
        let errorTemplate = document.createElement('div');
        errorTemplate.classList = 'text-center form-error';
        errorTemplate.innerHTML = `<b>ERROR</b><p>${errorMessage}</p>`;
        document.querySelector('#registration-form').prepend(errorTemplate);
        e.preventDefault();
    }
}
</script>
<?php require_once('partials/footer.php'); ?>

