<?php
require_once __DIR__ . '/config.php';
$errors = [];
$submitted = false;
$type = (string)($_GET['type'] ?? $_POST['enquiry_type'] ?? 'custom_trip');
if (!in_array($type, ['general', 'destination', 'hotel', 'package', 'custom_trip'], true)) {
    $type = 'custom_trip';
}
$referenceId = (int)($_GET['id'] ?? $_POST['reference_id'] ?? 0);
$account = null;
if (is_logged_in() && current_user_role() === 'user') {
    $account = db_one($con, 'SELECT user_id,first_name,last_name,email_id,contact_no FROM tbl_register WHERE email_id=? AND isdeleted=0 LIMIT 1', [current_user_email()]);
}
if (is_post()) {
    csrf_require();
    $name = request_string('customer_name');
    $email = request_string('email');
    $phone = request_string('phone');
    $destination = request_string('destination');
    $start = request_string('travel_start');
    $end = request_string('travel_end');
    $adults = max(1, request_int('adults', 1, 'post'));
    $children = max(0, request_int('children', 0, 'post'));
    $budget = request_string('budget');
    $message = request_string('message');
    if ($name === '') $errors[] = 'Please enter your name.';
    if (!valid_email($email)) $errors[] = 'Enter a valid email address.';
    if (!valid_phone($phone)) $errors[] = 'Enter a valid phone number.';
    if ($start !== '' && $end !== '' && $end < $start) $errors[] = 'Return date must be after the travel start date.';
    if (!$errors) {
        db_execute($con, 'INSERT INTO tbl_travel_enquiry (user_id,enquiry_type,reference_id,customer_name,email,phone,destination,travel_start,travel_end,adults,children,budget,message) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)', [$account['user_id'] ?? null, $type, $referenceId ?: null, $name, $email, $phone, $destination, $start ?: null, $end ?: null, $adults, $children, $budget !== '' ? (float)$budget : null, $message]);
        $submitted = true;
    }
}
$egPageTitle = 'Plan a trip | WanderTrail';
require __DIR__ . '/header.php';
?>
<section class="eg-page-hero">
    <div class="eg-section-inner"><p class="eg-kicker">Talk to a travel specialist</p>
        <h1>Let us shape your perfect journey.</h1>
        <p>Share your dates, interests and budget. Our travel team can suggest stays, transport and an itinerary that
            fits.</p></div>
</section>
<section class="eg-enquiry-section">
    <div class="eg-section-inner eg-enquiry-layout">
        <div><p class="eg-kicker eg-kicker--dark">Personal planning</p>
            <h2>Request a travel plan</h2>
            <p>We usually respond during agency business hours. Submitting this form does not create a paid booking.</p>
            <ul>
                <li>Custom itinerary suggestions</li>
                <li>Hotel and package availability</li>
                <li>Group, family and corporate travel</li>
                <li>Local guides and transport coordination</li>
            </ul>
        </div>
        <div class="eg-enquiry-card">
            <?php if ($submitted): ?>
                <div class="eg-enquiry-success"><i class="fa fa-check"></i>
                    <h2>Enquiry received</h2>
                    <p>Our travel team will contact you using the details provided.</p><a href="packages.php">Continue
                        exploring</a></div><?php else: ?><?php foreach ($errors as $error): ?>
                <div class="eg-alert eg-alert-danger"><?= e($error) ?></div><?php endforeach; ?>
                <form method="post"><?= csrf_field() ?><input type="hidden" name="enquiry_type" value="<?= e($type) ?>">
                <input type="hidden" name="reference_id" value="<?= $referenceId ?>">
                <div class="eg-enquiry-grid"><label>Your name<input name="customer_name"
                                                                    value="<?= e($_POST['customer_name'] ?? ($account ? trim($account['first_name'] . ' ' . $account['last_name']) : '')) ?>"
                                                                    required></label><label>Email address<input
                                type="email" name="email"
                                value="<?= e($_POST['email'] ?? ($account['email_id'] ?? '')) ?>"
                                required></label><label>Phone number<input name="phone"
                                                                           value="<?= e($_POST['phone'] ?? ($account['contact_no'] ?? '')) ?>"
                                                                           required></label><label>Destination or
                        interests<input name="destination" value="<?= e($_POST['destination'] ?? '') ?>"
                                        placeholder="Ahmedabad, Kutch, wildlife..."></label><label>Travel start<input
                                type="date" name="travel_start"
                                value="<?= e($_POST['travel_start'] ?? '') ?>"></label><label>Travel end<input
                                type="date" name="travel_end"
                                value="<?= e($_POST['travel_end'] ?? '') ?>"></label><label>Adults<input type="number"
                                                                                                         min="1"
                                                                                                         max="50"
                                                                                                         name="adults"
                                                                                                         value="<?= e($_POST['adults'] ?? '1') ?>"></label><label>Children<input
                                type="number" min="0" max="50" name="children"
                                value="<?= e($_POST['children'] ?? '0') ?>"></label><label class="wide">Approximate
                        budget (₹)<input type="number" min="0" step="500" name="budget"
                                         value="<?= e($_POST['budget'] ?? '') ?>"></label><label class="wide">Tell us
                        what you need<textarea name="message"
                                               rows="4"><?= e($_POST['message'] ?? '') ?></textarea></label></div>
                <button type="submit">Send enquiry</button></form><?php endif; ?></div>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
