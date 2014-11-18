<?php

/*
====+++========
Open Tibia XML Data Validator
Under GPL v3 License
Author: Pavlus
Configuration file
====+++========
*/


$UNIX = 1; //set this to 1 if u use UNIX`s family operational system, if Windows set this to 0.

$lang = 'en'; // choose your language 'pl' for polish, and 'en' - english

/*
'en' means name of file included in lang folder, you can export your own
translation there and name file will be the value of $lang
*/


$path['acc'] = '/home/pavlus/ots/accounts/'; // accounts folder path f.e /home/pavlus/ots/accounts/
$path['pla'] = '/home/pavlus/ots/players/'; // players path

//REMEMBER TO USE ONLY "/", it is true on windows and linux but "\\" will corrupt the results.

$saveLog = 1; 
//0 - no html raport export, 
//1- with raport export, 
//2- only export to file (without listing in browser - good while working with cron)

$account['digits'] = 6;	//number of digits for account

$premDay['limit'] = 60; // if player have more than $premDay will show error
$premDay['rigid'] = 1; //script will set this value if someone exceeded limit
//$maxchars = 1; // maximum# of players attached to one account, type 0 to disable

################# USE THOSE SETTINGS CAREFULLY ####################################

$change = 0; //set this to "1" if u want script changed some values automatically
// Script now offers changes of:

#1. premDays if it`s bigger than limit
#2. type if corrupted will set to 1

$unlink = 0; // set this to 0 if you dont want validator delete empty accounts or missing player account
//your accounts and players folders have to have write-access (chmod 777 in linux)
//remember to make a BACKUP before running script!

#####################################################################################

$except['acc'] = array('0.xml','1.xml'); //if you doesn`t want to examine some account numbers, divide by coma.
$except['pla']= array('Pavlus.xml'); //the same exception for players

/*
DO NOT EDIT! UNDER YOU KNOW WHAT ARE YOU DOING


##########################################################
*/



//constant

define ("VERSION", "0.0.5a");
define("STATUS", "Beta");
define("CORE_SIZE", "11753");

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
