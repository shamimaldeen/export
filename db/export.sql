-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2021 at 12:15 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `export`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_clients`
--

CREATE TABLE `ci_clients` (
  `client_id` int(11) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `client_address` varchar(100) NOT NULL,
  `postal_code` varchar(100) NOT NULL,
  `client_city` varchar(100) NOT NULL,
  `client_country` varchar(20) NOT NULL,
  `client_phone` varchar(100) NOT NULL,
  `client_fax` varchar(20) NOT NULL,
  `client_email` varchar(100) NOT NULL,
  `client_date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_clients`
--

INSERT INTO `ci_clients` (`client_id`, `client_name`, `client_address`, `postal_code`, `client_city`, `client_country`, `client_phone`, `client_fax`, `client_email`, `client_date_created`) VALUES
(1, 'jhon doe', 'Dhaka', 'fdsdf-65565', 'dhaka', 'BD', '5787484787', 'lkhjkhjk', 'jhon@gmail.com', '2021-04-22 00:00:00'),
(2, 'nick', 'mirpur', 'fdsf4584', 'dhaka', 'BD', '5246448', 'fdsfsdf', 'nick@gmail.com', '2021-04-22 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ci_config`
--

CREATE TABLE `ci_config` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `date_format` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_config`
--

INSERT INTO `ci_config` (`id`, `name`, `email`, `address`, `postal_code`, `fax`, `phone`, `website`, `currency`, `logo`, `date_format`) VALUES
(1, 'Test Company', 'test@gmail.com', '', '', '', '', '', '$', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ci_email_templates`
--

CREATE TABLE `ci_email_templates` (
  `template_id` int(11) NOT NULL,
  `template_title` varchar(200) NOT NULL,
  `email_body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_invoices`
--

CREATE TABLE `ci_invoices` (
  `invoice_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_status` enum('PAID','UNPAID','CANCELLED') NOT NULL DEFAULT 'UNPAID',
  `invoice_number` varchar(50) NOT NULL,
  `invoice_discount` double NOT NULL,
  `invoice_terms` longtext NOT NULL,
  `invoice_due_date` datetime NOT NULL,
  `invoice_date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_invoices`
--

INSERT INTO `ci_invoices` (`invoice_id`, `user_id`, `client_id`, `invoice_status`, `invoice_number`, `invoice_discount`, `invoice_terms`, `invoice_due_date`, `invoice_date_created`) VALUES
(1, 1, 1, 'UNPAID', '1', 1, 'something', '2021-04-22 00:00:00', '2021-04-22');

-- --------------------------------------------------------

--
-- Table structure for table `ci_invoice_items`
--

CREATE TABLE `ci_invoice_items` (
  `item_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `item_quantity` decimal(10,2) NOT NULL,
  `item_description` longtext NOT NULL,
  `item_taxrate_id` int(11) NOT NULL,
  `item_order` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `item_discount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_invoice_items`
--

INSERT INTO `ci_invoice_items` (`item_id`, `invoice_id`, `item_quantity`, `item_description`, `item_taxrate_id`, `item_order`, `item_name`, `item_price`, `item_discount`) VALUES
(1, 1, '1.00', 'about phone details', 0, 1, 'phone', '20000.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_payments`
--

CREATE TABLE `ci_payments` (
  `payment_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `payment_note` longtext NOT NULL,
  `payment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_payments`
--

INSERT INTO `ci_payments` (`payment_id`, `invoice_id`, `payment_method_id`, `payment_amount`, `payment_note`, `payment_date`) VALUES
(1, 1, 1, '9000.00', 'dfsf', '2021-04-22');

-- --------------------------------------------------------

--
-- Table structure for table `ci_payment_methods`
--

CREATE TABLE `ci_payment_methods` (
  `payment_method_id` int(11) NOT NULL,
  `payment_method_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_payment_methods`
--

INSERT INTO `ci_payment_methods` (`payment_method_id`, `payment_method_name`) VALUES
(1, 'Cash'),
(2, 'Bank');

-- --------------------------------------------------------

--
-- Table structure for table `ci_products`
--

CREATE TABLE `ci_products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_description` longtext NOT NULL,
  `product_unitprice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_products`
--

INSERT INTO `ci_products` (`product_id`, `product_name`, `product_description`, `product_unitprice`) VALUES
(1, 'phone', 'about phone details', '20000.00'),
(2, 'watch', 'About watch details', '1000.00'),
(3, 'Bag', 'About bag details', '5000.00');

-- --------------------------------------------------------

--
-- Table structure for table `ci_quotes`
--

CREATE TABLE `ci_quotes` (
  `quote_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `quote_subject` varchar(300) NOT NULL,
  `date_created` date NOT NULL,
  `valid_until` date NOT NULL,
  `quote_discount` double NOT NULL,
  `customer_notes` text NOT NULL,
  `quote_status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_quotes_items`
--

CREATE TABLE `ci_quotes_items` (
  `item_id` int(11) NOT NULL,
  `quote_id` int(11) NOT NULL,
  `item_name` varchar(300) NOT NULL,
  `item_description` text NOT NULL,
  `item_price` double NOT NULL,
  `item_quantity` double NOT NULL,
  `Item_tax_rate_id` int(11) NOT NULL,
  `item_discount` double NOT NULL,
  `item_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_tax_rates`
--

CREATE TABLE `ci_tax_rates` (
  `tax_rate_id` int(11) NOT NULL,
  `tax_rate_name` varchar(100) NOT NULL,
  `tax_rate_percent` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_users`
--

CREATE TABLE `ci_users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_phone` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_users`
--

INSERT INTO `ci_users` (`user_id`, `first_name`, `last_name`, `user_email`, `user_phone`, `username`, `password`, `user_date_created`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '', 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2021-04-22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_clients`
--
ALTER TABLE `ci_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `ci_config`
--
ALTER TABLE `ci_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_email_templates`
--
ALTER TABLE `ci_email_templates`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `ci_invoices`
--
ALTER TABLE `ci_invoices`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `ci_invoice_items`
--
ALTER TABLE `ci_invoice_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `ci_payments`
--
ALTER TABLE `ci_payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `ci_payment_methods`
--
ALTER TABLE `ci_payment_methods`
  ADD PRIMARY KEY (`payment_method_id`);

--
-- Indexes for table `ci_products`
--
ALTER TABLE `ci_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `ci_quotes`
--
ALTER TABLE `ci_quotes`
  ADD PRIMARY KEY (`quote_id`);

--
-- Indexes for table `ci_quotes_items`
--
ALTER TABLE `ci_quotes_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `ci_tax_rates`
--
ALTER TABLE `ci_tax_rates`
  ADD PRIMARY KEY (`tax_rate_id`);

--
-- Indexes for table `ci_users`
--
ALTER TABLE `ci_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ci_clients`
--
ALTER TABLE `ci_clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ci_config`
--
ALTER TABLE `ci_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_email_templates`
--
ALTER TABLE `ci_email_templates`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_invoices`
--
ALTER TABLE `ci_invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_invoice_items`
--
ALTER TABLE `ci_invoice_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_payments`
--
ALTER TABLE `ci_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_payment_methods`
--
ALTER TABLE `ci_payment_methods`
  MODIFY `payment_method_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ci_products`
--
ALTER TABLE `ci_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ci_quotes`
--
ALTER TABLE `ci_quotes`
  MODIFY `quote_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_quotes_items`
--
ALTER TABLE `ci_quotes_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_tax_rates`
--
ALTER TABLE `ci_tax_rates`
  MODIFY `tax_rate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_users`
--
ALTER TABLE `ci_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
