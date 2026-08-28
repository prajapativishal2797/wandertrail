-- Reusable editable content for public pages.
CREATE TABLE IF NOT EXISTS `tbl_content_block`
(
    `content_id`
    int
    NOT
    NULL
    AUTO_INCREMENT,
    `page_key`
    varchar
(
    80
) NOT NULL,
    `block_key` varchar
(
    80
) NOT NULL,
    `title` varchar
(
    255
) NOT NULL DEFAULT '',
    `content` text NOT NULL,
    `image_path` varchar
(
    255
) NOT NULL DEFAULT '',
    `sort_order` int NOT NULL DEFAULT 0,
    `is_active` tinyint
(
    1
) NOT NULL DEFAULT 1,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY
(
    `content_id`
),
    UNIQUE KEY `uq_content_page_block`
(
    `page_key`,
    `block_key`
),
    KEY `idx_content_page_active`
(
    `page_key`,
    `is_active`,
    `sort_order`
)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;

INSERT
IGNORE INTO `tbl_content_block`
(`page_key`, `block_key`, `title`, `content`, `image_path`, `sort_order`) VALUES
('home', 'destinations_intro', 'Popular Places & Hidden Gems', 'WanderTrail brings together famous attractions, lesser-known gems and relaxing picnic places so every traveller can plan a memorable visit.', 'assets/site/pic/promo-2.png', 10),
('destinations', 'intro', 'Tourist Places, Hidden Gems & Picnic Spots', 'Discover famous attractions, lesser-known treasures and picnic escapes, with practical information to help you choose where to go and when to visit.', 'assets/site/pic/promo-2.png', 10),
('hotels', 'intro', 'Recommended Hotels', 'Explore available hotels and compare places to stay according to your needs and budget.', '', 10),
('packages', 'intro', 'Attractive Packages', 'Browse curated travel packages, durations and starting prices to find a trip that suits you.', '', 10),
('guides', 'intro', 'Local Tour Guides', 'Connect with knowledgeable local guides who bring destinations, cultures and heritage around the world to life.', '', 10),
('about', 'intro', 'WanderTrail', 'Our travel team helps visitors from discovery and planning through booking and their return home, connecting them with local culture, heritage, wildlife, cuisine, hidden gems and picnic escapes.', 'assets/site/pic/promo-2.png', 10),
('about', 'about', 'About WanderTrail', 'We help travellers discover overlooked places, plan memorable trips and book accommodation, travel packages and local guides with confidence.', '', 20),
('about', 'mission', 'Our Mission', 'To make remarkable places worldwide easier to discover, plan and book while supporting responsible, accessible and memorable travel.', '', 30),
('about', 'vision', 'Our Vision', 'To become a trusted worldwide travel partner by connecting curious travellers with quality stays, experiences and knowledgeable local guides.', '', 40);
