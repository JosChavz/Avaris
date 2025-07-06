USE phpapp;

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
CREATE TABLE IF NOT EXISTS `banks` (
    `id` int NOT NULL AUTO_INCREMENT,
    `uid` int NOT NULL,
    `name` varchar(255) NOT NULL,
    `type` enum('DEBIT','CREDIT') NOT NULL,
    `created_at` datetime NOT NULL DEFAULT current_timestamp(),
    `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `idx_banks_uid_name_type` (`uid`,`name`,`type`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

DROP TABLE IF EXISTS `budgets`;
CREATE TABLE IF NOT EXISTS `budgets` (
    `id` int NOT NULL AUTO_INCREMENT,
    `uid` int NOT NULL,
    `name` varchar(255) NOT NULL,
    `max_amount` float NOT NULL,
    `from_date` date NOT NULL,
    `to_date` date NOT NULL,
    `created_at` datetime NOT NULL DEFAULT current_timestamp(),
    `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `FK_UserBudget` (`uid`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `changelog`
--

DROP TABLE IF EXISTS `changelog`;
CREATE TABLE IF NOT EXISTS `changelog` (
    `id` int AUTO_INCREMENT NOT NULL,
    `title` varchar(255) NOT NULL,
    `description` longtext NOT NULL,
    `created_at` datetime NOT NULL DEFAULT current_timestamp(),
    `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
    `id` int NOT NULL AUTO_INCREMENT,
    `uid` int NOT NULL,
    `bid` int DEFAULT NULL,
    `name` varchar(255) NOT NULL,
    `amount` float NOT NULL,
    `description` varchar(255) DEFAULT NULL,
    `type` enum('INCOME','EXPENSE') DEFAULT NULL,
    `category` enum('DINING','ENTERTAINMENT','GROCERIES','BILLS','SHOPPING','TRANSPORTATION','WORK','TRAVEL') DEFAULT NULL,
    `budget_id` int DEFAULT NULL,
    `logged_date` date NOT NULL DEFAULT (curdate()),
    `created_at` datetime NOT NULL DEFAULT current_timestamp(),
    `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `FK_BankTransaction` (`bid`),
    KEY `FK_UserTransaction` (`uid`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `hashed_password` varchar(255) NOT NULL,
    `role` enum('ADMIN','USER') DEFAULT NULL,
    `created_at` datetime NOT NULL DEFAULT current_timestamp(),
    `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_meta`
--

DROP TABLE IF EXISTS `user_meta`;
CREATE TABLE IF NOT EXISTS `user_meta` (
    `id` int NOT NULL AUTO_INCREMENT,
    `uid` int NOT NULL,
    `timezone` varchar(255) NOT NULL DEFAULT 'America/Los_Angeles',
    `last_login` datetime NOT NULL DEFAULT current_timestamp(),
    `created_at` datetime NOT NULL DEFAULT current_timestamp(),
    `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `FK_UserMeta` (`uid`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `banks`
--
ALTER TABLE `banks`
    ADD CONSTRAINT `FK_UserBank` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `budgets`
--
ALTER TABLE `budgets`
    ADD CONSTRAINT `FK_UserBudget` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
    ADD CONSTRAINT `FK_BankTransaction` FOREIGN KEY (`bid`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_UserTransaction` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_meta`
--
ALTER TABLE `user_meta`
  ADD CONSTRAINT `FK_UserMeta` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
