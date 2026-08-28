<?php
global $pg;
$pg = 0;
include('header.php');
include('config.php');

if (is_logged_in()) {
    header('Location: ' . (current_user_role() === 'admin' ? 'admin/index.php' : 'user/index.php'));
    exit;
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnregister'])) {
    csrf_require();

    $firstName = trimmed($_POST['first_name'] ?? '');
    $middleName = trimmed($_POST['middle_name'] ?? '');
    $lastName = trimmed($_POST['last_name'] ?? '');
    $email = trimmed($_POST['email_id'] ?? '');
    $address = trimmed($_POST['address'] ?? '');
    $contactNo = trimmed($_POST['contact_no'] ?? '');

    if ($firstName === '' || $lastName === '') {
        $errors[] = 'Please enter your first and last name.';
    }
    if (!valid_email($email)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if ($address === '' || strlen($address) > 250) {
        $errors[] = 'Please enter your address (up to 250 characters).';
    }
    if (!valid_phone($contactNo)) {
        $errors[] = 'Please enter a valid 10-digit contact number.';
    }

    $idProofPath = '';
    if (!empty($_FILES['id_proof']['name'])) {
        $upload = safe_upload(
                $_FILES['id_proof'],
                __DIR__ . '/storage/uploads/users',
                'storage/uploads/users',
                UPLOAD_ALLOWED_DOCUMENT_MIME
        );
        if (!$upload['ok']) {
            $errors[] = $upload['error'];
        } else {
            $idProofPath = $upload['path'];
        }
    } else {
        $errors[] = 'Please attach an ID proof document (JPG, PNG or PDF).';
    }

    if (empty($errors)) {
        if (email_is_registered($con, $email)) {
            $errors[] = 'This email address is already registered. Try logging in instead.';
        } else {
            $stmt = $con->prepare('SELECT user_id FROM tbl_register WHERE email_id = ? AND isdeleted = 0 LIMIT 1');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $pending = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if ($pending) {
                $errors[] = 'This email address already has a pending registration awaiting admin approval.';
            } else {
                $stmt = $con->prepare(
                        'INSERT INTO tbl_register (first_name, middle_name, last_name, email_id, address, contact_no, id_proof, create_date, isactive, isdeleted) '
                        . 'VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), 1, 0)'
                );
                $stmt->bind_param('sssssss', $firstName, $middleName, $lastName, $email, $address, $contactNo, $idProofPath);
                if ($stmt->execute()) {
                    $success = true;
                } else {
                    $errors[] = 'Registration could not be saved. Please try again.';
                }
                $stmt->close();
            }
        }
    }
}
?>
<section style="background-image:url('assets/site/pic/breadcrumbs/bg-1.jpg');" class="breadcrumbs">
    <div class="container">
        <div class="text-left breadcrumbs-item"><a href="index.php">home</a><i>/</i><a href="" class="last"><span>Register</span></a>
            <h2><span>Create</span> your account</h2>
        </div>
    </div>
</section>

<div class="eg-page eg-auth-shell">
    <div class="eg-card eg-auth-card eg-auth-card--wide">
        <span class="eg-auth-eyebrow">WanderTrail</span>
        <h1 class="eg-auth-title">Register</h1>
        <p class="eg-auth-subtitle">Registrations are reviewed by our team; you'll receive an email with your login
            details once approved.</p>

        <?php if ($success): ?>
            <div class="eg-alert eg-alert-success" role="alert">
                Thank you for registering! Your account is pending admin verification. You'll receive an email with your
                login details once it's approved.
            </div>
            <p class="eg-text-center"><a class="eg-btn eg-btn-outline" href="index.php">Back to home</a></p>
        <?php else: ?>
            <?php foreach ($errors as $error): ?>
                <div class="eg-alert eg-alert-danger" role="alert"><?php echo h($error); ?></div>
            <?php endforeach; ?>

            <form method="post" enctype="multipart/form-data" novalidate>
                <?php echo csrf_field(); ?>

                <div class="eg-auth-row">
                    <div class="eg-field">
                        <label class="eg-label" for="first_name">First name</label>
                        <input class="eg-input" type="text" id="first_name" name="first_name"
                               value="<?php echo old('first_name'); ?>" required>
                    </div>
                    <div class="eg-field">
                        <label class="eg-label" for="middle_name">Middle name</label>
                        <input class="eg-input" type="text" id="middle_name" name="middle_name"
                               value="<?php echo old('middle_name'); ?>">
                    </div>
                </div>

                <div class="eg-field">
                    <label class="eg-label" for="last_name">Last name</label>
                    <input class="eg-input" type="text" id="last_name" name="last_name"
                           value="<?php echo old('last_name'); ?>" required>
                </div>

                <div class="eg-field">
                    <label class="eg-label" for="email_id">Email address</label>
                    <input class="eg-input" type="email" id="email_id" name="email_id"
                           value="<?php echo old('email_id'); ?>" required>
                </div>

                <div class="eg-field">
                    <label class="eg-label" for="address">Address</label>
                    <textarea class="eg-input" id="address" name="address" rows="3" maxlength="250"
                              required><?php echo old('address'); ?></textarea>
                </div>

                <div class="eg-field">
                    <label class="eg-label" for="contact_no">Contact number</label>
                    <input class="eg-input" type="tel" id="contact_no" name="contact_no"
                           value="<?php echo old('contact_no'); ?>" pattern="\d{10}"
                           placeholder="10-digit mobile number" required>
                </div>

                <div class="eg-field">
                    <label class="eg-label" for="id_proof">ID proof (JPG, PNG or PDF, up to 10MB)</label>
                    <input class="eg-input" type="file" id="id_proof" name="id_proof" accept=".jpg,.jpeg,.png,.pdf"
                           required>
                </div>

                <button type="submit" name="btnregister" class="eg-btn eg-btn-primary eg-btn-block">Register</button>
            </form>

            <p class="eg-auth-footer">Already have an account? <a href="login.php">Log in here</a></p>
        <?php endif; ?>
    </div>
</div>

<?php include('footer.php'); ?>
