<?php
/*
====+++========
Open Tibia XML Data Validator
Under GPL v3 License
Author: Pavlus
Language file
====+++========
*/

require_once('./config.php'); //this line must be included!

//error messages

$error['php_version'] = 'Your PHP version is out of date! At least 5.0.0 version is required. Script is terminating';
$error['directory'] = 'You have entered bad path to your account, players or vip catalogue. Change this in config.php file. Script is now terminating.';
$error['simplexml'] = 'Your PHP doesn`t support simplexml_file_load function. Script is terminating.';
$error['unlink'] = 'Your PHP doesn`t support unlink function. Script is terminating.';
$error['xml_syntax'] = 'Fatal error: Syntax broken in XML file!';
$error['wrong_digits'] = 'Account number not equals '.$account['digits'].'';
$error['empty_pass'] = 'Empty password';
$error['wrong_type'] = 'Wrong account type';
$error['prem_without_value'] = 'remDays attribute is empty';
$error['prem_not_int'] = 'premDays is not numeric';
$error['prem_less_zero'] = 'premDays is less than zero!';
$error['prem_max'] = 'premDays is bigger than '.$premDay['limit'].'';
$error['empty_account'] = 'Account file without character in it';
$error['account_max'] = 'Maximum characters for account exceeded ('.$maxchars.')';
$error['account_miss'] = 'Account file missing for player';
$error['sum'] = 'Number of errors:';
$error['deleting'] = 'Error occured during deletion your folder with files must have write-acces rights!<br>';
$error['unlinked'] = 'Number of deleted files:';
$error['changed'] = 'Number of changed files:';
$error['sex_numeric'] = 'Sex attriubute is not numerical value';
$error['sex_value'] = 'Sex attribute have not permitted value';
$error['lookdir_value'] = 'Lookdir attribute have not permitted value';
$error['exp_value'] = 'Exp attribute have not permitted value';
$error['vip_exists'] = 'Missing account file for this VIP';
$error['health'] = 'Health now and Health maximum have undesired value';
$error['mana'] = 'Mana now and Mana maximum have undesired value';  
$error['manamax_l'] = 'Mana max not corresponds to level'; 
$error['healthmax_l'] = 'Health max not corresponds to level'; 
$error['cap_l'] = 'Capacity not corresponds to level'; 


//header msg

$head['title'] = 'XML VALIDATOR RAPORT';
$head['version'] = 'VERSION';
$head['date'] = 'DONE';
$head['file_count'] = 'EXAMINED FILES';


//raport output titles

$title['vip'] = 'Checking vip files: OK';
$title['exp'] = 'Checking experience: OK';
$title['lookdir'] = 'Checking lookdir: OK';
$title['sex_dig'] = 'Checking sex: OK'; 
$title['digits'] = 'Checking number of account digits: OK';
$title['pass'] = 'Checking passwords: OK';
$title['types'] = 'Checking types: OK';
$title['prem'] = 'Checking premDays: OK';
$title['char'] = 'Checking characters: OK';
$title['acc_num'] = 'Checking account number: OK';
$title['health'] = 'Checking players health: OK';
$title['mana'] = 'Checking players mana: OK';   
$title['var_l'] = 'Level versus other player data: OK';

//head messages, what kind of files we examined

$mode['accounts'] = 'Results of checking accounts folder';
$mode['players'] = 'Results of checking players folder';

//misc

$misc['core_changed'] = 'Core file of Validator has been changed! You run now at your own risk';
$misc['raport_chmod'] = 'LOG folder should have read & write acces! (chmod 777)';
$sec = 'sec';
$gener = 'Raport is generating now, please be patient';
$eta = 'It may take few seconds or few minutes, it depends of number of files to be examined';



?>
