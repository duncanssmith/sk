<?php	

// login box
	if(empty($_SESSION['loggedIn'])||(!$_SESSION['loggedIn'])){
		#include "login.php";	
		#login();
	}else{

		$_SESSION['firstname']="Duncan";
		$_SESSION['lastname']="Smith";

		echo "<p class=\"login\">".$_SESSION['firstname']." ".$_SESSION['lastname']." logged in</p>\n";
		echo "<p><a href=\"index.php?logout=true\">log out</a></p>";
	}
	if(isset($_GET)){
		if(isset($_GET['logout'])&&($_GET['logout'])){
			logout();
		}
		else if(isset($_GET['changepass'])&&($_GET['changepass'])){
			changepass();
		}	
	}
	
	if(isset($_POST['pass'])){
		if((md5($_POST['pass'])==$settings['pass'])){
			$_SESSION['loggedIn']=true;
			echo "<p>logged in</p>\n";
		}else{
			$_SESSION['loggedIn']=false;
			echo "<p>password incorrect</p>\n";
			#echo (md5($_POST['pass']));
		}
	}

?>
