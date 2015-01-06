-- clear gunzerker skill data
delete from skill_tier where skill_tree_id in (7, 8, 9);

delete from skill where id between 63 and 95;

-- insert skills
INSERT INTO `skill` (`id`, `name`, `text`, `image`, `levels`, `killSkill`) VALUES
(63, 'Locked and Loaded', 'Reloading your gun gives you +5% Fire Rate per level for a short time.', 'locked-and-loaded.png', 5, 0),
(64, 'Quick Draw', '+7% Weapon Swap Speed and +2% Critical Hit Damage per level.', 'quick-draw.png', 5, 0),
(65, 'I''m Your Huckleberry', '+3% Damage and Reload Speed per level with pistols.', 'i-m-your-huckleberry.png', 5, 0),
(66, 'All I Need is One', 'Swapping weapons causes your next shot fired to deal +8% damage per level.', 'all-i-need-is-one.png', 5, 0),
(67, 'Divergent Likeness', '+6% Damage when Gunzerking with two of the same type of guns, +6% Accuracy when Gunzerking with two different types of guns per level.', 'divergent-likeness.png', 5, 0),
(68, 'Auto-Load', 'Killing an enemy Instantly Reloads all of the guns that you have equipped that are not currently in your hands. Swapping guns after Auto-Load has reloaded a gun triggers Locked & Loaded.', 'auto-load.png', 1, 0),
(69, 'Money Shot', 'The last bullet fired from any gun does +8% damage per level per magazine size, up to +80% damage per level.', 'money-shot.png', 5, 0),
(70, 'Lay Waste', 'Kill Skill. Killing an enemy gives +8% Fire Rate and +5% Critical Hit Damage with Guns per level for a short time.', 'lay-waste.png', 5, 1),
(71, 'Down Not Out', 'You can Gunzerk while in Fight for Your Life.', 'down-not-out.png', 1, 0),
(72, 'Keep It Piping Hot', 'While Gunzerking is in the process of cooling down you gain +5% Gun Damage, +6% Melee Damage, and +5% Grenade Damage per level.', 'keeping-it-piping-hot.png', 5, 0),
(73, 'No Kill Like Overkill', 'When you kill an enemy you gain a bonus to Gun Damage equal to the amount of excess damage you dealt to the enemy you just killed.', 'no-kill-like-overkill.png', 1, 0),

(74, 'Inconceivable', 'Up to 10% chance per level for shots not to consume ammo depending on how low your health and shields are.', 'inconceivable.png', 5, 0),
(75, 'Filled to the Brim', '+5% Magazine Capacity and +3% Ammunition Capacity per level for all weapon types.', 'filled-to-the-brim.png', 5, 0),
(76, 'All in the Reflexes', '+5% Reload Speed and +4% Melee Damage per level.', 'all-in-the-reflexes.png', 5, 0),
(77, 'Last Longer', '+3 seconds Gunzerking duration per level.', 'last-longer.png', 5, 0),
(78, 'I''m ready already', '+5% Gunzerking Cooldown Rate.', 'i-m-ready-already.png', 5, 0),
(79, 'Steady as She Goes', '+80% Recoil Reduction and 30% chance to improve Accuracy on hit when Gunzerking.', 'steady-as-she-goes.png', 1, 0),
(80, '5 Shots or 6', 'Grants a 5% chance per level to add an extra round of ammunition when firing instead of expending ammunition.', '5-shots-or-6.png', 5, 0),
(81, 'Yippee Ki Yay', 'Increases the duration of Gunzerking by 0.6s per level every time an enemy is killed while Gunzerking.', 'yippee-ki-yay.png', 5, 0),
(82, 'Double your Fun', 'Throwing a grenade while Gunzerking throws two grenades instead of one. The second grenade doesn''t cost ammo.', 'double-your-fun.png', 1, 0),
(83, 'Get Some', 'Shooting an enemy decreases Gunzerking cooldown by 0.6 second per level. Has a cooldown of 3 seconds.', 'get-some.png', 5, 0),
(84, 'Keep Firing...', 'While Gunzerking, you gain up to +88% Fire Rate and +25% Reload Speed depending on how long you hold down the trigger.', 'keep-firing.png', 1, 0),

(85, 'Hard To Kill', '+4% Maximum Health and regenerate 0.1% of your Maximum Health per second per level.', 'hard-to-kill.png', 5, 0),
(86, 'Incite', 'Taking damage gives +6% Movement Speed and +5% Reload Speed for a few seconds.', 'incite.png', 5, 0),
(87, 'Asbestos', '-8% Negative Status Effect Duration per level.', 'asbestos.png', 5, 0),
(88, 'I''m the Juggernaut', 'Killing an enemy gives +4% Damage Reduction for a short time.', 'i-m-the-juggernaut.png', 5, 1),
(89, 'Ain''t Got Time to Bleed', 'While Gunzerking you regenerate up to 0.8% of your Maximum Health per second per level depending on how low your health is.', 'aint-got-time-to-bleed.png', 5, 0),
(90, 'Fistful of Hurt', 'Melee Override. Throw a heavy punch dealing massive damage and knockback. Has a cooldown of 15 seconds.', 'fistful-of-hurt.png', 1, 1),
(91, 'Out of Bubblegum', '+7% Fire Rate per level when shield is depleted.', 'out-of-bubblegum.png', 5, 0),
(92, 'Bus That Can''t Slow Down', '+10% Movement Speed per level while Gunzerking.', 'bus-cant-slow-down.png', 5, 0),
(93, 'Just Got Real', 'Up to +8% Gun Damage per level depending on how low your health is.', 'just-got-real.png', 5, 0),
(94, 'Sexual Tyrannosaurus', 'Taking damage gives +0.4% Health Regeneration per level for 5 seconds. This effect does not stack.', 'sexual-tyrannosaurus.png', 5, 0),
(95, 'Come At Me Bro', 'While Gunzerking, you can press [Action Skill] to taunt your enemies into attacking you. You instantly heal to Full Health and gain massive damage reduction for a few seconds.', 'come-at-me-bro.png', 1, 0);

-- create skill tree
INSERT INTO `skill_tier` (`skill_tree_id`, `left_skill_id`, `middle_skill_id`, `right_skill_id`, `order`) VALUES
(7, 63, NULL, 64, 1),
(7, 65, NULL, 66, 2),
(7, 67, 68, 69, 3),
(7, 70, 71, NULL, 4),
(7, NULL, 72, NULL, 5),
(7, NULL, 73, NULL, 6),
(8, 74, NULL, 75, 1),
(8, 76, NULL, 77, 2),
(8, 78, 79, 80, 3),
(8, 81, 82, NULL, 4),
(8, NULL, 83, NULL, 5),
(8, NULL, 84, NULL, 6),
(9, 85, NULL, 86, 1),
(9, 87, NULL, 88, 2),
(9, 89, 90, 91, 3),
(9, 92, 93, NULL, 4),
(9, NULL, 94, NULL, 5),
(9, NULL, 95, NULL, 6);
