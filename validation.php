<?php

/*
====+++========
Open Tibia XML Data Validator
Under GPL v3 License
Author: Pavlus
Validator main file
====+++========
*/


require_once ('config.php');

//loading language file
if(file_exists('lang/'.$lang.'.php'))
	{
		require_once('lang/'.$lang.'.php');
		}
			else
			{
				echo 'Wrong language type. Change in config.php: $lang.';
				exit();
				}

//php version check
if(version_compare(PHP_VERSION, '5.0.0', '<'))
	{
		echo $error['php_version'].' </br>';
		exit();
		}
		
//checking safe mode
if(!ini_get('safe_mode'))
	{
//checking timeout ini file
$timeout = ini_get('max_execution_time'); //ini file check
if($timeout < 540)
{
$set_timeout = @ini_set('max_execution_time',0);

//	if(!$set_timeout)
	//	echo 'FAILED TO CHANGE PHP.INI';
}

	}
			
//user error finder
//will not work if this function is disabled
//what i wanted to say by writing this? dunno....

if(!function_exists(simplexml_load_file))
	{
		echo $error['simplexml'];
		exit();
		}	
if(!function_exists(unlink))
	{
		echo $error['unlink'];
		exit();
		}
//path is incorrect?
if(!is_dir($path['acc']) || !is_dir($path['pla']) || !is_dir($path['vip']))
	{
		echo $error['directory'];
		exit();
		}
		
/*
Main code
*/
ob_start();

if($UNIX == 1)
	{
		
		$old_chmod = substr(sprintf('%o', fileperms($path['pla'])), -4); //retriving chmod			
				$old_chmod_changed = octdec($old_chmod); //we have to do it :/		
		@chmod($path['pla'], 0777);
			//we shall change chmods of our working directories before unlinking some files
			@chmod($path['acc'], 0777);
				@chmod($path['vip'], 0777);
			}

		count_files(0);
		count_files(1); // examined file counter
	
$date = date("F j, Y, g:i a");
$validated = $pla_num + $acc_num;
$excluded = $files.'0.xml';

//raport header



echo '==============================<br>
= '.$head['title'].'<br>
= '.$head['version'].': '.VERSION.' ('.STATUS.')<br>
= '.$head['date'].': '.$date.'<br>
= '.$head['file_count'].': '.$validated.'<br>
          ==============================<br><br><br>
';

//SOME NASTY SHIT
$err = 0; // no erros at begining :)
$unlinked = 0; //deleted at beggining ? ;]
$changed = 0; //changed files at beggining 

//ACCOUNTS CHECK
	echo '<b>'.$mode['accounts'].'</b><br><br>';

//number of digits
	gentime();		
		$files = glob($path['acc'] .'*.xml');
			foreach($files as $file) 
			{
					if(!in_array(parseFile($file,0), $except['acc']))
						{
				$xml = @simplexml_load_file($file);
		
			if(!$xml)
			{
				echo error_color(parseFile($file, 1).' '.$error['xml_syntax'].'<br>', red);
				++$err;
				
				if($unlink == 1)
					{
							if($UNIX == 1)
								{
									@chmod($file, 0777);
									}			
				$del = @unlink($file);
				
					if(!$del)
						{
							echo $error['deleting'];
							}
								else
								{
									echo error_color(parseFile($file, 1).' Deleted succesfully</br>', green);
									--$err;
									++$unlinked;
								}			
				}
				}
				
				$dig = strlen(trim(parseFile($file, 0)));
								
						if ($dig != $account['digits'] + 4)
							{
								echo error_color(parseFile($file, 1).' '.$error['wrong_digits'].'('.($dig -4).')<br>', red);
										++$err;
										
										if($unlink == 1)
					{
							if($UNIX == 1)
								{
									@chmod($file, 0777);
									}
				
				$del = @unlink($file);
				
					if(!$del)
						{
							echo $error['deleting'];
							}
								else
								{
									echo error_color(parseFile($file, 1).' Deleted succesfully</br>', green);
									--$err;
									++$unlinked;
								}
				
					}
							}
			}
			}
			
echo '* '.$title['digits'].' ['.round(gentime(), 4).' '.$sec.'.]<br><br>';	
	

//passwords

    gentime();

//$files = glob($path['acc'] . '*.xml');

