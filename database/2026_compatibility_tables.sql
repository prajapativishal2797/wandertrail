-- Tables referenced by the application but missing from the original dump.
-- Safe to run repeatedly after database/explore_gujarat.sql.

CREATE TABLE IF NOT EXISTS `tbl_faq`
(
    `faq_id`
    int
    NOT
    NULL
    AUTO_INCREMENT,
    `faq_que`
    varchar
(
    255
) NOT NULL,
    `faq_ans` text NOT NULL,
    `viewcount` int NOT NULL DEFAULT 0,
    `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `isdeleted` bit
(
    1
) NOT NULL DEFAULT b'0',
    PRIMARY KEY
(
    `faq_id`
)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `tbl_subscriber`
(
    `subscriber_id`
    int
    NOT
    NULL
    AUTO_INCREMENT,
    `email_id`
    varchar
(
    191
) NOT NULL,
    `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY
(
    `subscriber_id`
),
    UNIQUE KEY `uq_subscriber_email`
(
    `email_id`
)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `tbl_tourguide`
(
    `guide_id`
    int
    NOT
    NULL
    AUTO_INCREMENT,
    `subplace_id`
    int
    NOT
    NULL,
    `guide_name`
    varchar
(
    100
) NOT NULL,
    `guide_email` varchar
(
    254
) NOT NULL,
    `guide_contact` varchar
(
    30
) NOT NULL,
    `language_known` varchar
(
    255
) NOT NULL,
    `guide_rate` decimal
(
    3,
    1
) NOT NULL DEFAULT 0,
    `guide_image` varchar
(
    255
) NOT NULL DEFAULT '',
    `isdeleted` bit
(
    1
) NOT NULL DEFAULT b'0',
    PRIMARY KEY
(
    `guide_id`
),
    KEY `idx_tourguide_subplace`
(
    `subplace_id`
)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;

-- Older pages use tbl_tourplace while current admin pages use tbl_place.
CREATE
OR REPLACE VIEW `tbl_tourplace` AS
SELECT *
FROM `tbl_place`;

CREATE TABLE IF NOT EXISTS `tbl_complain`
(
    `complain_id`
    int
    NOT
    NULL
    AUTO_INCREMENT,
    `user_id`
    int
    NOT
    NULL,
    `date`
    date
    NOT
    NULL,
    `complain_msg`
    text
    NOT
    NULL,
    `isapproved`
    bit
(
    1
) NOT NULL DEFAULT b'0',
    PRIMARY KEY
(
    `complain_id`
)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `tbl_hotelpaypal`
(
    `payment_id`
    int
    NOT
    NULL
    AUTO_INCREMENT,
    `item_number`
    varchar
(
    100
) NOT NULL,
    `txn_id` varchar
(
    100
) NOT NULL,
    `payment_gross` decimal
(
    10,
    2
) NOT NULL,
    `currency_code` varchar
(
    10
) NOT NULL,
    `payment_status` varchar
(
    50
) NOT NULL,
    `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY
(
    `payment_id`
),
    UNIQUE KEY `uq_hotelpaypal_txn`
(
    `txn_id`
)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `tbl_packagepaypal` LIKE `tbl_hotelpaypal`;
