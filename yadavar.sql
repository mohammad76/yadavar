-- Adminer 4.6.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `abilities`;
CREATE TABLE `abilities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entity_id` int(10) unsigned DEFAULT NULL,
  `entity_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `only_owned` tinyint(1) NOT NULL DEFAULT '0',
  `options` json DEFAULT NULL,
  `scope` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `abilities_scope_index` (`scope`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `articles` (`id`, `title`, `body`, `user_id`, `extra`, `created_at`, `updated_at`) VALUES
(1,	'چگونه سایتی جذاب داشته باشیم ؟',	'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.',	1,	NULL,	'2019-06-19 17:29:43',	'2019-06-19 17:29:43');

DROP TABLE IF EXISTS `assigned_roles`;
CREATE TABLE `assigned_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `entity_id` int(10) unsigned NOT NULL,
  `entity_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `restricted_to_id` int(10) unsigned DEFAULT NULL,
  `restricted_to_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scope` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assigned_roles_entity_index` (`entity_id`,`entity_type`,`scope`),
  KEY `assigned_roles_role_id_index` (`role_id`),
  KEY `assigned_roles_scope_index` (`scope`),
  CONSTRAINT `assigned_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `comments` (`id`, `article_id`, `name`, `email`, `body`, `created_at`, `updated_at`) VALUES
(1,	1,	'محمد',	'mohammad_m69@yahoo.com',	'عالی بود',	'2019-06-19 17:30:08',	'2019-06-19 17:30:08');

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('yearly','monthly','daily','hourly','exact') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `remind_at` datetime NOT NULL,
  `remind_time` varchar(255) CHARACTER SET utf8 NOT NULL,
  `person_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `last_send_at` datetime DEFAULT NULL,
  `last_remind_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `events` (`id`, `name`, `type`, `date`, `remind_at`, `remind_time`, `person_id`, `user_id`, `status`, `extra`, `last_send_at`, `last_remind_at`, `created_at`, `updated_at`) VALUES
(14,	'تولد',	'yearly',	'2019-06-29',	'2019-06-29 00:00:00',	'0',	9,	3,	'1',	'a:3:{s:13:\"yearly_period\";s:1:\"1\";s:8:\"send-sms\";b:1;s:8:\"sms-text\";s:30:\"سلام تولدت مبارک\";}',	NULL,	NULL,	'2019-06-29 15:14:33',	'2019-07-02 11:12:37'),
(15,	'تولد',	'yearly',	'2019-07-09',	'2019-07-03 00:00:00',	'0',	9,	3,	'1',	'a:3:{s:13:\"yearly_period\";s:1:\"1\";s:8:\"send-sms\";b:1;s:8:\"sms-text\";s:19:\"سلام داداش\";}',	NULL,	NULL,	'2019-06-29 15:21:59',	'2019-07-02 11:12:37'),
(16,	'تولد',	'yearly',	'2017-07-02',	'2017-07-02 00:00:00',	'0',	9,	3,	'1',	'a:6:{s:13:\"yearly_period\";s:1:\"1\";s:8:\"send-sms\";b:1;s:8:\"sms-text\";s:32:\"سلطان تولدت مبارک\";s:12:\"remind_email\";b:1;s:10:\"remind_sms\";b:1;s:18:\"remind_description\";s:23:\"اینم توضیحات\";}',	'2019-07-02 16:30:33',	'2019-07-02 16:30:33',	'2019-07-02 10:32:48',	'2019-07-02 12:00:33'),
(19,	'قسط ماشین',	'monthly',	'1398-04-11',	'1398-04-11 00:00:00',	'0',	9,	3,	'1',	'a:6:{s:14:\"monthly_period\";s:1:\"1\";s:8:\"send-sms\";b:0;s:8:\"sms-text\";N;s:12:\"remind_email\";b:0;s:10:\"remind_sms\";b:1;s:18:\"remind_description\";s:31:\"این توض قسط ماشین\";}',	'2019-07-02 17:12:11',	'2019-07-02 17:19:41',	'2019-07-02 12:33:19',	'2019-07-02 12:49:41'),
(20,	'قرص',	'daily',	'2019-07-03',	'2019-07-03 12:37:49',	'0',	9,	3,	'1',	'a:7:{s:12:\"daily_period\";a:2:{i:0;s:1:\"0\";i:1;s:1:\"4\";}s:10:\"daily_hour\";s:2:\"12\";s:8:\"send-sms\";b:1;s:8:\"sms-text\";s:10:\"سشسشس\";s:12:\"remind_email\";b:1;s:10:\"remind_sms\";b:1;s:18:\"remind_description\";s:26:\"قرص معده بخورم\";}',	'2019-07-03 12:56:01',	'2019-07-03 12:56:01',	'2019-07-03 08:07:49',	'2019-07-03 08:26:01'),
(23,	'قرص سرماخوردگی',	'hourly',	'2019-07-03',	'2019-07-03 18:42:16',	'0',	9,	3,	'1',	'a:6:{s:13:\"hourly_period\";s:1:\"2\";s:8:\"send-sms\";b:1;s:8:\"sms-text\";s:25:\"قرص بخورررررر\";s:12:\"remind_email\";b:0;s:10:\"remind_sms\";b:1;s:18:\"remind_description\";s:17:\"قرص مامان\";}',	'2019-07-05 14:56:49',	'2019-07-05 14:56:50',	'2019-07-03 14:12:16',	'2019-07-05 10:26:50'),
(27,	'تولد',	'yearly',	'2019-10-10',	'2019-10-09 00:00:00',	'0',	10,	3,	'1',	'a:6:{s:13:\"yearly_period\";s:1:\"1\";s:8:\"send-sms\";b:1;s:8:\"sms-text\";s:23:\"داداش مبارکه\";s:12:\"remind_email\";b:0;s:10:\"remind_sms\";b:1;s:18:\"remind_description\";s:12:\"بیسبسب\";}',	NULL,	NULL,	'2019-07-09 13:26:23',	'2019-07-09 13:26:23');

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `event_id` bigint(20) NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `messages` (`id`, `user_id`, `event_id`, `mobile`, `body`, `extra`, `created_at`, `updated_at`) VALUES
(1,	3,	16,	'a:1:{i:0;s:11:\"09352864812\";}',	'سلطان تولدت مبارک',	NULL,	'2019-07-02 12:00:33',	'2019-07-02 12:00:33'),
(2,	3,	16,	'a:1:{i:0;s:11:\"09352864812\";}',	'یادوآوری رویداد تولد\nفرد مرتبط: محمد عبدی\nتوضیحات: اینم توضیحات',	NULL,	'2019-07-02 12:00:33',	'2019-07-02 12:00:33'),
(3,	3,	18,	'a:1:{i:0;s:11:\"09352864812\";}',	'1',	NULL,	'2019-07-02 12:31:04',	'2019-07-02 12:31:04'),
(4,	3,	19,	'a:1:{i:0;s:11:\"09352864812\";}',	'یادوآوری رویداد قسط ماشین\nفرد مرتبط: محمد عبدی\nتوضیحات: این توض قسط ماشین',	NULL,	'2019-07-02 12:49:41',	'2019-07-02 12:49:41'),
(5,	3,	20,	'a:1:{i:0;s:11:\"09352864812\";}',	'سشسشس',	NULL,	'2019-07-03 08:26:01',	'2019-07-03 08:26:01'),
(6,	3,	20,	'a:1:{i:0;s:11:\"09352864812\";}',	'یادوآوری رویداد قرص\nفرد مرتبط: محمد عبدی\nتوضیحات: قرص معده بخورم',	NULL,	'2019-07-03 08:26:01',	'2019-07-03 08:26:01'),
(7,	0,	0,	'a:1:{i:0;s:11:\"09352864812\";}',	'All Daily Events Processed',	NULL,	'2019-07-03 08:49:50',	'2019-07-03 08:49:50'),
(8,	3,	23,	'a:1:{i:0;s:11:\"09352864812\";}',	'قرص بخورررررر',	NULL,	'2019-07-03 14:23:35',	'2019-07-03 14:23:35'),
(9,	3,	23,	'a:1:{i:0;s:11:\"09352864812\";}',	'یادوآوری رویداد قرص سرماخوردگی\nفرد مرتبط: محمد عبدی\nتوضیحات: قرص مامان',	NULL,	'2019-07-03 14:23:35',	'2019-07-03 14:23:35'),
(10,	3,	23,	'a:1:{i:0;s:11:\"09352864812\";}',	'قرص بخورررررر',	NULL,	'2019-07-05 10:26:49',	'2019-07-05 10:26:49'),
(11,	3,	23,	'a:1:{i:0;s:11:\"09352864812\";}',	'یادوآوری رویداد قرص سرماخوردگی\nفرد مرتبط: محمد عبدی\nتوضیحات: قرص مامان',	NULL,	'2019-07-05 10:26:50',	'2019-07-05 10:26:50');

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2014_10_12_000000_create_users_table',	1),
(2,	'2014_10_12_100000_create_password_resets_table',	1),
(3,	'2019_06_19_111219_create_bouncer_tables',	1),
(5,	'2019_06_19_170422_create_people_table',	1),
(6,	'2019_06_19_170537_create_sample_messages_table',	1),
(7,	'2019_06_19_170559_create_articles_table',	1),
(8,	'2019_06_19_170612_create_settings_table',	1),
(9,	'2019_06_19_170625_create_comments_table',	1),
(10,	'2019_06_19_170651_create_payments_table',	1),
(11,	'2019_06_19_170728_create_packages_table',	1),
(12,	'2019_06_19_170803_create_user_packages_table',	1),
(13,	'2019_06_23_072917_create_sessions_table',	2),
(14,	'2019_06_24_162644_create_events_table',	3),
(16,	'2019_06_19_170313_create_messages_table',	4);

DROP TABLE IF EXISTS `packages`;
CREATE TABLE `packages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `send_limit` int(11) NOT NULL,
  `limit_days` int(11) NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `off_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `packages` (`id`, `name`, `body`, `send_limit`, `limit_days`, `price`, `off_price`, `created_at`, `updated_at`) VALUES
(1,	'ماهانه',	'شارژ اولیه 100 عدد\r\nیک ماه دسترسی کامل\r\nگزارشات هفتگی',	100,	30,	'100',	'13000',	'2019-06-19 17:28:48',	'2019-06-19 17:28:48');

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref_id` text COLLATE utf8mb4_unicode_ci,
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `payments` (`id`, `user_id`, `amount`, `ref_id`, `extra`, `status`, `created_at`, `updated_at`) VALUES
(17,	1,	'15000',	'000000000000000000000000000121440734',	'a:1:{s:10:\"package_id\";i:1;}',	'0',	'2019-06-22 10:34:39',	'2019-06-22 10:34:39'),
(18,	1,	'15000',	'000000000000000000000000000121440757',	'a:1:{s:10:\"package_id\";i:1;}',	'0',	'2019-06-22 10:34:59',	'2019-06-22 10:35:00'),
(19,	1,	'15000',	NULL,	'a:1:{s:10:\"package_id\";i:1;}',	'0',	'2019-06-22 10:39:43',	'2019-06-22 10:39:43'),
(20,	1,	'15000',	NULL,	'a:1:{s:10:\"package_id\";i:1;}',	'0',	'2019-06-22 10:39:54',	'2019-06-22 10:39:54'),
(21,	1,	'15000',	NULL,	'a:1:{s:10:\"package_id\";i:1;}',	'0',	'2019-06-22 10:41:48',	'2019-06-22 10:41:48'),
(22,	1,	'15000',	NULL,	'a:1:{s:10:\"package_id\";i:1;}',	'0',	'2019-06-22 10:43:26',	'2019-06-22 10:43:26'),
(23,	1,	'15000',	NULL,	'a:1:{s:10:\"package_id\";i:1;}',	'0',	'2019-06-22 10:43:47',	'2019-06-22 10:43:47'),
(24,	1,	'15000',	'000000000000000000000000000121441703',	'a:1:{s:10:\"package_id\";i:1;}',	'0',	'2019-06-22 10:45:17',	'2019-06-22 10:45:17'),
(25,	1,	'15000',	'000000000000000000000000000121441846',	'a:1:{s:10:\"package_id\";i:1;}',	'0',	'2019-06-22 10:46:51',	'2019-06-22 10:46:52'),
(26,	1,	'15000',	'000000000000000000000000000121442219',	'a:1:{s:10:\"package_id\";i:1;}',	'0',	'2019-06-22 10:50:52',	'2019-06-22 10:50:52'),
(27,	1,	'15000',	'000000000000000000000000000121442289',	'a:1:{s:10:\"package_id\";i:1;}',	'1',	'2019-06-22 10:51:37',	'2019-06-22 10:51:49'),
(28,	1,	'15000',	'000000000000000000000000000121442389',	'a:1:{s:10:\"package_id\";i:1;}',	'0',	'2019-06-22 10:52:34',	'2019-06-22 10:52:35'),
(29,	1,	'15000',	'000000000000000000000000000121442390',	'a:1:{s:10:\"package_id\";i:1;}',	'0',	'2019-06-22 10:52:35',	'2019-06-22 10:52:36'),
(30,	1,	'15000',	'000000000000000000000000000121442412',	'a:1:{s:10:\"package_id\";i:1;}',	'1',	'2019-06-22 10:52:53',	'2019-06-22 10:53:27'),
(31,	1,	'15000',	'000000000000000000000000000121442642',	'a:1:{s:10:\"package_id\";i:1;}',	'1',	'2019-06-22 10:55:22',	'2019-06-22 10:55:55'),
(32,	3,	'15000',	'000000000000000000000000000121523483',	'a:1:{s:10:\"package_id\";i:1;}',	'0',	'2019-06-23 04:46:04',	'2019-06-23 04:46:05'),
(33,	3,	'15000',	'000000000000000000000000000121525220',	'a:1:{s:10:\"package_id\";i:1;}',	'0',	'2019-06-23 05:00:48',	'2019-06-23 05:00:49'),
(34,	3,	'100',	'000000000000000000000000000121525308',	'a:1:{s:10:\"package_id\";i:1;}',	'1',	'2019-06-23 05:01:37',	'2019-06-23 05:01:50'),
(35,	3,	'100',	'000000000000000000000000000121525408',	'a:1:{s:10:\"package_id\";i:1;}',	'1',	'2019-06-23 05:02:21',	'2019-06-23 05:02:34'),
(36,	3,	'100',	'000000000000000000000000000121525471',	'a:1:{s:10:\"package_id\";i:1;}',	'1',	'2019-06-23 05:02:57',	'2019-06-23 05:03:07'),
(37,	3,	'100',	'000000000000000000000000000121637916',	'a:1:{s:10:\"package_id\";i:1;}',	'1',	'2019-06-24 05:13:57',	'2019-06-24 05:26:22'),
(38,	3,	'100',	'000000000000000000000000000121639603',	'a:1:{s:10:\"package_id\";i:1;}',	'1',	'2019-06-24 05:29:40',	'2019-06-24 05:29:49'),
(39,	3,	'100',	'000000000000000000000000000121639780',	'a:1:{s:10:\"package_id\";i:1;}',	'0',	'2019-06-24 05:31:26',	'2019-06-24 05:31:26'),
(40,	3,	'100',	'000000000000000000000000000121640223',	'a:1:{s:10:\"package_id\";i:1;}',	'0',	'2019-06-24 05:35:40',	'2019-06-24 05:35:41'),
(41,	3,	'100',	'000000000000000000000000000121640302',	'a:1:{s:10:\"package_id\";i:1;}',	'1',	'2019-06-24 05:36:33',	'2019-06-24 05:36:43'),
(42,	3,	'100',	'000000000000000000000000000121640401',	'a:1:{s:10:\"package_id\";i:1;}',	'1',	'2019-06-24 05:37:32',	'2019-06-24 05:37:41'),
(43,	3,	'100',	'000000000000000000000000000121640880',	'a:1:{s:10:\"package_id\";i:1;}',	'1',	'2019-06-24 05:42:16',	'2019-06-24 05:42:30'),
(44,	3,	'24000',	'000000000000000000000000000123290633',	'a:1:{s:6:\"credit\";s:3:\"200\";}',	'0',	'2019-07-10 06:57:25',	'2019-07-10 06:57:27'),
(45,	3,	'24000',	'000000000000000000000000000123291169',	'a:1:{s:6:\"credit\";s:3:\"200\";}',	'0',	'2019-07-10 07:02:32',	'2019-07-10 07:02:33'),
(46,	3,	'120',	'000000000000000000000000000123291273',	'a:1:{s:6:\"credit\";s:1:\"1\";}',	'1',	'2019-07-10 07:03:24',	'2019-07-10 07:04:08'),
(47,	3,	'720',	'000000000000000000000000000123291525',	'a:1:{s:6:\"credit\";s:1:\"6\";}',	'1',	'2019-07-10 07:05:59',	'2019-07-10 07:06:14');

