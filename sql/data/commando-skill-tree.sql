-- clear commando skill data
delete from skill_tier where skill_tree_id in (4, 5, 6);

delete from skill where id between 31 and 62;

-- insert skills
INSERT INTO `skill` (`id`, `name`, `text`, `image`, `levels`, `killSkill`) VALUES
(31, 'Sentry', '+1 shot per burst and +2s duration for Sabre Turret per level.', 'sentry.png', 5, 0),
(32, 'Ready', '+8% Reload Speed per level.', 'ready.png', 5, 0),
(33, 'Laser Sight', '+10% Turret Accuracy per level.', 'laser-sight.png', 5, 0),
(34, 'Willing', '+15% Shield Recharge Rate and -12% Shield Recharge Delay per level.', 'willing.png', 5, 0),
(35, 'Onslaught', 'Killing an enemy gives you +6% Gun Damage and +12% Movement Speed per level for a short time.', 'onslaught.png', 5, 1),
(36, 'Scoreched Earth', 'Adds Multi-Rocket Pods to your Sabre Turret. 22 Rockets per Volley.', 'scorched-earth.png', 1, 0),
(37, 'Able', 'Damaging an enemy regenerates 0.4% of your Maximum Health per second per level for 3 seconds.', 'able.png', 5, 0),
(38, 'Grenadier', '+1 Grenade Capacity per level.', 'grenadier.png', 5, 0),
(39, 'Crisis Management', '+7% Gun Damage and +6% Melee Damage per level when shields are depleted.', 'crisis-management.png', 5, 0),
(40, 'Double Up', 'Adds a second gun to the Sabre Turret and both guns fire Slag bullets.', 'double-up.png', 1, 0),
(41, 'Impact', '+4% Gun Damage and +3% Melee Damage per level.', 'impact.png', 5, 0),
(42, 'Expertise', '+14% weapon swap and aim speed per level; +7% movement speed when aiming per level.', 'expertise.png', 5, 0),
(43, 'Overload', '+10% Magazine Size for Assault Rifles.', 'overload.png', 5, 0),
(44, 'Metal Storm', 'Killing an enemy gives +12% Fire Rate and +15% Recoil Reduction per level for a short time.', 'metal-storm.png', 5, 1),
(45, 'Steady', '+8% Recoil Reduction, +5% Grenade Damage, and +4% Rocket Launcher damage per level.', 'steady.png', 5, 0),
(46, 'Longbow Turret', '+10000% Turret Deploy Range, +110% Turret Health.', 'longbow-turret.png', 1, 0),
(47, 'Battlefront', '+6% Gun, Melee, and Grenade damage per level while turret is deployed.', 'battlefront.png', 5, 0),
(48, 'Duty Calls', '+5% Gun Damage and +3% Fire Rate with non-elemental guns.', 'duty-calls.png', 5, 0),
(49, 'Do or Die', 'Allows you to throw grenades while in Fight for Your Life. +10% Grenade and Rocket Launcher damage.', 'do-or-die.png', 1, 0),
(50, 'Ranger', '+1% Gun Damage, Accuracy, Critical Hit Damage, Fire Rate, Magazine Size, Reload Speed, and Maximum Health per level.', 'ranger.png', 5, 0),
(51, 'Nuke', 'Deploying your Sabre Turret sets off a small Nuclear Blast.', 'nuke.png', 1, 0),
(52, 'Healthy', '+6% Maximum Health per level.', 'healthy.png', 5, 0),
(53, 'Preparation', '+3% shield capacity per level; regenerate 0.4% health per second per level when shields are full.', 'preparation.png', 5, 0),
(54, 'Last Ditch Effort', '+8% Gun Damage and +14% Movement Speed per level during Fight For Your Life.', 'last-ditch-effort.png', 5, 0),
(55, 'Pressure', 'Up to +14% Reload Speed and -12% Shield Recharge Delay per level depending on how low your health is.', 'pressure.png', 5, 0),
(56, 'Forbearance', '-8% Status Effect duration on you and +1% Maximum Health per level.', 'forbearance.png', 5, 0),
(57, 'Phalanx Shield', 'Your Sabre Turret projects a shield that attempts to block enemy ranged fire but lets friendly ranged attacks pass through.', 'phalanx-shield.png', 1, 0),
(58, 'Quick Charge', 'Killing an enemy regenerates 1% of your shield per second per level for a short time.', 'quick-charge.png', 5, 1),
(59, 'Resourceful', '+5% Action Skill Cooldown Rate per level.', 'resourceful.png', 5, 0),
(60, 'Mag-Lock', 'Your Sabre Turret can be deployed on walls and ceilings.', 'mag-lock.png', 1, 0),
(61, 'Grit', 'You have a 4% chance per level to ignore damage that would otherwise kill you. In addition to not taking damage from the attack, you will also regain half your Maximum health.', 'grit.png', 5, 0),
(62, 'Gemini', 'Allows you to deploy two Sabre Turrets.', 'gemini.png', 1, 0);

-- create skill tree
INSERT INTO `skill_tier` (`skill_tree_id`, `left_skill_id`, `middle_skill_id`, `right_skill_id`, `order`) VALUES
(4, 31, NULL, 32, 1),
(4, 33, NULL, 34, 2),
(4, 35, 36, 37, 3),
(4, NULL, 38, NULL, 4),
(4, NULL, 39, NULL, 5),
(4, NULL, 40, NULL, 6),
(5, 41, NULL, 42, 1),
(5, 43, NULL, 44, 2),
(5, 45, 46, 47, 3),
(5, 48, 49, NULL, 4),
(5, NULL, 50, NULL, 5),
(5, NULL, 51, NULL, 6),
(6, 52, NULL, 53, 1),
(6, 54, NULL, 55, 2),
(6, 56, 57, 58, 3),
(6, 59, 60, NULL, 4),
(6, NULL, 61, NULL, 5),
(6, NULL, 62, NULL, 6);
