<?php
include("sidebar.php");
include("config.php");

function admin_generate_temp_password(int $length = 12): string
{
    return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ23456789@#%'), 0, $length);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_email'])) {
    csrf_require();
    $email = trimmed($_POST['approve_email']);

    $stmt = $con->prepare('UPDATE tbl_register SET isactive = 0 WHERE email_id = ? AND isdeleted = 0');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->close();

    $tempPassword = admin_generate_temp_password();
    $hash = password_hash($tempPassword, PASSWORD_DEFAULT);

    $stmt = $con->prepare(
            'INSERT INTO tbl_login (email_id, password, type, isactive, isdeleted, must_change_password) '
            . 'VALUES (?, ?, \'user\', 0, 0, 1)'
    );
    $stmt->bind_param('ss', $email, $hash);
    $stmt->execute();
    $stmt->close();

    $sent = send_mail(
            $email,
            'Your WanderTrail account is approved',
            '<p>Your WanderTrail registration has been approved.</p>'
            . '<p>Temporary password: <b>' . htmlspecialchars($tempPassword, ENT_QUOTES, 'UTF-8') . '</b></p>'
            . '<p>Please log in and change this password from your account settings.</p>'
    );

    if ($sent) {
        flash_success("Approved {$email} and emailed their temporary password.");
    } else {
        flash_set('info', "Approved {$email}, but the notification email could not be sent (mail is not configured on this server). "
                . "Share this temporary password with the user directly: {$tempPassword}");
    }

    header('Location: manageuser.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deactivate_email'])) {
    csrf_require();
    $email = trimmed($_POST['deactivate_email']);

    $stmt = $con->prepare('UPDATE tbl_register SET isdeleted = 1 WHERE email_id = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->close();

    $stmt = $con->prepare('UPDATE tbl_login SET isdeleted = 1 WHERE email_id = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->close();

    flash_success("Deactivated {$email}.");
    header('Location: manageuser.php');
    exit;
}

include("header.php");
?>

<br/><br/><br/>
<div style="margin-left:17%;margin-right:5%;">
    <?php echo flash_render(); ?>
</div>

<div class="bs-example widget-shadow" data-example-id="bordered-table" style="overflow:scroll;margin-left:17%;">
    <h4>Pending Registrations:</h4>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Email Id</th>
            <th>Approve</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $stmt = $con->prepare('SELECT email_id FROM tbl_register WHERE isdeleted = 0 AND isactive = 1');
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            ?>
            <tr>
                <td colspan="2" class="eg-empty">No pending registrations.</td>
            </tr>
            <?php
        }
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo h($row['email_id']); ?></td>
                <td>
                    <form method="post" style="display:inline;"
                          onsubmit="return confirm('Approve this user and email them a temporary password?');">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="approve_email" value="<?php echo h($row['email_id']); ?>">
                        <button type="submit" class="eg-btn eg-btn-primary" style="padding:6px 16px;font-size:13px;">
                            Approve
                        </button>
                    </form>
                </td>
            </tr>
            <?php
        }
        $stmt->close();
        ?>
        </tbody>
    </table>
</div>

<br/><br/><br/>

<div class="bs-example widget-shadow" data-example-id="bordered-table" style="overflow:scroll;margin-left:17%;">
    <h4>Active Users:</h4>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Email Id</th>
            <th>Deactivate</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $stmt = $con->prepare("SELECT email_id FROM tbl_login WHERE isdeleted = 0 AND type = 'user'");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            ?>
            <tr>
                <td colspan="2" class="eg-empty">No active users.</td>
            </tr>
            <?php
        }
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo h($row['email_id']); ?></td>
                <td>
                    <form method="post" style="display:inline;"
                          onsubmit="return confirm('Deactivate this user account?');">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="deactivate_email" value="<?php echo h($row['email_id']); ?>">
                        <button type="submit" class="eg-btn eg-btn-outline" style="padding:6px 16px;font-size:13px;">
                            Deactivate
                        </button>
                    </form>
                </td>
            </tr>
            <?php
        }
        $stmt->close();
        ?>
        </tbody>
    </table>
</div>

<br/><br/>
<?php
include("footer.php");
?>
