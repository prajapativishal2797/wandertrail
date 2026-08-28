# WanderTrail

**Tagline:** *Trails to the places maps forget.*

**Category:** Travel & Tourism — Discovery + Booking + Trip Planning

Worldwide PHP/MySQL travel discovery, booking and trip-planning platform, updated to run on PHP 8.2 and WAMP.

## Local setup (WAMP)

1. Start **Apache** and **MySQL** from the WAMP tray menu.
2. Open phpMyAdmin and import `database/explore_gujarat.sql` into a database named `explore_gujarat`.
3. Import `database/2026_compatibility_tables.sql` to add structures omitted from the original dump.
4. Import `database/2026_content_management.sql` to install editable page content.
5. Import `database/2026_auth_hardening.sql` to widen `tbl_login.password` for hashed passwords and add
   password-reset/lockout columns.
6. Import `database/2026_user_favorites.sql` to enable saved destinations, hotels, packages and guides.
7. Import `database/2026_travel_agency.sql` to enable trip enquiries, secure payment requests, and traveller reviews.
8. Visit `http://localhost/exploregujarat/`.

## Authentication

Login, registration, forgot-password and reset-password all live at the project root: `login.php`, `register.php`,
`forgot-password.php`, and `resetpass.php`. Shared navigation links directly to these canonical routes and to
`user/index.php` for authenticated customer accounts.

- Passwords are verified with `password_verify()`. Rows created before this change (plaintext, from the original schema)
  are transparently rehashed with `password_hash()` the next time that account logs in successfully - no bulk
  migration/downtime needed, see `includes/auth.php`.
- Registration still goes through the existing admin-approval workflow (**Manage Users** in the admin sidebar): a new
  signup lands in `tbl_register` as pending, and approving it creates the matching `tbl_login` row with a random
  temporary password (hashed, `must_change_password = 1`) that is emailed to the user.
- Forgot-password issues a random token (only its SHA-256 hash is stored, 1 hour expiry) instead of the old behaviour of
  emailing/redirecting with the account's plaintext password.
- `/admin/*` requires `type = 'admin'` on the session; `/user/*` requires `type = 'user'`. Previously any logged-in
  account (of either type) could reach `/admin`.

### Email (optional)

Password reset links, subscription/suggestion emails, and admin-approval notifications are sent through
`includes/mailer.php`, configured entirely from environment variables - no credentials are hard-coded:

- `MAIL_HOST`, `MAIL_PORT` (default 587), `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_ENCRYPTION` (default `tls`),
  `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME`

If these are not set, `send_mail()` logs the attempt and returns `false` instead of sending - forms still work, they
just report that mail isn't configured. As a local-development convenience, when a password reset email can't be sent *
*and** the request came from `127.0.0.1`/`::1`, the reset link is shown directly on the confirmation page instead of
only being logged.

The previous code had real Gmail account credentials hard-coded in several files (`admin/manageuser.php`,
`resetpass.php`, `user/forgetpassword.php`, plus dead/commented-out code in the header files). Those live usages have
been replaced with `send_mail()`; **rotate that Gmail password**, since it was sitting in plaintext in the repository.

The public `suggest.php` page sends destination recommendations using the same mail configuration. It never subscribes
the recipient to marketing messages.

## Editing dynamic content

Sign in as an administrator and open **Manage Page Content** in the admin sidebar. Content is identified by a stable
page key and block key. The homepage, About page, and the introductions for destinations, hotels, packages and tour
guides read these records through `includes/content.php`.

Keep photographs and frontend assets on disk. Store only their relative paths (for example
`assets/site/pic/promo-2.png`) in the database. Static files are grouped under `assets/site`, `assets/user`, and
`assets/admin`.

Old admin-template demonstrations and the unrelated event-management application are preserved under the web-protected
`_archive` directory. They are no longer part of any live application route.

The default local connection is `root` with an empty password on `127.0.0.1:3306`. You can override it without editing
source code:

- `DB_HOST`
- `DB_PORT`
- `DB_USER`
- `DB_PASSWORD`
- `DB_NAME`

The separate application under `admin/user` uses the bundled `online_eventmgtsystem` database dump and has not been
merged into the main tourism schema.

## Shared helpers (`includes/`)

- `database.php` - the PDO connection and reusable query/transaction helpers; it also pins the DB session to UTC.
- `auth.php` - login/session/role checks, password verify+legacy-upgrade, password-reset tokens.
- `csrf.php` - `csrf_field()` in every state-changing form, `csrf_require()` at the top of its POST handler.
- `flash.php` - `flash_success()`/`flash_error()` + `flash_render()` for post-redirect status messages.
- `validation.php` - `valid_email()`, `valid_password()`, `valid_phone()`, `old()` (repopulate a field after a failed
  submit).
- `upload.php` - `safe_upload()`: extension allow-list + MIME sniff + `getimagesize()` check + random filename.
- `mailer.php` - `send_mail()`, see Email section above.
- `session_bootstrap.php` - hardened session cookie flags (`httponly`, `SameSite=Lax`, `secure` on HTTPS); replaces bare
  `session_start()` calls.

All three `config.php` files (root, `admin/`, `user/`) pull these in automatically, so any page that already does
`include('config.php')` has them available.

## Travel-agency flow

Visitors discover destinations, hotels, packages and guides through the canonical public routes. `enquiry.php` accepts
general and custom-trip leads. Signed-in customers use one server-priced booking controller (`user/booking.php`), view
their hotel/package bookings in the account area, and request a payment link, bank transfer or office payment through
`user/payment-request.php`. The application intentionally does not collect or store card numbers or CVVs.

Customers can also save catalogue items, submit destination/hotel/package/guide reviews, send feedback, and open a
support complaint. New agency data is stored in `tbl_travel_enquiry`, `tbl_payment_request`, and `tbl_travel_review`.

## Important next improvements

This is an old codebase being modernized incrementally. Done so far: prepared statements + hashed passwords + CSRF +
centralized role checks for the whole authentication path (see above); `.htaccess` files denying PHP execution in every
upload folder (`upload/`, `admin/hotel|package|subplace|placeimage/`, `storage/uploads/users/`). Still outstanding
before wider exposure:

1. Extend prepared statements / CSRF / centralized auth checks to the remaining admin CRUD screens (hotels, packages,
   places, subplaces, tour guides, bookings, ratings and FAQ). Public and customer booking/payment paths use PDO and
   CSRF protection; the excluded legacy admin screens still require a separate hardening pass.
2. Apply the same MIME/extension/random-filename upload hardening (`includes/upload.php`) to the admin image-upload
   forms, which currently trust the browser-supplied filename and extension.
3. Apply the public design system to the excluded admin dashboard in a later admin-specific phase.
4. Replace the bundled legacy PHPMailer/SMTP classes with a maintained Composer package.

## Verification

Run a syntax check over the project from PowerShell:

```powershell
Get-ChildItem -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }
```
