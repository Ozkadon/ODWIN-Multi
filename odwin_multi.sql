-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2018 at 10:05 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `odwin_multi`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_control`
--

CREATE TABLE `access_control` (
  `id` int(11) NOT NULL,
  `user_level_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `content` text,
  `user_modified` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `access_control`
--

INSERT INTO `access_control` (`id`, `user_level_id`, `module_id`, `content`, `user_modified`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'a', 1, '2017-10-17 09:26:05', '2017-10-17 09:26:05'),
(2, 1, 2, 'a', 1, '2017-10-17 09:26:05', '2017-10-17 09:26:05'),
(3, 1, 3, 'a', 1, '2017-10-17 09:26:05', '2017-10-17 09:26:05'),
(4, 2, 1, 'a', 1, '2017-10-17 09:26:13', '2018-07-31 06:25:46'),
(5, 2, 2, 'a', 1, '2017-10-17 09:26:13', '2018-07-31 06:25:46'),
(6, 2, 3, 'a', 1, '2017-10-17 09:26:13', '2018-07-31 06:25:46'),
(7, 3, 1, 'v', 1, '2017-10-17 09:26:18', '2018-06-03 06:05:32'),
(8, 3, 2, 'v', 1, '2017-10-17 09:26:18', '2018-06-03 06:05:32'),
(9, 3, 3, 'v', 1, '2017-10-17 09:26:18', '2018-06-03 06:05:32'),
(10, 1, 4, 'a', 1, '2018-06-03 07:37:38', '2018-06-03 07:37:38'),
(11, 2, 4, 'a', 1, '2018-06-03 07:37:41', '2018-07-31 06:25:46'),
(12, 3, 4, 'v', 1, '2018-06-03 07:37:43', '2018-06-03 07:37:43'),
(13, 1, 5, 'a', 1, '2018-06-05 07:40:07', '2018-06-05 07:40:07'),
(14, 2, 5, 'a', 1, '2018-06-05 07:40:10', '2018-07-31 06:25:46'),
(15, 3, 5, 'v', 1, '2018-06-05 07:40:13', '2018-06-05 07:40:13'),
(16, 1, 6, 'a', 1, '2018-06-05 12:37:21', '2018-06-05 12:37:21'),
(17, 2, 6, 'a', 1, '2018-06-05 12:37:24', '2018-07-31 06:25:46'),
(18, 3, 6, 'v', 1, '2018-06-05 12:37:27', '2018-06-05 12:37:27'),
(19, 1, 7, 'a', 1, '2018-07-31 06:25:43', '2018-07-31 06:25:43'),
(20, 1, 8, 'a', 1, '2018-07-31 06:25:43', '2018-07-31 06:25:43'),
(21, 2, 7, 'a', 1, '2018-07-31 06:25:46', '2018-07-31 06:25:46'),
(22, 2, 8, 'a', 1, '2018-07-31 06:25:46', '2018-07-31 06:25:46');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `featured_image` int(11) DEFAULT NULL,
  `slug` text,
  `category_id` int(11) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_modified` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `featured_image`, `slug`, `category_id`, `active`, `created_at`, `updated_at`, `user_modified`) VALUES
(1, 1, 'judul-indonesia', 1, 1, '2018-07-31 14:40:37', '2018-08-01 03:30:32', 2);

-- --------------------------------------------------------

--
-- Table structure for table `blog_language`
--

CREATE TABLE `blog_language` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) DEFAULT NULL,
  `judul` text,
  `detail` text,
  `caption_img` text,
  `language_code` varchar(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_language`
--

