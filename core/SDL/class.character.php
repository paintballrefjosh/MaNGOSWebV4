<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

class Character
{
	function __construct()
	{
		$this->constructCharInfo();
	}

//	************************************************************
// Constructs character info fields
	
	function constructCharInfo()
	{
		$this->charInfo = array(
			'race' => array(
                1 => 'Human',
                2 => 'Orc',
                3 => 'Dwarf',
                4 => 'Night Elf',
                5 => 'Undead',
                6 => 'Tauren',
                7 => 'Gnome',
                8 => 'Troll',
                9 => 'Goblin',
                10 => 'Bloodelf',
                11 => 'Dranei',
		22 => 'Worgen',
		24 => 'Pandaren',
		26 => 'Pandaren'
            ),
            'class' => array(
                1 => 'Warrior',
                2 => 'Paladin',
                3 => 'Hunter',
                4 => 'Rogue',
                5 => 'Priest',
		6 => 'Death_Knight',
                7 => 'Shaman',
                8 => 'Mage',
                9 => 'Warlock',
		10 => 'Monk',
                11 => 'Druid'
            ),
            'gender' => array(
                0 => 'Male',
                1 => 'Female',
                2 => 'None'
            )
		);
	}
	
	
//	************************************************************
// Adjusts the the level for character id, $mod is the adjustment

	public function adjustLevel($id, $mod)
	{
		global $CDB;
		$lvl = $CDB->selectRow("SELECT `level` FROM characters WHERE `guid`='$id'");
		if($lvl == FALSE)
		{
			return FALSE;
		}
		else
		{
			$newlvl = $lvl['level'] + $mod;
			$CDB->query("UPDATE `characters` SET `level`='$newlvl' WHERE `guid`='$id'");
			return TRUE;
		}
	}

//	************************************************************
// Adjusts the money of character id, $mod is the adjustment
	
	public function adjustMoney($id, $mod)
	{
		global $CDB;
		$m = $CDB->selectRow("SELECT `money` FROM characters WHERE `guid`='$id'");
		if($lvl == FALSE)
		{
			return FALSE;
		}
		else
		{
			$newmoney = $m['money'] + $mod;
			$CDB->query("UPDATE `characters` SET `money`='$newmoney' WHERE `guid`='$id'");
			return TRUE;
		}
	}

//	************************************************************
// Gets the account ID tied to the a characters guid
	
	public function getAccountId($guid)
    {
		global $CDB;
        $guid = $CDB->real_escape_string($guid);
        $row = $CDB->selectRow("SELECT `account` FROM `characters` WHERE `guid` = '$guid' LIMIT 1");
		if($row == FALSE)
		{
			return FALSE;
		}
		else
		{
			return $row['account'];
		}
    }
	
//	************************************************************
// Gets the level for character id

	public function getLevel($guid) 
	{
		global $CDB;
        $guid = $CDB->real_escape_string($guid);
        $row = $CDB->selectRow("SELECT `level` FROM `characters` WHERE `guid` = '$guid' LIMIT 1");
		if($row == FALSE)
		{
			return FALSE;
		}
		else
		{
			return $row['level'];
		}
    }

//	************************************************************
// Gets the class for character id

	public function getClass($guid) 
	{
		global $CDB;
        $guid = $CDB->real_escape_string($guid);
        $row = $CDB->selectRow("SELECT `class` FROM `characters` WHERE `guid` = '$guid' LIMIT 1");
		if($row == FALSE)
		{
			return FALSE;
		}
		else
		{
			return $row['class'];
		}
    }
	
//	************************************************************
// Gets the race for character id

	public function getRace($guid) 
	{
		global $CDB;
        $guid = $CDB->real_escape_string($guid);
        $row = $CDB->selectRow("SELECT `race` FROM `characters` WHERE `guid` = '$guid' LIMIT 1");
		if($row == FALSE)
		{
			return FALSE;
		}
		else
		{
			return $row['race'];
		}
    }

//	************************************************************
// Gets the gender for character id
	
