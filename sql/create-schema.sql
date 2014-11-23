-- --------------------------------------------------------
-- This file generates the required schema for the
-- borderlands 2 items database backend application.
-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Table structure for table `rarity`
--
CREATE TABLE IF NOT EXISTS `rarity` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `sortOrder` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`),
  UNIQUE KEY `unique_sortOrder` (`sortOrder`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------
--
-- Table structure for table `manufacturer`
--
CREATE TABLE IF NOT EXISTS `manufacturer` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

--
-- Table structure for table `damage_type`
--
CREATE TABLE IF NOT EXISTS `damage_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sortOrder` int(11) NOT NULL,
  `color` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `damageLabel` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chanceLabel` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `additionalText` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`),
  UNIQUE KEY `unique_sortOrder` (`sortOrder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------
--
-- Table structure for table `abstract_item`
--
CREATE TABLE IF NOT EXISTS `abstract_item` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `manufacturer_id` bigint(20) NOT NULL,
  `rarity_id` bigint(20) NOT NULL,
  `level` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uniqueText` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `additionalText` longtext COLLATE utf8_unicode_ci NOT NULL,
  `itemType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`),
  KEY `IDX_ECFF561FA23B42D` (`manufacturer_id`),
  KEY `IDX_ECFF561FF3747573` (`rarity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------
--
-- Table structure for table `shield`
--
CREATE TABLE IF NOT EXISTS `shield` (
  `id` bigint(20) NOT NULL,
  `capacity` int(11) NOT NULL,
  `rechargeRate` int(11) NOT NULL,
  `rechargeDelay` decimal(10,0) NOT NULL,
  `maxHealth` int(11) NOT NULL,
  `boosterChance` decimal(10,0) NOT NULL,
  `elementalResistance` decimal(10,0) NOT NULL,
  `absorbChance` decimal(10,0) NOT NULL,
  `ampDamage` int(11) NOT NULL,
  `ampShotDrain` int(11) NOT NULL,
  `novaDamage` int(11) NOT NULL,
  `novaRadius` int(11) NOT NULL,
  `roidDamage` int(11) NOT NULL,
  `spikeDamage` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `weapon`
--
CREATE TABLE IF NOT EXISTS `weapon` (
  `id` bigint(20) NOT NULL,
  `damage` decimal(10,0) NOT NULL,
  `damageMultiplier` int(11) NOT NULL DEFAULT '1',
  `accuracy` decimal(10,0) NOT NULL,
  `fireRate` decimal(10,0) NOT NULL,
  `reloadSpeed` decimal(10,0) NOT NULL,
  `magazineSize` int(11) NOT NULL,
  `elemDamage` decimal(10,0) DEFAULT NULL,
  `elemChance` decimal(10,0) DEFAULT NULL,
  `damageType_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6933A7E6E0384A9F` (`damageType_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `role`
--
CREATE TABLE IF NOT EXISTS `role` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_rolename` (`rolename`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------
--
-- Table structure for table `user`
--
CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `algorithm` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `iterations` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------
--
-- Table structure for table `users_roles`
--
CREATE TABLE IF NOT EXISTS `users_roles` (
  `user_id` bigint(20) NOT NULL,
  `role_id` bigint(20) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `IDX_51498A8EA76ED395` (`user_id`),
  KEY `IDX_51498A8ED60322AC` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `session_token`
--
CREATE TABLE IF NOT EXISTS `session_token` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `sessionToken` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `secret` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_844A19EDA76ED395` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

----- TODO rename constraints
--
-- Constraints for table `abstract_item`
--
ALTER TABLE `abstract_item`
  ADD CONSTRAINT `FK_ECFF561FA23B42D` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturer` (`id`),
  ADD CONSTRAINT `FK_ECFF561FF3747573` FOREIGN KEY (`rarity_id`) REFERENCES `rarity` (`id`);

--
-- Constraints for table `session_token`
--
ALTER TABLE `session_token`
  ADD CONSTRAINT `FK_844A19EDA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `shield`
--
ALTER TABLE `shield`
  ADD CONSTRAINT `FK_1E93D2E8BF396750` FOREIGN KEY (`id`) REFERENCES `abstract_item` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `FK_51498A8ED60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `FK_51498A8EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `weapon`
--
ALTER TABLE `weapon`
  ADD CONSTRAINT `FK_6933A7E6BF396750` FOREIGN KEY (`id`) REFERENCES `abstract_item` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_6933A7E6E0384A9F` FOREIGN KEY (`damageType_id`) REFERENCES `damage_type` (`id`);