foreach($files as $file) {
    $xml = @simplexml_load_file($file);
	if(!$xml)
			{
	//echo $excluded;

		if(!in_array(parseFile($file,0), $except['acc']))
						{
		
if(empty($xml['pass']))

    {
        echo error_color(parseFile($file, 1).' '.$error['empty_pass'].'<br>', red);
			++$err;
    }

						}
			}
						}
echo '* '.$title['pass'].' ['.round(gentime(), 4).' '.$sec.'.]<br><br>';

//types

    gentime(); 
    
       //$files = glob($path['acc'] . '*.xml');

foreach($files as $file) {
    $xml = @simplexml_load_file($file);
	
if(!in_array(parseFile($file,0), $except['acc']))
						{
if(empty($xml['type']) || $xml['type'] != 1)
    {
        echo error_color(parseFile($file, 1).' '.$error['wrong_type'].' ('.$xml['type'].')<br>', red);
			++$err;
			
			if($change == 1)
					{
				$xml['type'] = 1;   //change to type="1"
        $make_change = @file_put_contents($file, $xml->asXML());
		
						if(!$make_change)
						{
							echo $error['change'];
							}
								else
								{
									echo error_color(parseFile($file, 1).' Changed succesfully</br>', orange);
									--$err;
									++$changed;
									}
								
		}
    }

}
}
echo '* '.$title['types'].' ['.round(gentime(), 4).' '.$sec.'.]<br><br>';

//premdays

gentime();

 //$files = glob($path['acc'] . '*.xml');

foreach($files as $file) {
    
    $xml = @simplexml_load_file($file);
	
	if(!in_array(parseFile($file,0), $except['acc']))
						{
$prem =  trim($xml['premDays']); 
$lastsave = trim($xml['lastsaveday']);

	//string...lol
	//echo var_dump($prem);
    
if(($prem == ''))

    {
		
			echo error_color(parseFile($file, 1).' '.$error['prem_without_value'].'<br>', red);
				++$err;
    }	
        else if(is_numeric($prem) == false) 
            {
                
               echo error_color(parseFile($file, 1).' '.$error['prem_not_int'].'<br>', red); 
					++$err;
                
            }		
else if ($prem > $premDay['limit'])
	{
			echo error_color(parseFile($file, 1).' '.$error['prem_max'].' ('.$prem.')<br>', red);
				++$err;
				
					if($change == 1)
					{
				$xml['premDays'] = $premDay['rigid'];   //how many premdays will have
        $make_change = @file_put_contents($file, $xml->asXML());
		
						if(!$make_change)
						{
							echo $error['change'];
							}
								else
								{
									echo error_color(parseFile($file, 1).' Changed succesfully</br>', orange);
									--$err;
									++$changed;
									}					
		}

				}

else if ($prem < 0)
	{
		echo error_color(parseFile($file, 1).' '.$error['prem_less_zero'].' ('.$prem.')<br>', red);
			++$err;

				if($change == 1)
					{
				$xml['premDays'] = $premDay['rigid'];   //how many premdays will have
				
        $make_change = @file_put_contents($file, $xml->asXML());
		
						if(!$make_change)
						{
							echo $error['change'];
							}
								else
								{
									echo error_color(parseFile($file, 1).' Changed succesfully</br>', orange);
									--$err;
									++$changed;
									}
			}

}
}
}

echo '* '.$title['prem'].' ['.round(gentime(), 4).' '.$sec.'.]<br><br>'; 

gentime();

 //$files = glob($path['acc'] . '*.xml');

		foreach($files as $file) {
if(!in_array(parseFile($file,0), $except['acc']))
						{
		$cont = file_get_contents($file);
				$result = count(explode('character name', $cont));
				
				if($result < 2)
				
				{
					echo error_color(parseFile($file, 1).' '.$error['empty_account'].'<br>', red);
				++$err;								
										
			if($unlink == 1)
					{
							if($UNIX == 1)
								{
									@chmod($file, 0777);
									}
				
				$del = @unlink($file);
				
					if(!$del)
						{
							echo $error['deleting'];
							}
								else
								{
									echo error_color(parseFile($file, 1).' Deleted succesfully</br>', green);
									--$err;
									++$unlinked;
																		}
									}
								}
			
						}
						}
						
echo '* '.$title['char'].' ['.round(gentime(), 4).' '.$sec.'.]<br><br>';

//PLAYERS

echo '<b>'.$mode['players'].'</b><br><br>';

// acc number
gentime();

 $files = glob($path['pla'] . '*.xml');

