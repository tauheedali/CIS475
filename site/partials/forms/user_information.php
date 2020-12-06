<?php use CIS475\Classes\Address;
?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary" href="<?= $baseUrl; ?>admin.php"><< Back</a>
    </div>
</div>
<div id="user-information-form">
    <form id="user-information" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
        <? if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <input type="hidden" id="action" name="action" value="<?= $_POST['action']; ?>"/>
            <input type="hidden" id="action" name="id" value="<?= $_POST['id']; ?>"/>
        <?php endif; ?>
        <? if ($_SERVER['REQUEST_METHOD'] === 'GET'): ?>
            <input type="hidden" id="action" name="action" value="<?= $_GET['action']; ?>"/>
            <input type="hidden" id="action" name="id" value="<?= $_GET['id']; ?>"/>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6">
                <label>First Name</label>
                <input type="text" name="firstName" value="<?= $user->firstName; ?>" required/>
            </div>
            <div class="col-md-5">
                <label>Last Name</label>
                <input type="text" name="lastName" value="<?= $user->lastName; ?>" required/>
            </div>
            <?php if ($_SESSION['isAdmin']): ?>
                <div class="col-md-1">
                    <label>Admin</label>
                    <input type="checkbox" name="isAdmin" <?= $user->isAdmin ? 'checked' : ''; ?> />
                </div>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label>Address</label>
                <input type="text" name="address" value="<?= $user->address; ?>" required/>
            </div>
            <div class="col-md-4">
                <label>City</label>
                <input type="text" name="city" value="<?= $user->city; ?>" required/>
            </div>
            <div class="col-md-4">
                <label>State</label>
                <select name="state" required>
                    <option value=""> -- Select a State --</option>
                    <?php foreach (Address::getStates() as $code => $state): ?>
                        <option value="<?= $code; ?>" <?= $user->state == $code ? 'selected' : ''; ?>><?= $state; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label>Zip</label>
                <input type="text" name="zipCode" value="<?= $user->zipCode; ?>" required/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Phone</label>
                <input type="text" name="phone" value="<?= $user->phone; ?>" required/>
            </div>
            <div class="col-md-6">
                <label>Email</label>
                <input type="email" name="email" value="<?= $user->email; ?>" required/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Password</label>
                <input type="password" name="password" value="" <?= $_GET['action'] === 'create' ? 'required' : ''; ?>/>
            </div>
            <div class="col-md-6">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" value="" <?= $_GET['action'] === 'create' ? 'required' : ''; ?>/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
    </form>
</div>
<script>
document.getElementById('user-information').addEventListener('submit', validateForm);

function validateForm(e) {
    const password = document.getElementsByName('password')[0].value;
    const passwordConfirmation = document.getElementsByName('password_confirmation')[0].value;
    const action = document.getElementsByName('action')[0].value;
    let errorMessage = null;
    for (const element of document.getElementsByClassName('form-error')) {
        element.parentNode.removeChild(element);
    }
    if (passwordConfirmation === password) {
        if (action === 'create') {
            const strongPassword = /^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,}$/g;

            if (!password.match(strongPassword)) {
                errorMessage = 'Password must contain 1 Uppercase letter, 1 Lowercase letter, 1 Number, 1 Symbol and be at least 8 characters long';
            }
        }
    } else {
        errorMessage = 'Passwords do not match';
    }
    if (errorMessage) {
        let errorTemplate = document.createElement('div');
        errorTemplate.classList = 'text-center form-error';
        errorTemplate.innerHTML = `<b>ERROR</b><p>${errorMessage}</p>`;
        document.querySelector('#user-information-form').prepend(errorTemplate);
        e.preventDefault();
    }
}
</script>
