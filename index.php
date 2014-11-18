<html>  
<head> 
<!-- Oink! oink! -->
<!-- XML Server Validator by Pavlus -->
<script src="js/jquery.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Validator XML</title> 


</head> 
<?

require_once ('config.php');

//preloading language file


if(file_exists('lang/'.$lang.'.php'))
	{
		require_once('lang/'.$lang.'.php');
		}
			else
			{
				echo 'Wrong language type set in config.php, $lang variable!';
				exit();
				}
				
	//checking core status
if(filesize('validation.php') != CORE_SIZE)
	{
		echo '<font color="red"><b>'.$misc['core_changed'].'</font></b><br>';
		}
				?>
<body>  

<script language="javascript">  
 
jQuery(function($) {  
$("#contentArea").load("validation.php");  
});  
  
$().ajaxSend(function(r,s){  
$("#contentLoading").show();  
});  
  
$().ajaxStop(function(r,s){  
$("#contentLoading").fadeOut("slow");  
});  
   
</script> 

<center>

<div id="contentLoading" class="contentLoading"> 
<?php echo $gener; ?><br>
<img src="img/ajax-loader.gif" alt="Loading report, please wait..."><br>
<small><?php echo $eta; ?></small>
</div>  
</center>
<div id="contentArea">  
</div>  
</body>  
</html>  