foreach($files as $file) {
	if(!in_array(parseFile($file,0), $except['pla']))
	{
    
    $xml = @simplexml_load_file($file);
		
		if(!$xml)
			{
				echo error_color(parseFile($file, 1).' '.$error['xml_syntax'].'<br>', red);
				++$err;
				
				if($unlink == 1)
					{
							if($UNIX == 1)
								{
									@chmod($file, 0777);
									}
				
				$del = @unlink($file);
				
					if(!$del)
						{
							echo $error['deleting'];
							}
								else
								{
									echo error_color(parseFile($file, 1).' Deleted succesfully</br>', green);
									--$err;
									++$unlinked;
																		}
				
				}			
				}
				
			$a =  trim($xml['account']); 

	if(!file_exists($path['acc'].$a.'.xml'))
		{
				
			echo error_color(parseFile($file, 1).' '.$error['account_miss'].' <br>', red);
				++$err;
				
				if($unlink == 1)
					{
								if($UNIX == 1)
									{
										@chmod($file, 0777);
										}
				$del = @unlink($file);
				
					if(!$del)
						{
							echo $error['deleting'];
							}
								else
								{
									echo error_color(parseFile($file, 1).' Deleted succesfully</br>', green);
									--$err;
									++$unlinked;
																		}
									}
			
			}
			
}
}
echo ' * '.$title['acc_num'].' ['.round(gentime(), 4).' '.$sec.'.]<br><br>';

// health and health max
gentime();

 //$files = glob($path['pla'] . '*.xml');

foreach($files as $file) {
        
        if(!in_array(parseFile($file,0), $except['pla']))
        {
    
    $xml = @simplexml_load_file($file);
    
         $healthNow = (int)$xml->health['now'];
         $healthMax = (int)$xml->health['max'];
         
         if($healthNow < 0 || $healthMax < 0)
            {
                
                echo error_color(parseFile($file, 1).' '.$error['health'].' <br>', red);
                ++$err;
                
                if($unlink == 1)
                    {
                                if($UNIX == 1)
                                    {
                                        @chmod($file, 0777);
                                        }
                $del = @unlink($file);
                
                    if(!$del)
                        {
                            echo $error['deleting'];
                            }
                                else
                                {
                                    echo error_color(parseFile($file, 1).' Deleted succesfully</br>', green);
                                    --$err;
                                    ++$unlinked;
                                                                        }
                                    }

            }
    
        }
        
        
}

echo ' * '.$title['health'].' ['.round(gentime(), 4).' '.$sec.'.]<br><br>'; 

// mana & mana max
gentime();

 //$files = glob($path['pla'] . '*.xml');

foreach($files as $file) {
        
        if(!in_array(parseFile($file,0), $except['pla']))
        {
    
    $xml = @simplexml_load_file($file);
    
         $manaNow = (int)$xml->mana['now'];
         $manaMax = (int)$xml->mana['max'];
         
         if($manaNow < 0 || $manaMax < 0)
            {
                
                echo error_color(parseFile($file, 1).' '.$error['mana'].' <br>', red);
                ++$err;
                
                if($unlink == 1)
                    {
                                if($UNIX == 1)
                                    {
                                        @chmod($file, 0777);
                                        }
                $del = @unlink($file);
                
                    if(!$del)
                        {
                            echo $error['deleting'];
                            }
                                else
                                {
                                    echo error_color(parseFile($file, 1).' Deleted succesfully</br>', green);
                                    --$err;
                                    ++$unlinked;
                                                                        }
                                    }
             
                
            }
    
        }

}

echo ' * '.$title['mana'].' ['.round(gentime(), 4).' '.$sec.'.]<br><br>';   


// sex
gentime();

 //$files = glob($path['pla'] . '*.xml');

foreach($files as $file) {
		
		if(!in_array(parseFile($file,0), $except['pla']))
		{
    
    $xml = @simplexml_load_file($file);
		
   
			$s =  trim($xml['sex']); 
			//var_dump($s);
				if (!is_numeric($s))
					
					{
						echo error_color(parseFile($file, 1).' '.$error['sex_numeric'].'<br>', red);
						++$err;
						
						}
						
						if($s < 0 || $s > 4)
						{
							echo error_color(parseFile($file, 1).' '.$error['sex_value'].' ('.$s.')<br>', red);
						++$err;
						}
			}
			}
			
