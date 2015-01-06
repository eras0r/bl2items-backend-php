-- clear siren skill data
delete from skill_tier where skill_tree_id in (10, 11, 12);

delete from skill where id between 96 and 125;

-- insert skills
INSERT INTO `skill` (`id`, `name`, `text`, `image`, `levels`, `killSkill`) VALUES
(96, 'Ward', '+5% Shield Capacity and -8% Shield Recharge Delay per level.', 'ward.png', 5, 0),
(97, 'Accelerate', '+3% Gun Damage and +4% Bullet Speed per level.', 'accelerate.png', 5, 0),
(98, 'Suspension', 'Increases the duration of Phaselock by 0.5s per level.', 'suspension.png', 5, 0),
(99, 'Kinetic Reflection', 'Killing an enemy causes you to deflect bullets against nearby enemies, reducing damage to you by 10% and dealing 20% damage per level for a short time.', 'kinetic-reflection.png', 5, 1),
(100, 'Fleet', 'Your Movement Speed increases by 10% per level while your shields are depleted.', 'fleet.png', 5, 0),
(101, 'Converge', 'Your Phaselock ability now also pulls nearby enemies toward the original target.', 'converge.png', 1, 0),
(102, 'Inertia', 'Killing an enemy regenerates 0.8% of your Shield per second and increases your Reload Speed by 10% per level for a short time.', 'inertia.png', 5, 1),
(103, 'Quicken', 'Increases the Cooldown Rate of your Phaselock''s Ability by 6% per level.', 'quicken.png', 5, 0),
(104, 'Sub-Sequence', 'When an enemy dies under the effects of Phaselock, there is a chance for your Phaselock to seek out and affect another target (20% chance per level).', 'sub-sequence.png', 5, 0),
(105, 'Thoughtlock', 'Phaselock causes enemies to switch allegiance and fight amongst themselves. Additionally, Phaselock''s duration and cooldown is increased (3s and 4s respectively).', 'thoughtlock.png', 1, 0),

(106, 'Mind''s Eye', '+5% Critical Hit Damage and +6% Melee Damage per level.', 'minds-eye.png', 5, 0),
(107, 'Sweet Release', 'Killing an enemy who is currently Phaselocked creates 1 Life Orb per level which automatically seeks out and heals you and your friends. The healing is stronger when you or your friend''s health is low (up to 15% per Orb, does not increase with level).', 'sweet-release.png', 5, 0),
(108, 'Restoration', '+3% Maximum Health and attack allies to heal them for 6% of the attack damage per level.', 'restoration.png', 5, 0),
(109, 'Wreck', '+10% Fire Rate and +6% Damage with guns per level while you have an enemy Phaselocked.', 'wreck.png', 5, 0),
(110, 'Elated', 'You and your friends regenerate 1% health per second per level while you have an enemy Phaselocked.', 'elated.png', 5, 0),
(111, 'Res', 'You can instantly revive a friend in Fight for Your Life by using Phaselock on him/her.', 'res.png', 1, 0),
(112, 'Recompense', 'Taking Health damage has a 10% chance per level of dealing an equal amount of damage to your attacker.', 'recompense.png', 5, 0),
(113, 'Sustenance', 'Regenerate 0.4% of your missing Health per second per level.', 'sustenance.png', 5, 0),
(114, 'Life Tap', 'Killing an enemy gives you 1.2% Life Steal per level for a short while.', 'life-tap.png', 5, 1),
(115, 'Scorn', 'Melee Override. Press [melee] to throw an Orb of Slag that constantly damages enemies near it. This ability has a 18 second cooldown. Pressing [melee] when Scorn is on cooldown will perform a regular melee attack.', 'scorn.png', 1, 0),

(116, 'Flicker', '+6% Elemental Effect Chance per level.', 'flicker.png', 5, 0),
(117, 'Foresight', 'Increases Magazine Size and Reload Speed with all weapon types. +4% Magazine Size and +5% Reload Speed per level.', 'foresight.png', 5, 0),
(118, 'Immolate', 'Adds +10% Damage per level as Fire Damage to all shots fired when in Fight For Your Life.', 'immolate.png', 5, 0),
(119, 'Helios', 'Phaselocking an enemy causes a fiery explosion, damaging all nearby enemies. +1 Helios Damage Rank per level.', 'helios.png', 5, 0),
(120, 'Chain Reaction', 'While you have an enemy Phaselocked all of your bullets that hit enemies have a 8% chance per level to ricochet and hit another nearby enemy.', 'chain-reaction.png', 5, 0),
(121, 'Cloud Kill', 'Shooting an enemy creates a lingering Acid Cloud, which lasts for 5 seconds, dealing constant Corrosive Damage to enemies who touch it. Only one Acid Cloud can be active at a time.', 'cloud-kill.png', 1, 0),
(122, 'Backdraft', 'Your melee attacks deal additional Fire Damage. Also, when your shields become depleted you create a fiery explosion, damaging nearby enemies. Your shields must fully recharge between explosions. +1 Backdraft Damage Rank per level.', 'backdraft.png', 5, 0),
(123, 'Reaper', 'You deal +8% increased Gun Damage per level to any enemy who has more than 50% of his health remaining.', 'reaper.png', 5, 0),
(124, 'Blight Phoenix', 'Killing an enemy causes you to deal constant Fire and Corrosive Damage to nearby enemies for a short time. The damage is based on your Level and the Level of the Blight Phoenix.', 'blight-phoenix.png', 5, 1),
(125, 'Ruin', 'Action Skill Augmentation. Phaselock now slags, corrodes and electrocutes all nearby enemies.', 'ruin.png', 1, 0);

-- create skill tree
INSERT INTO `skill_tier` (`skill_tree_id`, `left_skill_id`, `middle_skill_id`, `right_skill_id`, `order`) VALUES
(10, 96, NULL, 97, 1),
(10, 98, NULL, 99, 2),
(10, 100, 101, 102, 3),
(10, NULL, 103, NULL, 4),
(10, NULL, 104, NULL, 5),
(10, NULL, 105, NULL, 6),
(11, 106, NULL, 107, 1),
(11, 108, NULL, 109, 2),
(11, 110, 111, 112, 3),
(11, NULL, 113, NULL, 4),
(11, NULL, 114, NULL, 5),
(11, NULL, 115, NULL, 6),
(12, 116, NULL, 117, 1),
(12, 118, NULL, 119, 2),
(12, 120, 121, 122, 3),
(12, NULL, 123, NULL, 4),
(12, NULL, 124, NULL, 5),
(12, NULL, 125, NULL, 6);
