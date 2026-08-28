CREATE TABLE IF NOT EXISTS tbl_travel_enquiry
(
    enquiry_id
    INT
    UNSIGNED
    NOT
    NULL
    AUTO_INCREMENT,
    user_id
    INT
    NULL,
    enquiry_type
    ENUM
(
    'general',
    'destination',
    'hotel',
    'package',
    'custom_trip'
) NOT NULL DEFAULT 'general',
    reference_id INT NULL,
    customer_name VARCHAR
(
    100
) NOT NULL,
    email VARCHAR
(
    190
) NOT NULL,
    phone VARCHAR
(
    20
) NOT NULL,
    destination VARCHAR
(
    120
) NULL,
    travel_start DATE NULL,
    travel_end DATE NULL,
    adults SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    children SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    budget DECIMAL
(
    12,
    2
) NULL,
    message TEXT NULL,
    status ENUM
(
    'new',
    'contacted',
    'quoted',
    'converted',
    'closed'
) NOT NULL DEFAULT 'new',
    source VARCHAR
(
    40
) NOT NULL DEFAULT 'website',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY
(
    enquiry_id
),
    KEY idx_enquiry_status_created
(
    status,
    created_at
),
    KEY idx_enquiry_user
(
    user_id
)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tbl_travel_review
(
    review_id
    INT
    UNSIGNED
    NOT
    NULL
    AUTO_INCREMENT,
    user_id
    INT
    NOT
    NULL,
    item_type
    ENUM
(
    'destination',
    'hotel',
    'package',
    'guide'
) NOT NULL,
    item_id INT NOT NULL,
    score TINYINT UNSIGNED NOT NULL,
    review_title VARCHAR
(
    120
) NULL,
    review_text VARCHAR
(
    1000
) NULL,
    status ENUM
(
    'pending',
    'published',
    'rejected'
) NOT NULL DEFAULT 'published',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY
(
    review_id
),
    UNIQUE KEY uq_travel_review_item
(
    user_id,
    item_type,
    item_id
),
    KEY idx_travel_review_public
(
    item_type,
    item_id,
    status
)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tbl_payment_request
(
    payment_request_id
    INT
    UNSIGNED
    NOT
    NULL
    AUTO_INCREMENT,
    user_id
    INT
    NOT
    NULL,
    booking_type
    ENUM
(
    'hotel',
    'package'
) NOT NULL,
    booking_id INT NOT NULL,
    amount DECIMAL
(
    12,
    2
) NOT NULL,
    preferred_method ENUM
(
    'payment_link',
    'bank_transfer',
    'cash_at_office'
) NOT NULL DEFAULT 'payment_link',
    status ENUM
(
    'requested',
    'link_sent',
    'pending_verification',
    'paid',
    'cancelled'
) NOT NULL DEFAULT 'requested',
    provider_reference VARCHAR
(
    120
) NULL,
    customer_note VARCHAR
(
    500
) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY
(
    payment_request_id
),
    UNIQUE KEY uq_active_booking_request
(
    booking_type,
    booking_id
),
    KEY idx_payment_request_user
(
    user_id,
    created_at
)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
