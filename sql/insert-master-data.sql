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