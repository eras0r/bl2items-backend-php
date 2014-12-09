-- --------------------------------------------------------
-- This file adds required master data
-- for the borderlands item database backend application.
-- --------------------------------------------------------

--
-- Dumping data for table `user`
--
INSERT INTO `user` (`id`, `username`, `algorithm`, `iterations`, `salt`, `password`) VALUES
(1, 'admin', 'sha512', 1000, '+VDQeXo9kUD6AVR3qJWFByzuSx5pvpu2', 'nJvlBOwQmYoo1Nym6dFwpUgtwxkqSEhi');

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `rolename`) VALUES
(2, 'admin'),
(1, 'user');

--
-- Dumping data for table `users_roles`
--
INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES
(1, 1),
(1, 2);

--
-- Dumping data for table `rarity`
--
INSERT INTO `rarity` (`name`, `color`, `sortOrder`) VALUES
('common', '#ffffff', 1),
('green', '#00ff00', 2),
('blue', '#2f78ff', 3),
('purple', '#9132c8', 4),
('e-tech', '#ff00ff', 5),
('legendary', '#ff9600', 6),
('pearlescent', '#00ffff', 7),
('seraph', '#ff69b4', 8);

--
-- Dumping data for table `manufacturer`
--
INSERT INTO `manufacturer` (`name`) VALUES
('Anshin'),
('Bandit'),
('Dahl'),
( 'Eridian'),
('Hyperion'),
('Jakobs'),
('Maliwan'),
( 'Pangolin'),
('Tediore'),
('Torgue'),
('Vladof');

--
-- Dumping data for table `damage_type`
--
INSERT INTO `damage_type` (`name`, `sortOrder`, `color`, `damageLabel`, `chanceLabel`, `additionalText`) VALUES
('-none-', 1, '#ffffff', NULL, NULL, NULL),
('corrosive', 2, '#09f108', 'Corrosive Dmg/Sec', 'Chance to corrode', 'Highly effective vs Armor'),
('electro', 3, '#1f4fbd', 'Electrocute Dmg/Sec', 'Chance to shock', 'Highly effective vs Shields'),
('explosive', 4, '#dcc824', NULL, NULL, 'Deals bonus explosive damage'),
('fire', 5, '#e57b0e', 'Burn Dmg/Sec', 'Chance to Ignite', 'Highly effective vs Flesh'),
('slag', 6, '#7014af', NULL, 'Chance to Slag', 'Slagged enemies take more damage');

--
-- Dumping data for table `character`
--
INSERT INTO `character` (`id`, `name`, `classRequirement`) VALUES
(1, 'Zer0', 'Assassin'),
(2, 'Axton', 'Commando'),
(3, 'Salvador', 'Gunzerker'),
(4, 'Maya', 'Siren'),
(5, 'Gaige', 'Mechromancer'),
(6, 'Krieg', 'Psycho');

--
-- Dumping data for table `skill_tree`
--
INSERT INTO `skill_tree` (`id`, `character_id`, `order`, `title`, `color`, `borderColor`) VALUES
(1, 1, 1, 'Sniping', 'green', '#5AC94B'),
(2, 1, 2, 'Cunning', 'blue', '#53A3AD'),
(3, 1, 3, 'Bloodshed', 'red', '#A93E3D'),
(4, 2, 1, 'Guerilla', 'green', '#5AC94B'),
(5, 2, 2, 'Gunpowder', 'blue', '#53A3AD'),
(6, 2, 3, 'Survival', 'red', '#A93E3D'),
(7, 3, 1, 'Gun Lust', 'green', '#5AC94B'),
(8, 3, 2, 'Rampage', 'blue', '#53A3AD'),
(9, 3, 3, 'Brawn', 'red', '#A93E3D'),
(10, 4, 1, 'Motion', 'green', '#5AC94B'),
(11, 4, 2, 'Harmony', 'blue', '#53A3AD'),
(12, 4, 3, 'Cataclysm', 'red', '#A93E3D'),
(13, 5, 1, 'Best friends forever', 'green', '#5AC94B'),
(14, 5, 2, 'Little big trouble', 'blue', '#53A3AD'),
(15, 5, 3, 'Ordered chaos', 'red', '#A93E3D'),
(16, 6, 1, 'Bloodlust', 'green', '#5AC94B'),
(17, 6, 2, 'Mania', 'blue', '#53A3AD'),
(18, 6, 3, 'Hellborn', 'red', '#A93E3D');