echo ' * '.$title['sex_dig'].' ['.round(gentime(), 4).' '.$sec.'.]<br><br>';


//lookdir

gentime();

foreach($files as $file) {
	if(!in_array(parseFile($file,0), $except['pla']))
	{
    
    $xml = @simplexml_load_file($file);
		
   
			$ldir =  trim($xml['lookdir']); 
				//var_dump($ldir);
			
							$ldir_allowed = array ("0","1","2","3");
					
							if(!in_array($ldir, $ldir_allowed))
							{
								echo error_color(parseFile($file, 1).' '.$error['lookdir_value'].' ('.$ldir.')<br>', red);
									++$err;
								
								}			
				}
				}
				

echo ' * '.$title['lookdir'].' ['.round(gentime(), 4).' '.$sec.'.]<br><br>';	

//exp

gentime();

foreach($files as $file) {
	if(!in_array(parseFile($file,0), $except['pla']))
	{
    
    $xml = @simplexml_load_file($file);
		
   
			$exp =  trim($xml['exp']); 
				
					if($exp < 0 || !is_numeric($exp))
					
						{
							echo error_color(parseFile($file, 1).' '.$error['exp_value'].'('.$exp.')<br>', red);
									++$err;
							
							}
				}
				}
					

echo ' * '.$title['exp'].' ['.round(gentime(), 4).' '.$sec.'.]<br><br>';


gentime();

foreach($files as $file) {
	if(!in_array(parseFile($file,0), $except['pla']))
	{
		$xml = simplexml_load_file($file);
	
		$pvoc = $xml['voc'];
		$pcap = $xml['cap'];
		$plevel = $xml['level'];
		$phmax = $xml->health['max'];
		$pmmax = $xml->mana['max'];

	#capacity vs level

		if($pvoc == 1) //sorc
		{
		$trueCap = (($plevel -1)*10)+300;
			if($trueCap != $pcap)
			{
			echo error_color(parseFile($file, 1).' '.$error['cap_l'].' should have: '.$trueCap.' now - '.$pcap.'<br>', red);
									++$err;

			}
		}


		if($pvoc == 2) //druid
		{
		$trueCap = (($plevel-1)*10)+300;
			if($trueCap != $pcap)
			{
			echo error_color(parseFile($file, 1).' '.$error['cap_l'].' should have: '.$trueCap.' now - '.$pcap.'<br>', red);
									++$err;

			}
		}


		if($pvoc == 3) //palladin
		{
		$trueCap = (($plevel-1)*20)+300;
			if($trueCap != $pcap)
			{
			echo error_color(parseFile($file, 1).' '.$error['cap_l'].' should have: '.$trueCap.' now - '.$pcap.'<br>', red);
									++$err;

			}
		}

		if($pvoc == 4) //knight
		{
		$trueCap = (($plevel-1)*25)+300;
			if($trueCap != $pcap)
			{
			echo error_color(parseFile($file, 1).' '.$error['cap_l'].' should have: '.$trueCap.' now - '.$pcap.'<br>', red);
									++$err;

			}
		}
		
#mana gain vs level

if($pvoc == 1) //sorc
		{
		$trueMana = (($plevel-1)*30);
			if($trueMana != $pmmax)
			{
			echo error_color(parseFile($file, 1).' '.$error['manamax_l'].' should have: '.$trueMana.' now - '.$pmmax.'<br>', red);
									++$err;

			}
		}

		if($pvoc == 2) //druid
		{
		$trueMana = (($plevel-1)*30);
			if($trueMana != $pmmax)
			{
			echo error_color(parseFile($file, 1).' '.$error['manamax_l'].' should have: '.$trueMana.' now - '.$pmmax.'<br>', red);
									++$err;
			}
		}

	if($pvoc == 3) //palladin
		{
		$trueMana = (($plevel-1)*15);
			if($trueMana != $pmmax)
			{
			echo error_color(parseFile($file, 1).' '.$error['manamax_l'].' should have: '.$trueMana.' now - '.$pmmax.'<br>', red);
									++$err;

			}
		}

		if($pvoc == 4) //knight
		{
		$trueMana = (($plevel-1)*5);
			if($trueMana != $pmmax)
			{
			echo error_color(parseFile($file, 1).' '.$error['manamax_l'].' should have: '.$trueMana.' now - '.$pmmax.'<br>', red);
									++$err;
			}
		}
	#health vs level

if($pvoc == 1) //sorc
		{
		$trueHealth = (($plevel-1)*5)+150;
			if($trueHealth != $phmax)
			{
			echo error_color(parseFile($file, 1).' '.$error['healthmax_l'].' should have: '.$trueHealth.' now - '.$phmax.'<br>', red);
									++$err;
			}
		}
		if($pvoc == 2) //druid
		{
		$trueHealth = (($plevel-1)*5)+150;
			if($trueHealth != $phmax)
			{
			echo error_color(parseFile($file, 1).' '.$error['healthmax_l'].' should have: '.$trueHealth.' now - '.$phmax.'<br>', red);
									++$err;

			}
		}

	if($pvoc == 3) //palladin
		{
		$trueHealth = (($plevel-1)*10)+150;
			if($trueHealth != $phmax)
			{
			echo error_color(parseFile($file, 1).' '.$error['healthmax_l'].' should have: '.$trueHealth.' now - '.$phmax.'<br>', red);
									++$err;
			}
		}


		if($pvoc == 4) //knight
		{
		$trueHealth = (($plevel-1)*15)+150;
			if($trueHealth != $phmax)
			{
			echo error_color(parseFile($file, 1).' '.$error['healthmax_l'].' should have: '.$trueHealth.' now - '.$phmax.'<br>', red);
									++$err;

			}
		}

	}
}


