-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 05, 2018 at 04:11 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rms`
--

-- --------------------------------------------------------

--
-- Table structure for table `billing_details`
--

CREATE TABLE IF NOT EXISTS `billing_details` (
  `billing_id` int(10) NOT NULL AUTO_INCREMENT,
  `member_id` int(15) NOT NULL,
  `Street_Address` varchar(100) NOT NULL,
  `P_O_Box_No` varchar(15) NOT NULL,
  `City` text NOT NULL,
  `Mobile_No` varchar(15) NOT NULL,
  `Landline_No` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`billing_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `billing_details`
--

INSERT INTO `billing_details` (`billing_id`, `member_id`, `Street_Address`, `P_O_Box_No`, `City`, `Mobile_No`, `Landline_No`) VALUES
(8, 15, 'fagba,Lagos', '7502', 'Lagos', '08022233344', '013455678'),
(9, 16, 'Street 234', '12345', 'Lahore', '8765', '45'),
(10, 17, 'street No 3', '1234', 'Jhelum', '03456648545', '4857458475');

-- --------------------------------------------------------

--
-- Table structure for table `cart_details`
--

CREATE TABLE IF NOT EXISTS `cart_details` (
  `cart_id` int(15) NOT NULL AUTO_INCREMENT,
  `member_id` int(15) NOT NULL,
  `food_id` int(15) NOT NULL,
  `quantity_id` int(15) NOT NULL,
  `total` float NOT NULL,
  `flag` int(1) NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `cart_details`
--

INSERT INTO `cart_details` (`cart_id`, `member_id`, `food_id`, `quantity_id`, `total`, `flag`) VALUES
(25, 16, 33, 34, 250, 1),
(26, 16, 32, 36, 300, 0),
(28, 17, 31, 33, 500, 0),
(29, 17, 33, 34, 250, 0),
(35, 16, 42, 37, 360, 1),
(36, 16, 34, 35, 500, 1),
(37, 16, 49, 34, 450, 1),
(38, 16, 31, 34, 100, 1),
(39, 16, 32, 34, 100, 1),
(40, 16, 42, 34, 90, 1),
(41, 16, 31, 34, 100, 0),
(42, 16, 31, 34, 100, 1),
(43, 16, 31, 34, 100, 0),
(44, 16, 38, 34, 80, 0),
(45, 16, 31, 34, 100, 0),
(46, 16, 69, 34, 30, 0),
(47, 16, 31, 34, 100, 0),
(48, 16, 38, 34, 80, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(15) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(45) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(17, 'Burgers'),
(18, 'Drinks'),
(20, 'Pizza'),
(21, 'Apitizerss'),
(22, 'Salad'),
(23, 'Sandwiches'),
(24, 'Sharings'),
(25, 'Snacks'),
(26, 'Soup');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE IF NOT EXISTS `currencies` (
  `currency_id` int(5) NOT NULL AUTO_INCREMENT,
  `currency_symbol` varchar(15) NOT NULL,
  `flag` int(1) NOT NULL,
  PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`currency_id`, `currency_symbol`, `flag`) VALUES
(7, 'PKR', 1),
(9, '$', 0);

-- --------------------------------------------------------

--
-- Table structure for table `food_details`
--

CREATE TABLE IF NOT EXISTS `food_details` (
  `food_id` int(15) NOT NULL AUTO_INCREMENT,
  `food_name` varchar(45) NOT NULL,
  `food_description` text NOT NULL,
  `food_price` float NOT NULL,
  `food_photo` varchar(45) NOT NULL,
  `food_category` int(15) NOT NULL,
  PRIMARY KEY (`food_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

--
-- Dumping data for table `food_details`
--

INSERT INTO `food_details` (`food_id`, `food_name`, `food_description`, `food_price`, `food_photo`, `food_category`) VALUES
(31, 'Crunch Burger', 'Crunch Burger	Enjoy a crispy crunchy chicken fillet on a bed of lettuce with a soft bun, topped with spicy mayo and the signature sauce', 100, 'CB.jpg', 17),
(32, 'Mighty Zinger', 'Delicious pieces of juicy chicken thigh with SR Spicy Zinger Recipe, cheese, fresh lettuce in a fresh round bun sure but ''Mightier'' to suit your major hunger.', 100, 'Mighty_Zinger.jpg', 17),
(33, 'Twisted Burger', 'Two delicious 100% breast fillet Crispy Strips and fresh salad topped with pepper mayo and all wrapped in a soft warmed tortilla', 250, 'Twisted_Burger.jpg', 17),
(34, 'Value Burger', 'Imagine a soft sesame bun with a crunchy chicken strips in the center with lettuce and spicy mayo, at a great value!', 250, 'Value_Burger.jpg', 17),
(35, 'Zinger Stacker', 'Marinated fillets with our signature spicy sauce,cheese,and loaded with jalapenos,all of this wrapped in a new bun', 420, 'Zinger_Stacker.jpg', 17),
(36, 'Zinger', 'Delicious pieces of juicy chicken thigh with SR Spicy Zinger Recipe, fresh lettuce in a fresh round bun.having fresh salad in it.', 390, 'Zinger.jpg', 17),
(37, '7UP', '', 80, '7up_Lemon.jpg', 18),
(38, 'Diet 7UP', '', 80, '7up.jpg', 18),
(39, 'Mirinda', '', 80, 'Marinda.jpg', 18),
(40, 'Pepsi', '', 80, 'Pepsi.jpg', 18),
(41, 'Diet Pepsi', '', 80, 'Diet_Pepsi.jpg', 18),
(42, 'Mountain Dew', '', 90, 'Mtn_Dew.jpg', 18),
(43, 'Mineral Water', '', 60, 'Mineral_Water.jpg', 18),
(44, 'All MEAT', 'Pepperoni, Ham, Italian Sausage, Ground Beef, Black Olives, Mushrooms & Mozzarella with Marinara Sauce', 500, 'All_MEAT.jpg', 20),
(45, 'BBQ Combo', 'Pepperoni, Grilled Chicken, Bacon, Red Onions, Mozzarella with BBQ Sauce topped with Parsley.This is One of our Special Dish.', 500, 'BBQ_Combo.jpg', 20),
(46, 'CHEF MISTAKE', 'Pepperoni, Grilled Chicken, Grilled Steak, Bacon, Red Peppers & Mozzarella , Marinara Sauce topped with Fresh Cilantro', 490, 'CHEF_MISTAKE.jpg', 20),
(47, 'MAMA MIA', 'Pepperoni, Canadian Bacon, Italian Sausage, Cacon, Mozzarella with Marinara Sauc', 270, 'MAMA_MIA.jpg', 20),
(48, 'PEPPERONI DELUX', 'Double Pepperoni, Double Mozzarella with Marinara Sauce', 700, 'PEPPERONI_DELUX.jpg', 20),
(49, 'PEPPERONI SUPREME', 'Pepperoni, Ham , Italian Sausage , Black Olives , Feta & Mozzarella with Marinara Sauce', 450, 'PEPPERONI_SUPREME.jpg', 20),
(50, 'Super Hawaiian', 'Double Canadian Bacon, Double Pineapple & Double Mozzarella with Marinara Sauce', 720, 'Super_Hawaiian.jpg', 20),
(51, 'Dinner Salad', 'Lettuce, Tomatoes & your choice of dressing.chock_full seasonal variables. ', 60, 'salad.jpg', 22),
(52, 'Antipasto', 'Lettuce, Pepperoni, Ham, Black Olives, Green Peppers, Onions, Tomatoes & Mozzarella', 60, 'Antipasto.jpg', 22),
(53, 'Chicken Santa ff', 'Grilled Chicken, Romaine Lettuce,Tomatoes, Sour Cream, Salsa & Tortilla Chip', 90, 'Chicken_Santa_ff.jpg', 22),
(54, 'Classic Caesar', 'Romaine Lettuce, Parmesan, Croutons tossed in Caesar dressing', 60, 'Classic_Caesar.jpg', 22),
(55, 'Greek', 'Lettuce, Black Olives, Green Peppers, Onions,Tomatoes & Feta Cheese', 70, 'Greek.jpg', 22),
(56, 'Spinach Blue Cheese', 'Spinach, Croutons, Cucumbers, Tomatoes,Onions & Blue Cheese dressing', 80, 'SPINACH_BLUE_CHEESE.jpg', 22),
(57, 'Chicken Gyro Sandwich', 'Grilled Chicken on a Pita Bread with Lettuce, Tomatoes, Red Onions & Ranch dressing.', 90, 'Chicken_Gyro_Sandwich.jpg', 23),
(58, 'Gyro Sandvices', 'Sliced Lamb on a Pita Bread with Lettuce, Tomatoes, Red Onions & Tzajiki Sauce.', 60, 'Gyro_Sandvices.jpg', 23),
(59, 'HAm and Cheese', 'Ham with Mozzarella, Lettuce, Tomatoes & Mayonnaise', 70, 'HAN_and_Cheese.jpg', 23),
(60, 'Italian Parmesan', 'Pepperoni, Italian Susage, Shredded Parmesan, Mozzarella & Marinara Sauce', 100, 'ITTALIAN_PARMESAN.jpg', 23),
(61, 'Meatball Parmesan', 'Meatballs with Shredded Parmesan, Mozzarella, & Marinara Sauce', 125, 'Meatball_Parmesan.jpg', 23),
(62, 'Submarine', 'Pepperoni, Ham, Mozzarella, Lettuce, Tomatoes & Mayonnaise', 150, 'Submarine.jpg', 23),
(63, 'Chiken Chips', '', 100, 'Chiken_Chips.jpg', 24),
(64, 'Krunch Burger with Drink', '', 140, 'Krunch_Burger_with_Drink.jpg', 24),
(65, 'My 5', '', 135, 'My_5.jpg', 24),
(66, 'Zinger Strips Deals', '', 190, 'Zinger_Strips_Deals.jpg', 24),
(67, 'Arabian Rice', '', 150, 'Arabian_Rice.jpg', 25),
(68, 'Chicken Piece', '', 140, 'Chicken_Piece.jpg', 25),
(69, 'Corn on Cob', '', 30, 'Corn_on_Cob.jpg', 25),
(70, 'Dinner Roll', '', 90, 'Dinner_Roll.jpg', 25),
(71, 'Nuggets 9 Pcs', '', 140, 'Nuggets_9_Pcs.jpg', 25),
(72, 'Nuggets 6 pcs', '', 90, 'Nuggets_6_pcs.jpg', 25),
(73, 'Chiken_Chips', '', 240, 'Chiken_Chips.jpg', 24);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `member_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `login` varchar(100) NOT NULL DEFAULT '',
  `passwd` varchar(32) NOT NULL DEFAULT '',
  `question_id` int(5) NOT NULL,
  `answer` varchar(45) NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `firstname`, `lastname`, `login`, `passwd`, `question_id`, `answer`) VALUES
(16, 'Majid', 'Mehmood', 'a@gmail.com', '202cb962ac59075b964b07152d234b70', 9, 'c870435426cc2858312a3309a31b4d4e'),
(17, 'Mehboob', 'Elahi', 'mehboobelahi433@yahoo.com', '202cb962ac59075b964b07152d234b70', 8, '2c6aa94339438f8af00a2ccd2aa6dbb8'),
(19, 'Muhammad', 'Mehboob', 'mehboobelahi10@yahoo.com', '81dc9bdb52d04dc20036dbd8313ed055', 8, 'c2498c322967ff7a87c7e9734feecc60'),
(25, 'AAA', 'BB', 'aabb@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 11, '86318e52f5ed4801abe1d13d509443de'),
(21, 'Ali', 'Raza', 'aliraza@gmail.com', '15de21c670ae7c3f6f3f1f37029303c9', 9, 'f04af61b3f332afa0ceec786a42cd365'),
(24, 'Majid', 'Ali', 'ma@gmail.com', '202cb962ac59075b964b07152d234b70', 11, '900150983cd24fb0d6963f7d28e17f72'),
(26, 'Maji', 'Khan', 'maj@gmail.com', '202cb962ac59075b964b07152d234b70', 10, 'd09911b99d69f98825259edfe6ec0b17');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(15) NOT NULL AUTO_INCREMENT,
  `message_from` varchar(25) NOT NULL,
  `message_date` date NOT NULL,
  `message_time` time NOT NULL,
  `message_subject` text NOT NULL,
  `message_text` text NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `message_from`, `message_date`, `message_time`, `message_subject`, `message_text`) VALUES
(4, 'administrator', '2018-01-26', '06:26:10', 'Testing', 'Hi, i am testing the system . Dont worry about ths message'),
(5, 'administrator', '2018-02-06', '08:09:06', 'aaaaaaaaaaaa', 'sssssssssssssssssssssssssssssssssssssssssssssss');

-- --------------------------------------------------------

--
-- Table structure for table `orders_details`
--

CREATE TABLE IF NOT EXISTS `orders_details` (
  `order_id` int(10) NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL,
  `billing_id` int(10) NOT NULL,
  `cart_id` int(15) NOT NULL,
  `delivery_date` date NOT NULL,
  `StaffID` int(15) NOT NULL,
  `flag` int(1) NOT NULL,
  `time_stamp` time NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `orders_details`
--

INSERT INTO `orders_details` (`order_id`, `member_id`, `billing_id`, `cart_id`, `delivery_date`, `StaffID`, `flag`, `time_stamp`) VALUES
(22, 16, 9, 11, '2018-02-17', 8, 1, '09:12:36'),
(23, 16, 9, 12, '2018-02-17', 8, 1, '10:13:49'),
(25, 17, 10, 19, '2018-02-17', 0, 0, '11:11:54'),
(26, 17, 10, 10, '2018-02-17', 0, 0, '13:45:20'),
(27, 16, 9, 24, '2018-03-05', 0, 0, '15:42:43'),
(28, 16, 9, 25, '2018-04-20', 8, 1, '04:20:37'),
(29, 16, 9, 26, '2018-04-24', 0, 0, '11:37:31'),
(34, 16, 9, 36, '2018-04-24', 9, 1, '13:31:50'),
(35, 16, 9, 35, '2018-04-24', 0, 0, '13:39:37'),
(36, 16, 9, 39, '2018-04-25', 0, 0, '12:01:08'),
(37, 16, 9, 42, '2018-04-25', 0, 0, '20:29:08'),
(38, 16, 9, 40, '2018-04-26', 0, 0, '07:29:31');

-- --------------------------------------------------------

--
-- Table structure for table `partyhalls`
--

CREATE TABLE IF NOT EXISTS `partyhalls` (
  `partyhall_id` int(5) NOT NULL AUTO_INCREMENT,
  `partyhall_name` varchar(45) NOT NULL,
  PRIMARY KEY (`partyhall_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `partyhalls`
--

INSERT INTO `partyhalls` (`partyhall_id`, `partyhall_name`) VALUES
(3, 'Room 1'),
(4, 'Room 2'),
(6, 'Room 3'),
(7, 'Room 5'),
(8, 'Room 4');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `txn_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_gross` float(10,2) NOT NULL,
  `currency_code` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `payment_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pizza_admin`
--

CREATE TABLE IF NOT EXISTS `pizza_admin` (
  `Admin_ID` int(45) NOT NULL AUTO_INCREMENT,
  `Username` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL,
  PRIMARY KEY (`Admin_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `pizza_admin`
--

INSERT INTO `pizza_admin` (`Admin_ID`, `Username`, `Password`) VALUES
(3, 'admin', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `polls_details`
--

CREATE TABLE IF NOT EXISTS `polls_details` (
  `poll_id` int(15) NOT NULL AUTO_INCREMENT,
  `member_id` int(15) NOT NULL,
  `food_id` int(15) NOT NULL,
  `rate_id` int(5) NOT NULL,
  PRIMARY KEY (`poll_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `polls_details`
--

INSERT INTO `polls_details` (`poll_id`, `member_id`, `food_id`, `rate_id`) VALUES
(32, 19, 31, 7),
(31, 16, 33, 6),
(30, 16, 31, 8),
(33, 19, 33, 6),
(36, 16, 38, 8),
(37, 16, 39, 6);

-- --------------------------------------------------------

--
-- Table structure for table `quantities`
--

CREATE TABLE IF NOT EXISTS `quantities` (
  `quantity_id` int(5) NOT NULL AUTO_INCREMENT,
  `quantity_value` int(5) NOT NULL,
  PRIMARY KEY (`quantity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `quantities`
--

INSERT INTO `quantities` (`quantity_id`, `quantity_value`) VALUES
(33, 5),
(34, 1),
(35, 2),
(36, 3),
(37, 4),
(38, 10);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `question_id` int(5) NOT NULL AUTO_INCREMENT,
  `question_text` text NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question_text`) VALUES
(8, 'what is your maiden name?'),
(9, 'who is your first girlfriend?'),
(10, 'Which first book you read?'),
(11, 'What is your best friend name?');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `rate_id` int(5) NOT NULL AUTO_INCREMENT,
  `rate_name` varchar(15) NOT NULL,
  PRIMARY KEY (`rate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`rate_id`, `rate_name`) VALUES
(6, 'Excellent'),
(7, 'Good'),
(8, 'Average'),
(9, 'Bad'),
(10, 'Worse');

-- --------------------------------------------------------

--
-- Table structure for table `reservations_details`
--

CREATE TABLE IF NOT EXISTS `reservations_details` (
  `ReservationID` int(15) NOT NULL AUTO_INCREMENT,
  `member_id` int(15) NOT NULL,
  `table_id` int(5) NOT NULL,
  `partyhall_id` int(5) NOT NULL,
  `Reserve_Date` date NOT NULL,
  `Reserve_Time` time NOT NULL,
  `StaffID` int(15) NOT NULL,
  `flag` int(1) NOT NULL,
  `table_flag` int(1) NOT NULL,
  `partyhall_flag` int(1) NOT NULL,
  PRIMARY KEY (`ReservationID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `reservations_details`
--

INSERT INTO `reservations_details` (`ReservationID`, `member_id`, `table_id`, `partyhall_id`, `Reserve_Date`, `Reserve_Time`, `StaffID`, `flag`, `table_flag`, `partyhall_flag`) VALUES
(51, 16, 16, 0, '2018-05-29', '04:15:00', 0, 0, 1, 0),
(49, 16, 15, 0, '2018-05-30', '04:30:00', 0, 0, 1, 0),
(41, 16, 21, 0, '2018-05-25', '04:30:00', 0, 0, 1, 0),
(42, 16, 0, 3, '2018-05-25', '05:30:00', 0, 0, 0, 1),
(48, 16, 0, 4, '2018-05-25', '05:30:00', 0, 0, 0, 1),
(50, 16, 0, 8, '2018-05-24', '17:30:00', 0, 0, 0, 1),
(52, 16, 20, 0, '2018-05-31', '05:30:00', 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `specials`
--

CREATE TABLE IF NOT EXISTS `specials` (
  `special_id` int(15) NOT NULL AUTO_INCREMENT,
  `special_name` varchar(25) NOT NULL,
  `special_description` text NOT NULL,
  `special_price` float NOT NULL,
  `special_start_date` date NOT NULL,
  `special_end_date` date NOT NULL,
  `special_photo` varchar(45) NOT NULL,
  PRIMARY KEY (`special_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `specials`
--

INSERT INTO `specials` (`special_id`, `special_name`, `special_description`, `special_price`, `special_start_date`, `special_end_date`, `special_photo`) VALUES
(7, 'Bhook Mitao', 'This is our special deal for students.', 250, '2018-02-18', '2018-02-20', 'images.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `StaffID` int(15) NOT NULL AUTO_INCREMENT,
  `First_Name` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(50) NOT NULL,
  `Street_Address` text NOT NULL,
  `Mobile_Tel` varchar(20) NOT NULL,
  `longitude` varchar(30) NOT NULL,
  `latitude` varchar(30) NOT NULL,
  PRIMARY KEY (`StaffID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`StaffID`, `First_Name`, `lastname`, `email`, `password`, `Street_Address`, `Mobile_Tel`, `longitude`, `latitude`) VALUES
(8, 'John', 'Viliam', 'majid@gmail.com', '12345', 'xyz street Califoronia', '0345569657', '74.2076925', '32.3615605'),
(9, 'Stephen', 'rOY', 'example@gmail.com', '1234', 'VPO Pindi saidpur Jhelum', '12345678', '73.3296728', '32.6705472');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE IF NOT EXISTS `tables` (
  `table_id` int(5) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(45) NOT NULL,
  PRIMARY KEY (`table_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`table_id`, `table_name`) VALUES
(15, 'T 1'),
(16, 'T 2'),
(17, 'T 3'),
(18, 'T 4'),
(19, 'T 5'),
(20, 'T 6'),
(21, 'T 7'),
(22, 'T 8');

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE IF NOT EXISTS `timezones` (
  `timezone_id` int(5) NOT NULL AUTO_INCREMENT,
  `timezone_reference` varchar(45) NOT NULL,
  `flag` int(1) NOT NULL,
  PRIMARY KEY (`timezone_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`timezone_id`, `timezone_reference`, `flag`) VALUES
(1, 'GMT', 0),
(2, 'GMT-02', 0),
(3, '1', 1),
(4, '2', 0),
(5, '3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
