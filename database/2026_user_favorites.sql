CREATE TABLE IF NOT EXISTS tbl_user_favorite
(
    favorite_id
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
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY
(
    favorite_id
),
    UNIQUE KEY uq_user_favorite
(
    user_id,
    item_type,
    item_id
),
    KEY idx_user_favorite_user
(
    user_id,
    created_at
)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
