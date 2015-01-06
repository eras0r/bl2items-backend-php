-- clear assassin skill data
delete from skill_tier where skill_tree_id in (1, 2, 3);

delete from skill where id between 1 and 30;

-- insert skills
INSERT INTO `skill` (`id`, `name`, `text`, `image`, `levels`, `killSkill`) VALUES
(1, 'Headsh0t', '+4% Critical Hit Damage per level.', 'headshot.png', 5, 0),
(2, 'Optics', '+3% Zoom and +12% Aim Steadiness (reduces aim disruption when taking damage) per level.', 'optics.png', 5, 0),
(3, 'Killer', 'Killing an enemy gives you +10% Critical Hit Damage and +15% Reload Speed per level for a few seconds.', 'killer.png', 5, 1),
(4, 'Precisi0n', '+5% Accuracy per level.', 'precision.png', 5, 0),
(5, '0ne Sh0t 0ne Kill', 'The first shot from a fully loaded magazine deals +12% Damage per level.', 'one-shot-one-kill.png', 5, 0),
(6, 'B0re', 'Shots pierce through enemies, gaining +100% damage per enemy pierced. Enemy crit locations highlighted in Decepti0n.', 'bore.png', 1, 0),
(7, 'Vel0city', '+20% Bullet Speed, +3% Critical Hit Damage, and +2% Gun Damage per level.', 'velocity.png', 5, 0),
(8, 'Kill C0nfirmed', 'Up to +8% Critical Hit Damage per level depending on how long you aim down the sights.', 'kill-confirmed.png', 5, 0),
(9, 'At 0ne with the Gun', '+25% Hip-Shot accuracy, +10% Reload Speed, and +1 Magazine Size with Sniper Rifles per level.', 'at-one-with-the-gun.png', 5, 0),
(10, 'Critical Ascensi0n', 'Scoring a Critical Hit with a sniper rifle gives you +6% Critical Hit Damage and +5% Damage with sniper rifles. Can stack up to 999 times. Stacks begin to decay if you haven''t scored a critical hit after a couple seconds.', 'critical-ascension.png', 1, 0),

(11, 'Fast Hands', '+5% Reload Speed and +10% Weapon Swap Speed per level.', 'fast-hands.png', 5, 0),
(12, 'C0unter Strike', 'After getting hit, your next melee attack has a chance to deal +50% damage per level.', 'counter-strike.png', 5, 0),
(13, 'Fearless', '+5% Fire Rate and +3% Gun Damage per level when your shield is depleted.', 'fearless.png', 5, 0),
(14, 'Ambush', '+4% damage per level when attacking enemies from behind or when attacking an enemy who is targeting someone other than you.', 'ambush.png', 5, 0),
(15, 'Rising Sh0t', 'Each successful ranged or melee attack gives you +2% Gun Damage and +1.8% Melee Damage per level for a short time. This bonus can stack up to 5 times. Faster weapons can gain stacks more quickly, but slower weapons retain stacks for a longer period of tim', 'rising-shot.png', 5, 0),
(16, 'Deathmark', 'Dealing melee damage marks a target for 8 seconds. Marked targets take 20% additional damage from all sources.', 'death-mark.png', 1, 0),
(17, 'Unf0rseen', 'Your holographic decoy explodes when you become visible again, causing shock damage to nearby enemies. Damage increases per level.', 'unforseen.png', 5, 0),
(18, 'Innervate', 'While Decepti0n is active you gain +2% Gun Damage, +7% Movement Speed, and regenerate 0.8% of your Maximum Health per second per level.', 'innervate.png', 5, 0),
(19, 'Tw0 Fang', 'Every time you fire you have a 6% chance per level to fire twice.', 'two-fang.png', 5, 0),
(20, 'Death Bl0ss0m', 'Action Skill Augment. Throws a handful of Kunai knives. Has a random elemental effect. Does not take character out of Decepti0n. Can be used five times per cooldown. Can apply Death Mark.', 'death-blossom.png', 1, 0),

(21, 'Killing Bl0w', '+100% Melee Damage per level against enemies with low health.', 'killing-blow.png', 5, 0),
(22, 'Ir0n Hand', '+3% Melee Damage and Maximum Health per level.', 'iron-hand.png', 5, 0),
(23, 'Grim', 'Killing an enemy regenerates 0.7% of your shield per second and gives +1.5% Action Skill cooldown rate per level for a few seconds.', 'grim.png', 5, 1),
(24, 'Be Like Water', 'Shooting an enemy gives +6% damage per level to your next melee attack. Melee Attacks give +4% damage per level to your next gun attack.', 'be-like-water.png', 5, 0),
(25, 'F0ll0wthr0ugh', 'Killing an enemy gives +8% Movement Speed, +6% Gun Damage, and +8% Melee Damage per level for a few seconds.', 'followthrough.png', 5, 1),
(26, 'Execute', 'Melee Override Skill. While Decepti0n is active and a target is under your crosshairs, melee to dash forward a short distance and perform a special melee attack, dealing massive damage. Has a range of 3 meters.', 'execute.png', 1, 0),
(27, 'Backstab', 'Your melee attacks deal +8% damage per level when hitting an enemy in the back.', 'backstab.png', 5, 0),
(28, 'Resurgence', 'Killing an enemy with a melee attack restores up to 4% of your health per level depending on how low your health is.', 'resurgence.png', 5, 0),
(29, 'Like The Wind', '+3% Gun and Melee Damage per level when moving.', 'like-the-wind.png', 5, 0),
(30, 'Many Must Fall', 'Killing an enemy with a Melee Attack during Decepti0n deploys an additional holographic decoy and extends the duration of Decepti0n instead of ending it.', 'many-must-fall.png', 1, 0);

-- create skill tree
INSERT INTO `skill_tier` (`skill_tree_id`, `left_skill_id`, `middle_skill_id`, `right_skill_id`, `order`) VALUES
(1, 1, NULL, 2, 1),
(1, 3, NULL, 4, 2),
(1, 5, 6, 7, 3),
(1, NULL, 8, NULL, 4),
(1, NULL, 9, NULL, 5),
(1, NULL, 10, NULL, 6),
(2, 11, NULL, 12, 1),
(2, 13, NULL, 14, 2),
(2, 15, 16, 17, 3),
(2, NULL, 18, NULL, 4),
(2, NULL, 19, NULL, 5),
(2, NULL, 20, NULL, 6),
(3, 21, NULL, 22, 1),
(3, 23, NULL, 24, 2),
(3, 25, 26, 27, 3),
(3, NULL, 28, NULL, 4),
(3, NULL, 29, NULL, 5),
(3, NULL, 30, NULL, 6);
