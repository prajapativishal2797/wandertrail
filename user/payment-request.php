<?php
require_once __DIR__ . '/config.php';
require_login('../login.php', 'user');
$profile = db_one($con, 'SELECT user_id FROM tbl_register WHERE email_id=? AND isdeleted=0 LIMIT 1', [current_user_email()]);
$userId = (int)($profile['user_id'] ?? 0);
$type = (string)($_GET['type'] ?? $_POST['type'] ?? '');
$bookingId = (int)($_GET['booking_id'] ?? $_POST['booking_id'] ?? 0);
$booking = null;
if ($type === 'hotel') {
    $booking = db_one($con, 'SELECT b.hotelbooking_id booking_id,b.amount,b.status,h.hotel_name item_name FROM tbl_hotelbooking b INNER JOIN tbl_hotel h ON h.hotel_id=b.hotel_id WHERE b.hotelbooking_id=? AND b.user_id=?', [$bookingId, $userId]);
} elseif ($type === 'package') {
    $booking = db_one($con, 'SELECT b.packagebooking_id booking_id,b.amount,b.status,pk.package_name item_name FROM tbl_packagebooking b INNER JOIN tbl_package pk ON pk.package_id=b.package_id WHERE b.packagebooking_id=? AND b.user_id=?', [$bookingId, $userId]);
}
if (is_post() && $booking) {
    csrf_require();
    $method = request_string('preferred_method');
    if (!in_array($method, ['payment_link', 'bank_transfer', 'cash_at_office'], true)) $method = 'payment_link';
    $note = mb_strimwidth(request_string('customer_note'), 0, 500);
    db_execute($con, 'INSERT INTO tbl_payment_request (user_id,booking_type,booking_id,amount,preferred_method,customer_note) VALUES (?,?,?,?,?,?) ON DUPLICATE KEY UPDATE preferred_method=VALUES(preferred_method),customer_note=VALUES(customer_note),status="requested",updated_at=NOW()', [$userId, $type, $bookingId, $booking['amount'], $method, $note]);
    flash_success('Your payment request has been sent to the agency.');
    redirect('payment-request.php?type=' . $type . '&booking_id=' . $bookingId);
}
$request = $booking ? db_one($con, 'SELECT * FROM tbl_payment_request WHERE user_id=? AND booking_type=? AND booking_id=?', [$userId, $type, $bookingId]) : null;
$userPageTitle = 'Arrange payment | WanderTrail';
require __DIR__ . '/header.php';
?>
<section class="eg-account-page">
    <div class="eg-account-form-shell is-narrow"><?= flash_render() ?><?php if (!$booking): ?>
            <div class="eg-empty-state"><h2>Booking not found</h2>
                <p>The requested booking is unavailable.</p></div><?php elseif ($booking['status'] === 'paid'): ?>
            <div class="eg-enquiry-success"><i class="fa fa-check"></i>
                <h2>Payment complete</h2>
                <p>This booking is already marked as paid.</p></div><?php else: ?>
            <div class="eg-account-form-heading"><p><?= e($type) ?> booking #<?= $bookingId ?></p>
            <h1>Arrange payment</h1>
            <span><?= e($booking['item_name']) ?> · ₹<?= number_format((float)$booking['amount']) ?></span>
            </div><?php if ($request): ?>
                <div class="eg-alert eg-alert-success">Current request
                status: <?= e(str_replace('_', ' ', $request['status'])) ?></div><?php endif; ?>
            <form method="post" class="eg-account-form"><?= csrf_field() ?><input type="hidden" name="type"
                                                                                  value="<?= e($type) ?>"><input
                    type="hidden" name="booking_id" value="<?= $bookingId ?>">
            <div class="eg-form-grid single"><label>Preferred payment method<select name="preferred_method">
                        <option value="payment_link">Send me a secure payment link</option>
                        <option value="bank_transfer">Bank transfer</option>
                        <option value="cash_at_office">Cash at agency office</option>
                    </select></label><label>Note for the agency<textarea name="customer_note" rows="4"
                                                                         placeholder="Preferred contact time or payment note"></textarea></label>
            </div>
            <div class="eg-form-actions">
                <button type="submit">Request payment instructions</button>
                <a href="<?= $type === 'hotel' ? 'hotelbookinglist.php' : 'packagebookinglist.php' ?>">Cancel</a></div>
            </form><p class="eg-payment-safety"><i class="fa fa-lock"></i> Card numbers and CVV codes are never
                collected or stored on this website.</p><?php endif; ?></div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