DROP TABLE IF EXISTS `people`;
CREATE TABLE `people` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `people` (`id`, `name`, `mobile`, `extra`, `user_id`, `created_at`, `updated_at`) VALUES
(3,	'حسن هشمتی',	'9352864812',	NULL,	5,	'2019-06-24 06:49:12',	'2019-06-24 06:49:12'),
(8,	'فریده کرد',	'09124283144',	NULL,	3,	'2019-06-24 12:08:17',	'2019-06-24 12:08:17'),
(9,	'محمد عبدی',	'09352864812',	NULL,	3,	'2019-06-24 12:17:35',	'2019-06-24 12:17:35'),
(10,	'مهدی نیازمند',	'09121212351',	NULL,	3,	'2019-07-09 13:26:23',	'2019-07-09 13:26:23');

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ability_id` int(10) unsigned NOT NULL,
  `entity_id` int(10) unsigned DEFAULT NULL,
  `entity_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `forbidden` tinyint(1) NOT NULL DEFAULT '0',
  `scope` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permissions_entity_index` (`entity_id`,`entity_type`,`scope`),
  KEY `permissions_ability_id_index` (`ability_id`),
  KEY `permissions_scope_index` (`scope`),
  CONSTRAINT `permissions_ability_id_foreign` FOREIGN KEY (`ability_id`) REFERENCES `abilities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(10) unsigned DEFAULT NULL,
  `scope` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`,`scope`),
  KEY `roles_scope_index` (`scope`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `sample_messages`;
CREATE TABLE `sample_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sample_messages` (`id`, `title`, `user_id`, `body`, `created_at`, `updated_at`) VALUES
(1,	'تولد مبارک 1',	1,	'سلام جناب آقای {name}\r\nتود شما مبارک',	'2019-06-19 17:34:09',	'2019-06-19 17:34:09');

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1,	'title',	'سایت یادآور');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `send_limit` int(11) NOT NULL DEFAULT '0',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_mobile_unique` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `extra`, `send_limit`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(3,	'محمد عبدی',	'mohammad_m69@yahoo.com',	'09352864812',	NULL,	205,	'$2y$10$/vK4gwRyDo9WeU139cu1E.FcNQLNK2zCti7IHVLLf.uZa23E7Bb1S',	NULL,	'2019-06-23 03:24:30',	'2019-07-10 07:06:14');

DROP TABLE IF EXISTS `user_packages`;
CREATE TABLE `user_packages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `package_id` bigint(20) NOT NULL,
  `start_at` datetime NOT NULL,
  `finish_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_packages` (`id`, `user_id`, `package_id`, `start_at`, `finish_at`, `created_at`, `updated_at`) VALUES
(2,	3,	1,	'2019-06-24 09:56:22',	'2019-09-24 09:56:22',	'2019-06-24 05:26:22',	'2019-06-24 05:26:22');

-- 2019-07-10 07:12:06
