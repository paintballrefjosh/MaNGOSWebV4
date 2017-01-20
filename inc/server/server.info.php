<?php
if(INCLUDED!==true)exit;

$pathway_info[] = array('title'=>'Server Info', 'link' =>'');

$init = 'id_'.$user['cur_selected_realmd'];
$config_details = getMangosConfig($MW->getConfig->mangos_conf_external->$init->mangos_world_conf);

$write_straight = array(
    'PlayerLimit' => 'Simultanous Players Connected Limit',
    'MaxPlayerLevel' => 'Max Character Level',
    'MaxPrimaryTradeSkill' => 'Number of Allowed Primary Trade Skills',
    'MinPetitionSigns' => 'Number of Signers Needed For Guild Petition',
);

$write_true_false = array(
    'AllowTwoSide.Accounts' => 'Allow Both Horde and Alliance on Same Account',
    'AllowTwoSide.Interaction.Chat' => 'Allow Chat between Horde and Alliance',
    'AllowTwoSide.Interaction.Channel' => 'Allow Channels with Both Horde and Alliance',
    'AllowTwoSide.Interaction.Group' => 'Allow Groups with Both Horde and Alliance',
    'AllowTwoSide.Interaction.Guild' => 'Allow Guilds with Both Horde and Alliance',
	'AllowTwoSide.Interaction.Auction'  => 'Allow Auction/Trade between Horde and Alliance',
    'AllowTwoSide.WhoList' => 'Show Both Horde and Alliance on /who List',
);

$write_blizzlike = array(
    'Rate.Health' => 'Health Recovery Rate',
    'Rate.Mana' => 'Mana Recovery Rate',
    'Rate.Rage.Income' => 'Rage Increase Rate',
    'Rate.Rage.Loss' => 'Rage Decrease Rate',
	'Rate.Drop.Item.Poor' => 'Item Drop Rate Poor',
	'Rate.Drop.Item.Normal' => 'Item Drop Rate Normal',
	'Rate.Drop.Item.Uncommon' => 'Item Drop Rate Uncommon',
	'Rate.Drop.Item.Rare' => 'Item Drop Rate Rare',
	'Rate.Drop.Item.Epic' => 'Item Drop Rate Epic',
	'Rate.Drop.Item.Legendary' => 'Item Drop Rate Legendary',
	'Rate.Drop.Item.Artifact' => 'Item Drop Rate Artifact',
	'Rate.Drop.Item.Referenced' => 'Item Drop Rate Referenced',
    'Rate.Drop.Money' => 'Money Drop Rate',
    'Rate.XP.Kill' => 'Experience Rate from Kills',
    'Rate.XP.Quest' => 'Experience Rate from Quests',
    'Rate.XP.Explore' => 'Experience Rate from Exploration',
    'Rate.Creature.Normal.Damage' => 'Damage from Normal Creatures',
    'Rate.Creature.Elite.Elite.Damage' => 'Damage from Elites',
    'Rate.Creature.Elite.RAREELITE.Damage' => 'Damage from Rare Elites',
    'Rate.Creature.Elite.WORLDBOSS.Damage' => 'Damage from World Bosses',
    'Rate.Creature.Elite.RARE.Damage' => 'Damage from Rare Mobs',
    'Rate.Creature.Normal.HP' => 'HP of Normal Creatures',
    'Rate.Creature.Elite.Elite.HP' => 'HP of Elites',
    'Rate.Creature.Elite.RAREELITE.HP' => 'HP of Rare Elites',
    'Rate.Creature.Elite.WORLDBOSS.HP' => 'HP of World Bosses',
    'Rate.Creature.Elite.RARE.HP' => 'HP of Rare Mobs',
    'Rate.Rest.InGame' => 'Rest Exp Growth Rate In-game',
    'Rate.Rest.Offline.InTavernOrCity' => 'Rest Exp Growth Rate at Cities/Inns',
    'Rate.Rest.Offline.InWilderness' => 'Rest Exp Growth Rate in Wilderness',
    'Rate.Talent' => 'Talent Points Gain',
);

$write_skillchances = array(
    'SkillChance.Orange' => 'Orange',
    'SkillChance.Yellow' => 'Yellow',
    'SkillChance.Green'  => 'Green',
    'SkillChance.Grey'   => 'Grey',
);

?>
