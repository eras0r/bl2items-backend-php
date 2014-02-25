-- --------------------------------------------------------
-- This file adds required master data
-- for the borderlands item database backend application.
-- --------------------------------------------------------

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
