-- TODO rename constraints
--
-- Constraints for table `abstract_item`
--
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
-- Constraints for table `skill_tier`
--
ALTER TABLE `skill_tier`
  ADD CONSTRAINT `FK_63DF0B3887EF990D` FOREIGN KEY (`right_skill_id`) REFERENCES `skill` (`id`),
  ADD CONSTRAINT `FK_63DF0B381D7EFA8B` FOREIGN KEY (`skill_tree_id`) REFERENCES `skill_tree` (`id`),
  ADD CONSTRAINT `FK_63DF0B385E3AF899` FOREIGN KEY (`middle_skill_id`) REFERENCES `skill` (`id`),
  ADD CONSTRAINT `FK_63DF0B38F143D72A` FOREIGN KEY (`left_skill_id`) REFERENCES `skill` (`id`);

--
-- Constraints for table `skill_tree`
--
ALTER TABLE `skill_tree`
  ADD CONSTRAINT `FK_F07FC26E1136BE75` FOREIGN KEY (`character_id`) REFERENCES `character` (`id`);

--
-- Constraints for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `FK_51498A8EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_51498A8ED60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Constraints for table `weapon`
--
ALTER TABLE `weapon`
  ADD CONSTRAINT `FK_6933A7E6BF396750` FOREIGN KEY (`id`) REFERENCES `abstract_item` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_6933A7E6E0384A9F` FOREIGN KEY (`damageType_id`) REFERENCES `damage_type` (`id`);
