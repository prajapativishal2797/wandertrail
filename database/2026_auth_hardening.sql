-- Auth hardening migration (2026).
--
-- Non-destructive: only widens/adds columns and indexes. No existing rows,
-- tables, or columns are dropped or renamed. Safe to run once against the
-- existing `explore_gujarat` database described in README.md.
--
-- Why: tbl_login.password was `varchar(10)` holding plaintext passwords.
-- password_hash() output does not fit in 10 characters, so the column must
-- be widened before the application can start hashing passwords. The other
-- new columns support a real token-based password reset flow and basic
-- login throttling, replacing the previous "email the plaintext password"
-- and "reset via a guessable ?email_id= link" behaviour.

ALTER TABLE `tbl_login`
    MODIFY `password` VARCHAR (255) NOT NULL;

ALTER TABLE `tbl_login`
    ADD COLUMN `reset_token_hash` VARCHAR(64) NULL DEFAULT NULL AFTER `type`,
  ADD COLUMN `reset_token_expires` DATETIME NULL DEFAULT NULL AFTER `reset_token_hash`,
  ADD COLUMN `failed_attempts` TINYINT UNSIGNED NOT NULL DEFAULT 0 AFTER `reset_token_expires`,
  ADD COLUMN `locked_until` DATETIME NULL DEFAULT NULL AFTER `failed_attempts`,
  ADD COLUMN `must_change_password` TINYINT(1) NOT NULL DEFAULT 0 AFTER `locked_until`,
  ADD COLUMN `last_login_at` DATETIME NULL DEFAULT NULL AFTER `must_change_password`;

ALTER TABLE `tbl_login`
    ADD INDEX `idx_tbl_login_email` (`email_id`);

ALTER TABLE `tbl_register`
    ADD INDEX `idx_tbl_register_email` (`email_id`);

-- Existing plaintext passwords (e.g. the seeded admin@admin.com / admin
-- account) are left as-is here. includes/auth.php verifies legacy plaintext
-- rows on their next successful login and transparently rehashes them with
-- password_hash(), so no bulk UPDATE/data loss risk is taken in this file.