	public function getGender($guid) 
	{
		global $CDB;
        $guid = $CDB->real_escape_string($guid);
        $row = $CDB->selectRow("SELECT `gender` FROM `characters` WHERE `guid` = '$guid' LIMIT 1");
		if($row == FALSE)
		{
			return FALSE;
		}
		else
		{
			return $row['gender'];
		}
    }

//	************************************************************
// Gets the faction for character id. Returns 1 = Ally, 0 = horde

	public function getFaction($guid)
    {
		global $CDB;
        $guid = $CDB->real_escape_string($guid);
        $ally = array("1", "3", "4", "7", "11");
        $row = $this->getRace($guid);
		if($row == FALSE)
		{
			return FALSE;
		}
		else
		{
			if(in_array($row, $ally))
			{
				return 1;
			} 
			else 
			{
				return 0;
			}
		}
    }

//	************************************************************
// Gets the ammount of gold for character id
	
	public function getMoney($guid) 
	{
		global $CDB;
        $guid = $CDB->real_escape_string($guid);
        $row = $CDB->selectRow("SELECT `money` FROM `characters` WHERE `guid` = '$guid' LIMIT 1");
		if($row == FALSE)
		{
			return FALSE;
		}
		else
		{
			return $row['money'];
		}
    }
	
//	************************************************************
// Gets the name of the character id

	function getName($guid)
	{
		global $CDB;
		$guid = $CDB->real_escape_string($guid);
        $row = $CDB->selectCell("SELECT `name` FROM `characters` WHERE `guid` = '$guid' LIMIT 1");
		if($row == FALSE)
		{
			return FALSE;
		}
		else
		{
			return $row;
		}
	}
	
//	************************************************************
// Gets a count of all online characters
// @$faction: 1 = ally, 2 = horde, and 0 is both

	function getOnlineCount($faction = 0)
	{
		global $CDB;
		if($faction == 0)
		{
			$count = $CDB->num_rows("SELECT COUNT(*) FROM `characters` WHERE `online`='1'");
		}
		elseif($faction == 1)
		{
			$count = $CDB->num_rows("SELECT COUNT(*) FROM `characters` WHERE `online`='1' AND (`race` = 1 OR `race` = 3 OR `race` = 4 OR `race` = 7 OR `race` = 11)");
		}
		elseif($faction == 2)
		{
			$count = $CDB->num_rows("SELECT COUNT(*) FROM `characters` WHERE `online`='1' AND (`race` = 2 OR `race` = 5 OR `race` = 6 OR `race` = 8 OR `race` = 10)");
		}
		return $count['COUNT(*)'];
	}
	
//	************************************************************
// Gets a list of all online characters
// @$faction: 1 = ally, 2 = horde, and 0 is both
// @$start = starting record. for paging etc etc
// @$limit = the limit of records returned

