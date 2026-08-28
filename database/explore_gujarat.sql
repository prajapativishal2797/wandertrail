-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2021 at 07:54 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.27

SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `explore_gujarat`
--

-- --------------------------------------------------------

--
-- Table structure for table `response`
--

CREATE TABLE `response`
(
    `response_id`  int(6) NOT NULL,
    `ORDERID`      varchar(5)  NOT NULL,
    `MID`          varchar(50) NOT NULL,
    `TXNID`        varchar(50) NOT NULL,
    `TXNAMOUNT`    varchar(50) NOT NULL,
    `PAYMENTMODE`  varchar(50) NOT NULL,
    `CURRENCY`     varchar(50) NOT NULL,
    `TXNDATE`      datetime    NOT NULL,
    `STATUS`       varchar(40) NOT NULL,
    `RESPCODE`     varchar(40) NOT NULL,
    `RESPMSG`      varchar(50) NOT NULL,
    `GATEWAYNAME`  varchar(50) NOT NULL,
    `BANKTXNID`    int(11) NOT NULL,
    `BANKNAME`     int(11) NOT NULL,
    `CHECKSUMHASH` int(11) NOT NULL,
    `isdeleted`    bit(1)      NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `response`
--

INSERT INTO `response` (`response_id`, `ORDERID`, `MID`, `TXNID`, `TXNAMOUNT`, `PAYMENTMODE`, `CURRENCY`, `TXNDATE`,
                        `STATUS`, `RESPCODE`, `RESPMSG`, `GATEWAYNAME`, `BANKTXNID`, `BANKNAME`, `CHECKSUMHASH`,
                        `isdeleted`)
VALUES (16, 'ORDS6', 'YNsDmK65892563211994', '', '8400.00', '', 'INR', '0000-00-00 00:00:00', 'TXN_FAILURE', '501',
        'System Error', '', 0, 0, 0, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feedback`
--

CREATE TABLE `tbl_feedback`
(
    `feedback_id`  int(4) NOT NULL,
    `user_id`      int(10) NOT NULL,
    `date`         date        NOT NULL,
    `feedback_msg` varchar(50) NOT NULL,
    `isdeleted`    bit(1)      NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_feedback`
--

INSERT INTO `tbl_feedback` (`feedback_id`, `user_id`, `date`, `feedback_msg`, `isdeleted`)
VALUES (9, 6, '2019-12-14', 'nice site', b'0'),
       (10, 8, '2020-02-19', 'jjjj', b'0'),
       (11, 12, '2021-09-18', 'very good site', b'0'),
       (12, 13, '2021-09-19', 'nice site with all the description', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hotel`
--

CREATE TABLE `tbl_hotel`
(
    `hotel_id`        int(4) NOT NULL,
    `hotel_name`      varchar(50)  NOT NULL,
    `place_id`        int(4) NOT NULL,
    `hotel_des`       varchar(200) NOT NULL,
    `hotel_price`     int(6) NOT NULL,
    `hotel_image`     varchar(30)  NOT NULL,
    `hotel_category`  varchar(20)  NOT NULL,
    `hotel_address`   varchar(100) NOT NULL,
    `hotel_status`    varchar(15)  NOT NULL,
    `airport_pickup`  int(6) NOT NULL,
    `car_parking`     int(6) NOT NULL,
    `extra_breakfast` int(6) NOT NULL,
    `isdeleted`       bit(1)       NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_hotel`
--

INSERT INTO `tbl_hotel` (`hotel_id`, `hotel_name`, `place_id`, `hotel_des`, `hotel_price`, `hotel_image`,
                         `hotel_category`, `hotel_address`, `hotel_status`, `airport_pickup`, `car_parking`,
                         `extra_breakfast`, `isdeleted`)
VALUES (8, 'hotel raj', 37,
        'Featuring free WiFi and a restaurant, Hotel Raj offers accommodations in Ahmedabad. Guests can enjoy the on-site restaurant.',
        4200, 'th.jpg', '3 star', 'Ashram Road, Ahmedabad, Gujarat 380013', 'available', 300, 100, 200, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hotelbooking`
--

CREATE TABLE `tbl_hotelbooking`
(
    `hotelbooking_id`   int(4) NOT NULL,
    `hotel_id`          int(4) NOT NULL,
    `amount`            int(6) NOT NULL,
    `depart_date`       date        NOT NULL,
    `return_date`       date        NOT NULL,
    `adults`            int(3) NOT NULL,
    `childs`            int(3) NOT NULL,
    `no_rooms`          int(3) NOT NULL,
    `user_id`           int(10) NOT NULL,
    `airport_pickup`    int(6) NOT NULL,
    `car_parking`       int(6) NOT NULL,
    `extra_breakfast`   int(6) NOT NULL,
    `hotelbooking_date` date        NOT NULL,
    `isapproved`        varchar(10) NOT NULL,
    `status`            varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_hotelbooking`
--

INSERT INTO `tbl_hotelbooking` (`hotelbooking_id`, `hotel_id`, `amount`, `depart_date`, `return_date`, `adults`,
                                `childs`, `no_rooms`, `user_id`, `airport_pickup`, `car_parking`, `extra_breakfast`,
                                `hotelbooking_date`, `isapproved`, `status`)
VALUES (18, 8, 4500, '2020-02-21', '2020-02-22', 1, 2, 1, 8, 300, 0, 0, '2020-02-19', 'pending', 'not paid'),
       (19, 8, 8400, '2020-02-21', '2020-02-22', 2, 2, 2, 8, 0, 0, 0, '2020-02-20', 'pending', 'not paid'),
       (20, 8, 4500, '2020-03-19', '2020-03-20', 1, 1, 1, 8, 300, 0, 0, '2020-03-12', 'pending', 'not paid'),
       (21, 8, 4800, '2021-09-19', '2021-09-20', 2, 1, 1, 12, 300, 100, 200, '2021-09-18', 'pending', 'not paid');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hotelpayment`
--

CREATE TABLE `tbl_hotelpayment`
(
    `card_id`         int(4) NOT NULL,
    `hotelbooking_id` int(4) NOT NULL,
    `amount`          int(6) NOT NULL,
    `card_type`       varchar(15) NOT NULL,
    `nameon_card`     varchar(30) NOT NULL,
    `card_no`         bigint(16) NOT NULL,
    `expiry_date`     varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_hotelpayment`
--

INSERT INTO `tbl_hotelpayment` (`card_id`, `hotelbooking_id`, `amount`, `card_type`, `nameon_card`, `card_no`,
                                `expiry_date`)
VALUES (5, 15, 12900, 'visa', 'ankita', 3444444444444444, '2019-12');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login`
--

CREATE TABLE `tbl_login`
(
    `login_id`  int(10) NOT NULL,
    `email_id`  varchar(50) NOT NULL,
    `password`  varchar(10) NOT NULL,
    `type`      varchar(20) NOT NULL,
    `isactive`  bit(1)      NOT NULL,
    `isdeleted` bit(1)      NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_login`
--

INSERT INTO `tbl_login` (`login_id`, `email_id`, `password`, `type`, `isactive`, `isdeleted`)
VALUES (1, 'admin@admin.com', 'admin', 'admin', b'0', b'0'),
       (16, 'nivaaninfotech@gmail.com', '8%Ab7kG6', 'user', b'0', b'0'),
       (17, 'sanjay@gmail.com', 'sanjay80', 'user', b'0', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_package`
--

CREATE TABLE `tbl_package`
(
    `package_id`         int(4) NOT NULL,
    `package_name`       varchar(50)  NOT NULL,
    `package_img`        varchar(30)  NOT NULL,
    `package_duration`   varchar(20)  NOT NULL,
    `package_des`        varchar(100) NOT NULL,
    `package_startprice` int(6) NOT NULL,
    `package_type`       varchar(15)  NOT NULL,
    `place_id`           int(4) NOT NULL,
    `hotel_id`           int(4) NOT NULL,
    `package_rate`       float(2, 1
) NOT NULL,
  `isdeleted` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_package`
--

INSERT INTO `tbl_package` (`package_id`, `package_name`, `package_img`, `package_duration`, `package_des`,
                           `package_startprice`, `package_type`, `place_id`, `hotel_id`, `package_rate`, `isdeleted`)
VALUES (1, 'Kerala Tour', 'kerala.jpg', '6 nights 7 days',
        'Best for laid-back beach scene, swaying elephant rides and gentle houseboat cruises.', 22999, 'wildlife', 37,
        8, 4.3, b'0'),
       (2, 'Goa tour', 'goa.jpg', '4 nights 5 days',
        'In this tour package we provide most of the places of goa sure you enjoy this.', 20000, 'beach', 37, 8, 4.6,
        b'0'),
       (3, 'Shimala And Manali', 'shimla_manali.jpg', '5 nights 6 days',
        'This package covers almost all the tourist places within Shimala and Manali.', 15000, 'family', 37, 8, 4.6,
        b'0'),
       (4, 'Hills of Ooty & Kodaikanal', 'ooty&kodaikanal.jpg', '4 nights 5 days',
        'This tour package is interesting and having different types of tourist places.', 13000, 'honeymoon', 0, 8, 4.3,
        b'0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_packagebooking`
--

CREATE TABLE `tbl_packagebooking`
(
    `packagebooking_id`   int(4) NOT NULL,
    `package_id`          int(4) NOT NULL,
    `amount`              int(6) NOT NULL,
    `start_date`          date        NOT NULL,
    `end_date`            date        NOT NULL,
    `adults`              int(2) NOT NULL,
    `childs`              int(2) NOT NULL,
    `no_rooms`            int(2) NOT NULL,
    `package_category`    varchar(10) NOT NULL,
    `hotel_id`            int(4) NOT NULL,
    `user_id`             int(10) NOT NULL,
    `packagebooking_date` date        NOT NULL,
    `isapproved`          varchar(10) NOT NULL,
    `status`              varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_packagepayment`
--

CREATE TABLE `tbl_packagepayment`
(
    `card_id`           int(4) NOT NULL,
    `packagebooking_id` int(4) NOT NULL,
    `amount`            int(6) NOT NULL,
    `card_type`         varchar(15) NOT NULL,
    `nameon_card`       varchar(30) NOT NULL,
    `card_no`           bigint(16) NOT NULL,
    `expiry_date`       varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_packagepayment`
--

INSERT INTO `tbl_packagepayment` (`card_id`, `packagebooking_id`, `amount`, `card_type`, `nameon_card`, `card_no`,
                                  `expiry_date`)
VALUES (2, 16, 68997, 'visa', 'ankita', 1111111111111111, '2019-12');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_place`
--

CREATE TABLE `tbl_place`
(
    `place_id`    int(4) NOT NULL,
    `place_name`  varchar(25) NOT NULL,
    `place_image` varchar(50) NOT NULL,
    `isdeleted`   bit(1)      NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_place`
--

INSERT INTO `tbl_place` (`place_id`, `place_name`, `place_image`, `isdeleted`)
VALUES (37, 'Ahmedabad', 'abad.jpg', b'0'),
       (38, 'Gandhinagar', 'download.jpg', b'0'),
       (39, 'surat', 'images.jpg', b'0'),
       (40, 'Rajkot', 'images (1).jpg', b'0'),
       (41, 'Vadodara', 'download (1).jpg', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rate`
--

CREATE TABLE `tbl_rate`
(
    `ratings_id`    int(11) NOT NULL,
    `user_id`       int(3) NOT NULL,
    `hotel_id`      int(4) NOT NULL,
    `ratings_score` int(11) NOT NULL,
    `isdeleted`     bit(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_rate`
--

INSERT INTO `tbl_rate` (`ratings_id`, `user_id`, `hotel_id`, `ratings_score`, `isdeleted`)
VALUES (11, 6, 8, 5, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_register`
--

CREATE TABLE `tbl_register`
(
    `user_id`     int(10) NOT NULL,
    `first_name`  varchar(20)  NOT NULL,
    `middle_name` varchar(20)  NOT NULL,
    `last_name`   varchar(20)  NOT NULL,
    `email_id`    varchar(50)  NOT NULL,
    `address`     varchar(250) NOT NULL,
    `contact_no`  bigint(10) NOT NULL,
    `id_proof`    varchar(100) NOT NULL,
    `create_date` date         NOT NULL,
    `isactive`    bit(1)       NOT NULL,
    `isdeleted`   bit(1)       NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_register`
--

INSERT INTO `tbl_register` (`user_id`, `first_name`, `middle_name`, `last_name`, `email_id`, `address`, `contact_no`,
                            `id_proof`, `create_date`, `isactive`, `isdeleted`)
VALUES (12, 'ramesh', 'pravinbhai', 'soni', 'nivaaninfotech@gmail.com', 'visnagar', 9374283619, 'PHOTO.jpg',
        '2021-09-18', b'0', b'0'),
       (13, 'sanjay', 'dhanjibhai', 'rabaree', 'sanjay@gmail.com', 'mevad dist mehsana', 7567390606, 'PHOTO.jpg',
        '2021-09-19', b'0', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subplace`
--

CREATE TABLE `tbl_subplace`
(
    `subplace_id`     int(4) NOT NULL,
    `place_id`        int(4) NOT NULL,
    `subplace_name`   varchar(50)  NOT NULL,
    `city`            varchar(50)  NOT NULL,
    `upload_pic1`     varchar(30)  NOT NULL,
    `upload_pic2`     varchar(30)  NOT NULL,
    `upload_pic3`     varchar(30)  NOT NULL,
    `tag_line`        varchar(200) NOT NULL,
    `subplace_des`    text         NOT NULL,
    `modes_transport` text         NOT NULL,
    `besttime_visit`  varchar(50)  NOT NULL,
    `whats_great`     text         NOT NULL,
    `local_food`      varchar(100) NOT NULL,
    `isdeleted`       bit(1)       NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_subplace`
--

INSERT INTO `tbl_subplace` (`subplace_id`, `place_id`, `subplace_name`, `city`, `upload_pic1`, `upload_pic2`,
                            `upload_pic3`, `tag_line`, `subplace_des`, `modes_transport`, `besttime_visit`,
                            `whats_great`, `local_food`, `isdeleted`)
VALUES (2, 37, 'Gandhi Ashram', 'Ahmedabad', 'gandhi1.jpg', 'gandhi2.jpg', 'gandhi3.jpg', 'Sabarmati Ashram',
        'On his return from South Africa, Gandhis first Ashram in India was established in the Kochrab area of Ahmedabad on 25 May 1915.',
        'Buses are run by the Gujarat State Road Transport Corporation.', 'June-December',
        'Our memorial museum contains a sizable collection of manuscripts of Gandhis writings during his stay in the Sabarmati Ashram ',
        'Gujarati Thali', b'0'),
       (3, 37, 'af', 'asf', 'c2.jpg', 'c3.jpg', 'profile.jpg', 'sdf', 'fsad', 'sdf', 'saddf', 'asf', 'saf', b'1'),
       (4, 37, 'Gandhi Ashram', 'visnagar', 'gandhi1.jpg', 'gandhi2.jpg', 'gandhi3.jpg', 'sdfd', 'sfd', 'sdf', 'saf',
        'sdfd', 'sfd', b'1'),
       (5, 38, 'Akshardham', 'gandhinagar', 'g....jpg', 'g....jpg', 'g....jpg', 'Best temple in gandhinagar',
        'very nice place to visit', 'bus,amts,brts', 'whole year', 'old monumnets,greenery', 'Gujarati Food', b'1'),
       (6, 38, 'Akshardham', 'gandhinagar', 'g....jpg', 'g....jpg', 'g....jpg', 'Best temple in gandhinagar',
        'very nice place to visit', 'bus,amts,brts', 'whole year', 'old monumnets,greenery', 'Gujarati Food', b'1'),
       (7, 38, 'Akshardham', 'gandhinagar', 'g....jpg', 'images (1).jpg', 'images.jpg', 'Best temple in gandhinagar',
        'very nice place to visit', 'bus,amts,brts', 'Whole year', 'old monumnets,greenery', 'Gujarati Food', b'0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `response`
--
ALTER TABLE `response`
    ADD PRIMARY KEY (`response_id`);

--
-- Indexes for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
    ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `tbl_hotel`
--
ALTER TABLE `tbl_hotel`
    ADD PRIMARY KEY (`hotel_id`);

--
-- Indexes for table `tbl_hotelbooking`
--
ALTER TABLE `tbl_hotelbooking`
    ADD PRIMARY KEY (`hotelbooking_id`);

--
-- Indexes for table `tbl_hotelpayment`
--
ALTER TABLE `tbl_hotelpayment`
    ADD PRIMARY KEY (`card_id`);

--
-- Indexes for table `tbl_login`
--
ALTER TABLE `tbl_login`
    ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table `tbl_package`
--
ALTER TABLE `tbl_package`
    ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `tbl_packagebooking`
--
ALTER TABLE `tbl_packagebooking`
    ADD PRIMARY KEY (`packagebooking_id`);

--
-- Indexes for table `tbl_packagepayment`
--
ALTER TABLE `tbl_packagepayment`
    ADD PRIMARY KEY (`card_id`);

--
-- Indexes for table `tbl_place`
--
ALTER TABLE `tbl_place`
    ADD PRIMARY KEY (`place_id`);

--
-- Indexes for table `tbl_rate`
--
ALTER TABLE `tbl_rate`
    ADD PRIMARY KEY (`ratings_id`);

--
-- Indexes for table `tbl_register`
--
ALTER TABLE `tbl_register`
    ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_subplace`
--
ALTER TABLE `tbl_subplace`
    ADD PRIMARY KEY (`subplace_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
    MODIFY `response_id` int (6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
    MODIFY `feedback_id` int (4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_hotel`
--
ALTER TABLE `tbl_hotel`
    MODIFY `hotel_id` int (4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_hotelbooking`
--
ALTER TABLE `tbl_hotelbooking`
    MODIFY `hotelbooking_id` int (4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_hotelpayment`
--
ALTER TABLE `tbl_hotelpayment`
    MODIFY `card_id` int (4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_login`
--
ALTER TABLE `tbl_login`
    MODIFY `login_id` int (10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_package`
--
ALTER TABLE `tbl_package`
    MODIFY `package_id` int (4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_packagebooking`
--
ALTER TABLE `tbl_packagebooking`
    MODIFY `packagebooking_id` int (4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_packagepayment`
--
ALTER TABLE `tbl_packagepayment`
    MODIFY `card_id` int (4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_place`
--
ALTER TABLE `tbl_place`
    MODIFY `place_id` int (4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tbl_rate`
--
ALTER TABLE `tbl_rate`
    MODIFY `ratings_id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_register`
--
ALTER TABLE `tbl_register`
    MODIFY `user_id` int (10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_subplace`
--
ALTER TABLE `tbl_subplace`
    MODIFY `subplace_id` int (4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
