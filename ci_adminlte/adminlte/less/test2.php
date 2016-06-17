<?php
	session_start();
	require('Connections/db.php');
		$User_in = mysql_real_escape_string($_POST['txtUsername']);
		$Pass_in = mysql_real_escape_string($_POST['txtPassword']);
		$strSQL = "SELECT * FROM pjaccount WHERE Username = '$User_in'";
		$objQuery = mysql_query($strSQL);
		$rows = mysql_num_rows($objQuery);
		if($rows==1){
			$objResult = mysql_fetch_array($objQuery);
			if($objResult['Status']=='Activated'){
				if($objResult['Password']== $Pass_in){
					$_SESSION['User']['1'] = $objResult['Username'];
					$_SESSION['User']['2'] = $objResult['Group'];
					$_SESSION['User']['3'] = $objResult['FirstName'];
					$_SESSION['User']['4'] = $objResult['SurName'];
					$_SESSION['User']['5'] = $objResult['ID'];
					$_SESSION['User']['6'] = $objResult['TelNO'];
					$_SESSION['User']['7'] = $objResult['EMail'];
					session_write_close();
					if($_SESSION['User']['2']=="Admin")
						header("location:Admin_page.php");
					else if($_SESSION["User"]["2"]=="Lecturer")
						header("location:Lecturer_page.php");
					else if($_SESSION["User"]["2"]=="Student")
						header("location:Student_page.php");
					else
						header("location:login.php");
				}
				else
					header("location:login.php");
			}			
			else if($objResult['Status']=='Deactivated'){
				if($objResult['Password']==md5($Pass_in)){
					$_SESSION['User']['1'] = $objResult['Username'];
					session_write_close();
					header("location:Set_page.php");
				}
				else
					header("location:login.php");
			}
			else
				header("location:login.php");
		}
		else{
			if(Connect1User($User_in)){
				header("location: test2.php");
			}
			else
				echo "Username or Password Incorrect";
		}
?>