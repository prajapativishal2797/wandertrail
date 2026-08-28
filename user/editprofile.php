<?php
require_once __DIR__ . '/config.php';
require_login('../login.php', 'user');
$user = current_user_email();
$errors = [];
if (is_post()) {
    csrf_require();
    $firstName = request_string('first_name');
    $middleName = request_string('middle_name');
    $lastName = request_string('last_name');
    $address = request_string('address');
    $contact = request_string('contact_no');
    if ($firstName === '' || $lastName === '') {
        $errors[] = 'First and last name are required.';
    }
    if (!valid_phone($contact)) {
        $errors[] = 'Enter a valid contact number.';
    }
    if ($address === '') {
        $errors[] = 'Address is required.';
    }
    if (!$errors) {
        db_execute($con, 'UPDATE tbl_register SET first_name=?,middle_name=?,last_name=?,address=?,contact_no=? WHERE email_id=? AND isdeleted=0', [$firstName, $middleName, $lastName, $address, $contact, $user]);
        flash_success('Your profile has been updated.');
        redirect('editprofile.php');
    }
}
$profile = db_one($con, 'SELECT * FROM tbl_register WHERE email_id=? AND isdeleted=0 LIMIT 1', [$user]);
$userPageTitle = 'Edit profile | WanderTrail';
require __DIR__ . '/header.php';
?>
<section class="eg-account-page">
    <div class="eg-account-form-shell">
        <div class="eg-account-form-heading"><p>Account settings</p>
            <h1>Edit your profile</h1><span>Keep your contact details current for booking confirmations.</span></div>
        <?= flash_render() ?><?php foreach ($errors as $error): ?>
            <div class="eg-alert eg-alert-danger"><?= e($error) ?></div><?php endforeach; ?>
        <form method="post" class="eg-account-form"><?= csrf_field() ?>
            <div class="eg-form-grid">
                <label>First name<input name="first_name"
                                        value="<?= e($_POST['first_name'] ?? $profile['first_name']) ?>"
                                        required></label><label>Middle name<input name="middle_name"
                                                                                  value="<?= e($_POST['middle_name'] ?? $profile['middle_name']) ?>"></label><label>Last
                    name<input name="last_name" value="<?= e($_POST['last_name'] ?? $profile['last_name']) ?>" required></label>
                <label class="wide">Email address<input type="email" value="<?= e($profile['email_id']) ?>"
                                                        disabled></label><label class="wide">Contact number<input
                            name="contact_no" inputmode="numeric"
                            value="<?= e($_POST['contact_no'] ?? $profile['contact_no']) ?>" required></label><label
                        class="wide">Address<textarea name="address" rows="4"
                                                      required><?= e($_POST['address'] ?? $profile['address']) ?></textarea></label>
            </div>
            <div class="eg-form-actions">
                <button type="submit">Save changes</button>
                <a href="changepassword.php">Change password</a><a href="deactiveaccount.php">Deactivate account</a>
            </div>
        </form>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