	function getOnlineList($faction = 0, $start = 0, $limit = 10000)
	{
		global $CDB;
		if($faction == 0)
		{
			$list = $CDB->select("SELECT guid, name, race, class, gender, level, zone  FROM `characters` WHERE `online`='1' LIMIT $start, $limit");
		}
		elseif($faction == 1)
		{
			$list = $CDB->select("SELECT guid, name, race, class, gender, level, zone  FROM `characters` WHERE `online`='1' AND 
				(`race` = 1 OR `race` = 3 OR `race` = 4 OR `race` = 7 OR `race` = 11)
			LIMIT $start, $limit");
		}
		elseif($faction == 2)
		{
			$list = $CDB->select("SELECT guid, name, race, class, gender, level, zone  FROM `characters` WHERE `online`='1' AND 
				(`race` = 2 OR `race` = 5 OR `race` = 6 OR `race` = 8 OR `race` = 10)
			LIMIT $start, $limit");
		}
		return $list;
	}

	
//	************************************************************
// Gets the top kills for a specific faction
// $faction: 1 = ally, 0 for horde
// $count: top $count results

	function getFactionTopKills($faction, $count)
	{
		global $CDB;

		if($CDB->selectRow("SHOW TABLES LIKE 'character_honor_cp'") > 0) // old version
		{
			if($faction == 1)
			{			
				$row = $CDB->select("SELECT 
					characters.race, 
					characters.class, 
					characters.gender, 
					characters.level, 
					characters.name, 
					COUNT(*) qty 
				FROM 
					character_honor_cp 
				INNER JOIN 
					characters 
				ON 
					character_honor_cp.guid = characters.guid 
				WHERE 
					characters.race=1 OR 
					characters.race=3 OR 
					characters.race=4 OR 
					characters.race=7 OR 
					characters.race=11
				GROUP BY 
					character_honor_cp.guid
				ORDER BY 
					qty DESC 
				LIMIT 50;");			
			}
			else # Horde
			{			
				$row = $CDB->select("SELECT 
					characters.race, 
					characters.class, 
					characters.gender, 
					characters.level, 
					characters.name, 
					COUNT(*) qty 
				FROM 
					character_honor_cp 
				INNER JOIN 
					characters 
				ON 
					character_honor_cp.guid = characters.guid 
				WHERE 
					characters.race=2 OR 
					characters.race=5 OR 
					characters.race=6 OR 
					characters.race=8 OR 
					characters.race=10
				GROUP BY 
					character_honor_cp.guid
				ORDER BY 
					qty DESC 
				LIMIT 50;");			
			}
			
			if($row == FALSE)
			{
				return FALSE;
			}
			else
			{
				return $row;
			}
		}
		
		// Alliance
		if($faction == 1)
		{			
			$row = $CDB->select("SELECT * FROM `characters` WHERE `totalkills` > 0 AND (
				`race` = 1 OR `race` = 3 OR `race` = 4 OR `race` = 7 OR `race` = 11
			) ORDER BY `totalkills` DESC LIMIT $count");
		}
		else # Horde
		{			
			$row = $CDB->select("SELECT * FROM `characters` WHERE `totalkills` > 0 AND (
				`race` = 2 OR `race` = 5 OR `race` = 6 OR `race` = 8 OR `race` = 10
			) ORDER BY `totalkills` DESC LIMIT $count");
		}
		if($row == FALSE)
		{
			return FALSE;
		}
		else
		{
			return $row;
		}
	}
	
//	************************************************************
// Checks if the character is in a guild or not

	public function checkGuild($guid)
	{
		global $CDB;
		$check = $CDB->selectCell("SELECT `guildid` FROM `guild_member` WHERE guid='$guid'");
		if ($check == FALSE)
		{		
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

//	************************************************************
// Checks to see if the character is online. returns TRUE if character is online

	public function isOnline($guid)
    {
		global $CDB;
		$guid = $CDB->real_escape_string($guid);
        $row = $CDB->num_rows("SELECT COUNT(*) AS `count` FROM `characters` WHERE `guid` = '$guid' AND `online` = '1'");
        if($row['count'] > 0) 
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
    }

//	************************************************************
// Checks if the character name exists or not

	public function checkNameExists($name)
	{
		global $CDB;
		$check = $CDB->selectRow("SELECT * FROM `characters` WHERE `name` LIKE '$name'");
		if ($check !== FALSE) 
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
// === RACE / FACTION CHANGER SCRIPTS (borrowed form dp92 :) )=== //
	
//	************************************************************
// This function returns a TRUE if the givien race and class are an allowed mix.

	public function goodRaceClassMix($race, $class)
	{
		switch ($race) 
		{
			case 1:
				if ($class == 1 || $class == 2 || $class == 4 || $class == 5 || $class == 6 || $class == 8 || $class == 9) 
				{ 
					return TRUE; 
				}
				break;
			case 2:
				if ($class == 1 || $class == 3 || $class == 4 || $class == 6 || $class == 7 || $class == 9) 
				{ 
					return TRUE; 
				}
				break;
			case 3:
				if ($class == 1 || $class == 2 || $class == 3 || $class == 4 || $class == 5 || $class == 6) 
				{ 
					return TRUE; 
				}
				break;
			case 4:
				if ($class == 1 || $class == 3 || $class == 4 || $class == 5 || $class == 6 || $class == 11) 
				{ 
					return TRUE; 
				}
				break;
			case 5:
				if ($class == 1 || $class == 4 || $class == 5 || $class == 6 || $class == 8 || $class == 9) 
				{ 
					return TRUE; 
				}
				break;
			case 6:
				if ($class == 1 || $class == 3 || $class == 6 || $class == 7 || $class == 11) 
				{ 
					return TRUE; 
				}
				break;
			case 7:
				if ($class == 1 || $class == 4 || $class == 6 || $class == 8 || $class == 9) 
				{ 
					return TRUE; 
				}
				break;
			case 8:
				if ($class == 1 || $class == 3 || $class == 4 || $class == 5 || $class == 6 || $class == 7 || $class == 8) 
				{ 
					return TRUE; 
				}
				break;
			case 10:
				if ($class == 2 || $class == 3 || $class == 4 || $class == 5 || $class == 6 || $class == 8 || $class == 9) 
				{ 
					return TRUE; 
				}
				break;
			case 11:
				if ($class == 1 || $class == 2 || $class == 3 || $class == 5 || $class == 6 || $class == 7 || $class == 8) 
				{ 
					return true; 
				}
				break;
        }
         return FALSE;
	}

//	************************************************************
// Gets the characters home reputation, ex: Human = Stormwind

	public function getHomeRep($race)
	{
		switch ($race) 
		{
			case 1:
				 return 72;
				 break;
			case 2:
				 return 76;
				 break;
			case 3:
				 return 47;
				 break;
			case 4:
				 return 69;
				 break;
			case 5:
				 return 68;
				 break;
			case 6:
				 return 81;
				 break;
			case 7:
				 return 54;
				 break;
			case 8:
				 return 530;
				 break;
			case 10:
				 return 911;
				 break;
			case 11:
				 return 930;
				 break;
        }
	}

//	************************************************************	
// Deletes users mounts. Mainly used when changing faction.

	public function delMounts($guid, $race)
	{
		global $CDB;
        switch ($race) 
		{
			case 1:
				$CDB->query("DELETE FROM character_spell WHERE guid='$guid' AND (spell=472 or spell=6648 or spell=458 or spell=470 or spell=23229 or spell=23228 or spell=23227 or spell=63232 or spell=65640)");
				$CDB->query("DELETE FROM character_aura WHERE guid='$guid' AND (spell=472 or spell=6648 or spell=458 or spell=470 or spell=23229 or spell=23228 or spell=23227 or spell=63232 or spell=65640)");
				$CDB->query("DELETE FROM character_inventory WHERE guid='$guid' AND (item_template=2414 or item_template=5655 or item_template=5656 or item_template=2411 or item_template=18777 or item_template=18778 or item_template=18776 or item_template=45125 or item_template=46752)");
				break;
			case 2:
				$CDB->query("DELETE FROM character_spell WHERE guid='$guid' AND (spell=580 or spell=6653 or spell=6654 or spell=64658 or spell=23250 or spell=23252 or spell=23251 or spell=63640 or spell=65646)");
				$CDB->query("DELETE FROM character_aura WHERE guid='$guid' AND (spell=580 or spell=6653 or spell=6654 or spell=64658 or spell=23250 or spell=23252 or spell=23251 or spell=63640 or spell=65646)");
				$CDB->query("DELETE FROM character_inventory WHERE guid='$guid' AND (item_template=1132 or item_template=5665 or item_template=5668 or item_template=46099 or item_template=18796 or item_template=18798 or item_template=18797 or item_template=45595 or item_template=46749)");
				break;
			case 3:
				$CDB->query("DELETE FROM character_spell WHERE guid='$guid' AND (spell=6777 or spell=6898 or spell=6899 or spell=23239 or spell=23240 or spell=23238 or spell=63636 or spell=65643)");
				$CDB->query("DELETE FROM character_aura WHERE guid='$guid' AND (spell=6777 or spell=6898 or spell=6899 or spell=23239 or spell=23240 or spell=23238 or spell=63636 or spell=65643)");
				$CDB->query("DELETE FROM character_inventory WHERE guid='$guid' AND (item_template=5864 or item_template=5873 or item_template=5872 or item_template=18787 or item_template=18785 or item_template=18786 or item_template=45586 or item_template=46748)");
				break;
			case 4:
				$CDB->query("DELETE FROM character_spell WHERE guid='$guid' AND (spell=8394 or spell=10789 or spell=10793 or spell=66847 or spell=23338 or spell=23219 or spell=23221 or spell=63637 or spell=65638)");
				$CDB->query("DELETE FROM character_aura WHERE guid='$guid' AND (spell=8394 or spell=10789 or spell=10793 or spell=66847 or spell=23338 or spell=23219 or spell=23221 or spell=63637 or spell=65638)");
				$CDB->query("DELETE FROM character_inventory WHERE guid='$guid' AND (item_template=8631 or item_template=8632 or item_template=8629 or item_template=47100 or item_template=18902 or item_template=18767 or item_template=18766 or item_template=45591 or item_template=46744)");
				break;
			case 5:
				$CDB->query("DELETE FROM character_spell WHERE guid='$guid' AND (spell=64977 or spell=17464 or spell=17463 or spell=17462 or spell=17465 or spell=23246 or spell=66846 or spell=63643 or spell=65645)");
				$CDB->query("DELETE FROM character_aura WHERE guid='$guid' AND (spell=64977 or spell=17464 or spell=17463 or spell=17462 or spell=17465 or spell=23246 or spell=66846 or spell=63643 or spell=65645)");
				$CDB->query("DELETE FROM character_inventory WHERE guid='$guid' AND (item_template=46308 or item_template=13333 or item_template=13332 or item_template=13331 or item_template=13334 or item_template=18791 or item_template=47101 or item_template=45597 or item_template=46746)");
				break;
			case 6:
				$CDB->query("DELETE FROM character_spell WHERE guid='$guid' AND (spell=18990 or spell=18989 or spell=64657 or spell=23249 or spell=23248 or spell=23247 or spell=63641 or spell=65641)");
				$CDB->query("DELETE FROM character_aura WHERE guid='$guid' AND (spell=18990 or spell=18989 or spell=64657 or spell=23249 or spell=23248 or spell=23247 or spell=63641 or spell=65641)");
				$CDB->query("DELETE FROM character_inventory WHERE guid='$guid' AND (item_template=15290 or item_template=15277 or item_template=46100 or item_template=18794 or item_template=18795 or item_template=18793 or item_template=45592 or item_template=46750)");
				break;
			case 7:
				$CDB->query("DELETE FROM character_spell WHERE guid='$guid' AND (spell=10969 or spell=17453 or spell=10873 or spell=17454 or spell=23225 or spell=23223 or spell=23222 or spell=63638 or spell=65642)");
				$CDB->query("DELETE FROM character_aura WHERE guid='$guid' AND (spell=10969 or spell=17453 or spell=10873 or spell=17454 or spell=23225 or spell=23223 or spell=23222 or spell=63638 or spell=65642)");
				$CDB->query("DELETE FROM character_inventory WHERE guid='$guid' AND (item_template=8595 or item_template=13321 or item_template=8563 or item_template=13322 or item_template=18772 or item_template=18773 or item_template=18774 or item_template=45589 or item_template=46747)");
				break;
			case 8:
				$CDB->query("DELETE FROM character_spell WHERE guid='$guid' AND (spell=8395 or spell=10796 or spell=10799 or spell=23241 or spell=23242 or spell=23243 or spell=63635 or spell=65644)");
				$CDB->query("DELETE FROM character_aura WHERE guid='$guid' AND (spell=8395 or spell=10796 or spell=10799 or spell=23241 or spell=23242 or spell=23243 or spell=63635 or spell=65644)");
				$CDB->query("DELETE FROM character_inventory WHERE guid='$guid' AND (item_template=8588 or item_template=8591 or item_template=8592 or item_template=18788 or item_template=18789 or item_template=18790 or item_template=45593 or item_template=46743)");
				break;
			case 10:
				$CDB->query("DELETE FROM character_spell WHERE guid='$guid' AND (spell=35022 or spell=35020 or spell=34795 or spell=35018 or spell=35025 or spell=35027 or spell=33660 or spell=63642 or spell=65639)");
				$CDB->query("DELETE FROM character_aura WHERE guid='$guid' AND (spell=35022 or spell=35020 or spell=34795 or spell=35018 or spell=35025 or spell=35027 or spell=33660 or spell=63642 or spell=65639)");
				$CDB->query("DELETE FROM character_inventory WHERE guid='$guid' AND (item_template=29221 or item_template=29220 or item_template=28927 or item_template=29222 or item_template=29223 or item_template=29224 or item_template=28936 or item_template=45596 or item_template=46751)");
				break;
			case 11:
				$CDB->query("DELETE FROM character_spell WHERE guid='$guid' AND (spell=34406 or spell=35710 or spell=35711 or spell=35713 or spell=35712 or spell=35714 or spell=63639 or spell=65637)");
				$CDB->query("DELETE FROM character_aura WHERE guid='$guid' AND (spell=34406 or spell=35710 or spell=35711 or spell=35713 or spell=35712 or spell=35714 or spell=63639 or spell=65637)");
				$CDB->query("DELETE FROM character_inventory WHERE guid='$guid' AND (item_template=28481 or item_template=29744 or item_template=29743 or item_template=29745 or item_template=29746 or item_template=29747 or item_template=45590 or item_template=46745)");
				break;
        }
		return TRUE;
	}

//	************************************************************	
// Gives the race his racial mounts

	function addMounts($guid,$race) 
	{
		global $CDB;
        switch ($race) 
		{
			case 1:
				$mount1 = 472;
				$mount2 = 23229;
				break;
			case 2:
				$mount1 = 580;
				$mount2 = 23250;
				break;
			case 3:
				$mount1 = 6777;
				$mount2 = 23239;
				break;
			case 4:
				$mount1 = 8394;
				$mount2 = 23338;
				break;
			case 5:
				$mount1 = 64977;
				$mount2 = 23246;
				break;
			case 6:
				$mount1 = 18990;
				$mount2 = 23249;
				break;
			case 7:
				$mount1 = 10969;
				$mount2 = 23225;
				break;
			case 8:
				$mount1 = 8395;
				$mount2 = 23241;
				break;
			case 10:
				$mount1 = 35022;
				$mount2 = 35025;
				break;
			case 11:
				$mount1 = 34406;
				$mount2 = 35713;
				break;
        }
        $pop = $CDB->num_rows("SELECT COUNT(*) FROM character_spell WHERE guid='$guid' AND spell=33388");
        if ($pop > 0) 
		{
           $CDB->query("INSERT INTO character_spell (guid,spell) VALUES ('$guid','$mount1')");
        }
        $pep = $CDB->num_rows("SELECT COUNT(*) FROM character_spell WHERE guid='$guid' AND (spell=33391 or spell=34090 or spell=34091)");
        if ($pep > 0) 
		{
           $CDB->query("INSERT INTO character_spell (guid,spell) VALUES ('$guid','$mount1')");
           $CDB->query("INSERT INTO character_spell (guid,spell) VALUES ('$guid','$mount2')");
        }
		return TRUE;
	}
	
// === END RACE / FACTION CHANGER SCRIPTS === //
	
// ==== SET FUNCTIONS ==== //

//	************************************************************
// Sets the new name for character ID
	
	public function setName($guid, $newname)
	{
		global $CDB;
		$guid = $CDB->real_escape_string($guid);
		$newname = $CDB->real_escape_string(strtolower($newname));
        $newname = ucfirst($newname);
		$send = $CDB->query("UPDATE `characters` SET `name`='$newname' WHERE `guid`='$guid'");
		return TRUE;
	}

//	************************************************************
// Sets the account ID for character ID
	
	public function setAccountId($guid, $accountId)
    {
		global $CDB;
        $guid = $CDB->real_escape_string($guid);
        $acct = $CDB->real_escape_string($accountId);
        $CDB->query("UPDATE `characters` SET `account` = '$acct' WHERE `guid` = '$guid' LIMIT 1");
        return true;
    }

//	************************************************************
// Sets the ammount of gold for character ID
	
	public function setMoney($id, $newmoney)
	{
		global $CDB;
		$m = $CDB->selectRow("SELECT `money` FROM characters WHERE `guid`='$id'");
		if($m == FALSE)
		{
			return FALSE;
		}
		else
		{
			$CDB->query("UPDATE `characters` SET `money`='$newmoney' WHERE `guid`='$id'");
			return TRUE;
		}
	}

//	************************************************************
// Sets the level for character ID	
	public function setLevel($id, $newlvl)
	{
		global $CDB;
		$lvl = $CDB->selectRow("SELECT `level` FROM characters WHERE `guid`='$id'");
		if($lvl == FALSE)
		{
			return FALSE;
		}
		else
		{
			$CDB->query("UPDATE `characters` SET `level`='$newlvl' WHERE `guid`='$id'");
			return TRUE;
		}
	}

//	************************************************************
// Sets the amount of expieriance for character ID	

	public function setXp($id, $exp)
	{
		global $CDB;
		$lvl = $CDB->selectRow("SELECT `name` FROM characters WHERE `guid`='$id'");
		if($lvl == FALSE)
		{
			return FALSE;
		}
		else
		{
			$CDB->query("UPDATE `characters` SET `xp`='$exp' WHERE `guid`='$id'");
			return TRUE;
		}
	}
	

// === At Login Functions === //

//	************************************************************
// Gets the at login flag for character $id
	public function getAtLogin($id)
	{
		global $CDB;
		$check = $CDB->selectCell("SELECT `at_login` FROM `characters` WHERE `guid`='".$id."'");
		if($check == FALSE)
		{
			return FALSE;
		}
		return $check;
	}

//	************************************************************
// Rename (flag = 1)
	public function setRename($id)
	{
		global $CDB;
		$check = $CDB->selectCell("SELECT `at_login` FROM `characters` WHERE `guid`='".$id."'");
		if($check & 1)
		{
			return FALSE;
		}
		else
		{
			$CDB->query("UPDATE `characters` SET `at_login`=(`at_login` + 1) WHERE `guid`='".$id."'");
			return TRUE;
		}
	}
	
//	************************************************************
// Resets talents (flag = 4)
	public function setResetTalents($id)
	{
		global $CDB;
		$check = $CDB->selectCell("SELECT `at_login` FROM `characters` WHERE `guid`='".$id."'");
		if($check & 4)
		{
			return FALSE;
		}
		else
		{
			$CDB->query("UPDATE `characters` SET `at_login`=(`at_login` + 4) WHERE `guid`='".$id."'");
			return TRUE;
		}
	}
	
//	************************************************************
// Re-Customize (flag = 8)
	public function setCustomize($id)
	{
		global $CDB;
		$check = $CDB->selectCell("SELECT `at_login` FROM `characters` WHERE `guid`='".$id."'");
		if($check & 8)
		{
			return FALSE;
		}
		else
		{
			$CDB->query("UPDATE `characters` SET `at_login`=(`at_login` + 8) WHERE `guid`='".$id."'");
			return TRUE;
		}
	}
	
//	************************************************************
// Resets all `at_login`'s to 0

	public function resetAtLogin($id)
	{
		global $CDB;
		$CDB->query("UPDATE `characters` SET `at_login`=0 WHERE `guid`='".$id."'");
		return TRUE;
	}
}
?>
