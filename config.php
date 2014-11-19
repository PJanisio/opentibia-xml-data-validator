<?php
/*
====+++========
Open Tibia XML Data Validator
Under GPL v3 License
Author: Pavlus
Configuration file
====+++========
*/

#################### STANDARD SETTINGS #######################
$lang = 'en'; // choose your language 'pl' for polish, and 'en' - english
$path['data'] = 'G:/OTS/data/'; // path to your opentibia server data directory
$saveLog = 1; //0 - no raport / 1 - default html export / 2 - export to file
$account['digits'] = 6;	//number of digits for account
$premDay['limit'] = 300; // if player have more than $premDay will show error (yurots new year bug)

#################### FILE WRITE/REMOVE SETTINGS #######################
$change = 0; //set this to "1" if u want to allow modifying files by this script
$premDay['rigid'] = 1; //if modifying is allowed, script will set 1 premday when player exceed the limit of premdays 
$unlink = 0; // set this to 0 if you dont want validator delete empty accounts or missing player account
//remember to make a BACKUP before running script!

######################## EXCEPTIONS #########################
$except['acc'] = array('0.xml', '1.xml'); //if you doesn`t want to examine some account numbers, divide by coma.
$except['pla']= array('Marco Polo.xml', 'GM.xml'); //the same exception for players

#END OF CONFIGURATION




/*
DO NOT EDIT CODE BELOW! UNDER YOU KNOW WHAT ARE YOU DOING
##########################################################
*/

//constants

define ("VERSION", "0.0.5a");
define("STATUS", "Beta");
define("CORE_SIZE", "11891");

//OS check

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $UNIX = 0;
} else {
    $UNIX = 1;
}

//generate players, accounts, vip folder

$path['acc'] = $path['data'].'/accounts/'; // accounts folder path f.e /home/pavlus/ots/accounts/
$path['pla'] = $path['data'].'/players/'; // players path
$path['vip'] = $path['data'].'/vip/'; //vip path

//functions


function parseFile($path, $echo)
	{
		
		if($echo == 1)
		
		{
		
		$n =  end(explode('/', $path));
			echo '<b>'.$n.'</b>';
			}
				
		
			else if($echo == 0)
				{
						$n = end(explode ('/', $path));
								return $n;
						}
		}
		

		
function error_color($string, $color)
	{
		echo '<b><font color='.$color.'>'.$string.'</font></b>';
		
		}
		
		
function count_files($mode)
{
	global $path;
		global $pla_num;
			global $acc_num;
	
	if($mode == 1)
		{
				$od = openDir($path['pla']);

					$pla_num = -2;
						while(readDir($od) !== false){
							$pla_num++;
		}
					closeDir($od);

			return $pla_num;
}

if($mode == 0)
		{
				$od = openDir($path['acc']);

						$acc_num = -2;
							while(readDir($od) !== false){
								$acc_num++;
		}
					closeDir($od);
		return $acc_num; 	
	
	
	}
}

function gentime() {
    static $a;
    if($a == 0) $a = microtime(true);
    else return (string)(microtime(true)-$a);
} 

	
function listErrors()
{
	global $err;
	
	if($err > 1)
		{
			echo error_color($err, red);

			}
			
			else if ($err == 1)
				{
					echo error_color('1', red);
					}
				else if ($err == 0)
				{
					echo '0';
					}
	}
	
	function deletedFiles()
	{
		global $unlinked;
		global $unlink;
			
			if($unlink == 1)
			{
				if($unlinked > 1)
				{
				echo error_color($unlinked, green);
				}
					else if($unlinked == 0)
					{
						echo error_color('0', green);
						}
				}
	}
	
	function changedFiles()
	{
		global $changed;
		global $change;
			
			if($change == 1)
			{
				if($changed > 1)
				{
				echo error_color($changed, orange);
				}
					else if($changed == 0)
					{
						echo error_color('0', orange);
						}
				}
	}
			

?>