INSERT INTO `blog_language` (`id`, `blog_id`, `judul`, `detail`, `caption_img`, `language_code`, `created_at`, `updated_at`) VALUES
(1, 1, 'Judul English', '<p>Content English</p>\r\n', 'Caption English', 'EN', '2018-07-31 14:40:37', '2018-07-31 14:40:37'),
(2, 1, 'Judul Indonesia', '<p>Content Indonesia</p>\r\n', 'Caption Indonesia', 'ID', '2018-07-31 14:40:37', '2018-07-31 14:40:37');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `active` int(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_modified` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `active`, `created_at`, `updated_at`, `user_modified`) VALUES
(1, 1, '2018-07-31 07:03:30', '2018-07-31 07:03:30', 1),
(3, 1, '2018-07-31 07:24:33', '2018-07-31 07:42:29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category_language`
--

CREATE TABLE `category_language` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(300) DEFAULT NULL,
  `language_code` varchar(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_language`
--

INSERT INTO `category_language` (`id`, `category_id`, `name`, `language_code`, `created_at`, `updated_at`) VALUES
(1, 1, 'Category A', 'EN', '2018-07-31 07:03:48', '2018-07-31 07:03:48'),
(2, 1, 'Kategori A', 'ID', '2018-07-31 07:03:48', '2018-07-31 07:03:48'),
(3, 3, 'Category B', 'EN', '2018-07-31 07:24:33', '2018-07-31 07:24:33'),
(4, 3, 'Kategori B', 'ID', '2018-07-31 07:24:33', '2018-07-31 07:24:33');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `address` text,
  `email` varchar(100) DEFAULT NULL,
  `contact` varchar(45) DEFAULT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `read` int(1) DEFAULT NULL,
  `active` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `code` varchar(5) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `default` int(1) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_modified` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `code`, `name`, `default`, `active`, `created_at`, `updated_at`, `user_modified`) VALUES
(1, 'EN', 'English', 0, 1, '2018-07-23 07:23:15', '2018-07-31 13:10:15', 1),
(2, 'ID', 'Indonesia', 1, 1, '2018-07-23 07:23:15', '2018-07-31 13:10:15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `media_library`
--

CREATE TABLE `media_library` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `url` varchar(300) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `media_library`
--

INSERT INTO `media_library` (`id`, `name`, `type`, `url`, `size`, `user_created`, `created_at`, `updated_at`) VALUES
(0, 'noprofileimage', 'png', 'img/noprofileimage.png', '1159', 1, '2017-05-29 19:56:03', '2017-05-29 19:56:03');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `slug` varchar(20) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `user_modified` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `slug`, `active`, `user_modified`, `created_at`, `updated_at`) VALUES
(1, 'Master User Level', 'users-level', 1, 1, '2017-10-17 07:07:07', '2017-10-17 07:43:43'),
(2, 'Master User', 'users-user', 1, 1, '2017-10-17 07:16:51', '2017-10-17 07:49:30'),
(3, 'Media Library', 'media-library', 1, 1, '2017-10-17 07:19:28', '2018-06-03 05:40:18'),
(4, 'Gallery Photos', 'photos', 1, 1, '2018-06-03 07:37:29', '2018-06-03 07:37:29'),
(5, 'Inbox', 'contact-inbox', 1, 1, '2018-06-05 07:39:59', '2018-06-05 07:39:59'),
(6, 'Pages', 'pages', 1, 1, '2018-06-05 12:37:04', '2018-06-05 12:37:04'),
(7, 'Blog - Category', 'blog-category', 1, 1, '2018-07-31 06:25:24', '2018-07-31 06:25:24'),
(8, 'Blog - Content', 'blog-content', 1, 1, '2018-07-31 06:25:34', '2018-07-31 06:25:34');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `featured_image` int(11) DEFAULT NULL,
  `slug` text,
  `active` int(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_modified` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pages_language`
--

CREATE TABLE `pages_language` (
  `id` int(11) NOT NULL,
  `pages_id` int(11) DEFAULT NULL,
  `judul` varchar(200) DEFAULT NULL,
  `detail` text,
  `caption_img` text,
  `language_code` varchar(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `active` int(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_modified` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photos_detail`
--

CREATE TABLE `photos_detail` (
  `id` int(11) NOT NULL,
  `photos_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photos_language`
--

CREATE TABLE `photos_language` (
  `id` int(11) NOT NULL,
  `photos_id` int(11) NOT NULL,
  `judul` varchar(150) DEFAULT NULL,
  `language_code` varchar(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `value` text,
  `user_modified` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `user_modified`, `created_at`, `updated_at`) VALUES
(1, 'web_title', 'ODWin CMS', 2, '2017-06-13 00:27:16', '2018-07-31 13:10:15'),
(2, 'logo', 'img/logo.png', 1, '2017-06-13 00:27:16', '2018-06-03 05:58:24'),
(3, 'email_admin', 'admin@admin.com', 2, '2017-06-13 00:27:16', '2018-07-31 13:10:15'),
(4, 'web_description', 'Website Description', 2, '2017-07-23 23:56:28', '2018-07-31 13:10:15'),
(5, 'multi_language', '1', 1, '2017-07-23 23:56:28', '2018-07-24 11:45:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_level_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `avatar_id` int(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `address` text,
  `phone` text,
  `gender` enum('male','female','other') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` int(1) NOT NULL,
  `user_modified` int(11) DEFAULT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_level_id`, `firstname`, `lastname`, `avatar_id`, `email`, `address`, `phone`, `gender`, `birthdate`, `username`, `password`, `active`, `user_modified`, `last_activity`, `created_at`, `updated_at`) VALUES
(1, 1, 'Super', 'Admin', 0, 'superadmin@admin.com', 'Jl Madura xxxxxxx', '08383xxxxxxx', 'male', '1986-07-25', 'superadmin', '$2y$10$TkX/dDYrtvIEXidPOag5T.V8qbyluUHJg5ssBjKe6WlVqpItuN8uy', 1, 1, '2018-07-31 03:23:20', '2017-03-13 20:51:35', '2018-07-31 03:23:20'),
(2, 2, 'Admin', 'Admin', 0, 'admin@admin.com', NULL, NULL, 'male', NULL, 'admin', '$2y$10$PQaUY4b0YsSo5qAuK8Cc.OB.WeEJHrJJ0FDgk6YE9xhXboVRou3We', 1, 1, '2018-10-17 08:03:41', '2017-04-19 14:29:01', '2018-10-17 08:03:41');

-- --------------------------------------------------------

--
-- Table structure for table `user_levels`
--

CREATE TABLE `user_levels` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `active` int(1) DEFAULT NULL,
  `user_modified` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_levels`
--

INSERT INTO `user_levels` (`id`, `name`, `active`, `user_modified`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 1, 1, '2017-06-28 06:18:17', '2017-06-28 06:18:17'),
(2, 'Admin', 1, 1, '2018-06-02 15:59:51', '2018-06-02 15:59:51'),
(3, 'User', 1, 1, '2018-06-03 04:19:49', '2018-06-03 04:19:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_control`
--
ALTER TABLE `access_control`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_language`
--
ALTER TABLE `blog_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_language`
--
ALTER TABLE `category_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_library`
--
ALTER TABLE `media_library`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages_language`
--
ALTER TABLE `pages_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photos_detail`
--
ALTER TABLE `photos_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photos_language`
--
ALTER TABLE `photos_language`
  ADD PRIMARY KEY (`id`,`photos_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_levels`
--
ALTER TABLE `user_levels`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_control`
--
ALTER TABLE `access_control`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog_language`
--
ALTER TABLE `blog_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category_language`
--
ALTER TABLE `category_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `media_library`
--
ALTER TABLE `media_library`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages_language`
--
ALTER TABLE `pages_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `photos_detail`
--
ALTER TABLE `photos_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `photos_language`
--
ALTER TABLE `photos_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_levels`
--
ALTER TABLE `user_levels`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