echo ' * '.$title['var_l'].' ['.round(gentime(), 4).' '.$sec.'.]<br><br>';

//VIP ACCOUNTS

gentime();

$files = glob($path['vip'] . '*.xml');
foreach($files as $file) {
	if(!in_array(parseFile($file,0), $except['acc']))
	{

	 $xml = @simplexml_load_file($file);	
 			if(!$xml)
			{
				echo error_color(parseFile($file, 1).' '.$error['xml_syntax'].'<br>', red);
				++$err;
				
				if($unlink == 1)
					{
						if($UNIX == 1)
							{
								@chmod($file, 0777);
							}
				
				$del = @unlink($file);
				
					if(!$del)
						{
							echo $error['deleting'];
							}
								else
								{
									echo error_color(parseFile($file, 1).' Deleted succesfully</br>', green);
									--$err;
									++$unlinked;
																		}				
				}
				
				}
			if(!file_exists($path['acc'].parseFile($file, 0)))
					{
					echo error_color(parseFile($file, 1).' '.$error['vip_exists'].'<br>', red);
						++$err;
						if($unlink == 1)
					{
						if($UNIX == 1)
							{
								@chmod($file, 0777);
							}			
				$del = @unlink($file);			
					if(!$del)
						{
							echo $error['deleting'];
							}
								else
								{
									echo error_color(parseFile($file, 1).' Deleted succesfully</br>', green);
									--$err;
									++$unlinked;
																		}				
				}

					}					
				}
				}
					

echo ' * '.$title['vip'].' ['.round(gentime(), 4).' '.$sec.'.]<br><br>';		

echo $error['sum'].' ';
	listErrors();
		echo '</br>';
		
		if($unlink == 1)
				{
					echo $error['unlinked'].' ';
							deletedFiles();
								echo '</br>';
				}
					
					if($change == 1)
						{
							echo $error['changed'].' ';
							changedFiles();
							}				
				if($saveLog == 1 || $saveLog == 2)
					{
				
				$output .= '<html>  
<head> 
<!-- Oink! oink! -->
<!-- XML Server Validator by Pavlus -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Validator XML - Raport</title>
<body> ';
				
	$output .= ob_get_contents(); //take cached content
	
		$output .='</body>  
</html>  ';
	
		// Raport saved to file
		
		$date_rap = date("F_j_Y_g_i_a");
		
			$raport_file = './LOG/Raport_'.$date_rap.'.html';
			    
			
					$fp = @fopen($raport_file, "a+"); 

						$fw = @fwrite($fp, $output);  //save													
							@fclose($fp); 
							
							if($saveLog == 2)
							    {							
							ob_end_clean();
							    //cache cleaner
							}						
					}				
		$set_last_timeout = @ini_set('max_execution_time',$timeout); //change exec.time to default value
		if($UNIX == 1)
			{
				//lets get back to old chmod we assume that was the same for players
				//and account folder :)
			@chmod($path['pla'], $old_chmod_changed); 
				@chmod($path['acc'], $old_chmod_changed);
					@chmod($path['vip'], $old_chmod_changed);
				}
		


?>
