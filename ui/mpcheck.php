<?php
if(isset($_POST['signup-submit']))
{
	require  'mpdbh.php';
	
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	if(empty($username) || empty($email) || empty($password))
	{
		header("Location: mpform.php?error=emptyfields&username=".$username."&email=".$email);
		exit();
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/",$username))
	{
		header("Location: mpform.php?error=invalidmailuid");
		exit();
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		header("Location: mpform.php?error=invalidmail&username=".$username);
		exit();
	}
	else if(!preg_match("/^[a-zA-Z0-9]*$/",$username))
	{
		header("Location: mpform.php?error=invalidusername&email=".$email);
		exit();
	}
	else
	{
		$sql = "SELECT mpUid FROM mpusers WHERE mpUid=?";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql))
		{
			header("Location: signup.php?error=sqlerror");
			exit();
		}
		else
		{
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$resultCheck = mysqli_stmt_num_rows($stmt);
			if($resultCheck==1)
			{
				header("Location: mpform.php?error=usertaken&email=".$email);
				exit();
			}
			else
			{
				$sql = "INSERT INTO mpusers (mpUid, mpEmail, mpPwd) values (?,?,?)";
				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql))
				{
					header("Location: mpform.php?error=sqlerror");
					exit();
				}
				else
				{
					$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
					mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
					mysqli_stmt_execute($stmt);
					header("Location: mplogin.php?signup=success");
					exit();
				}
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else
{
	header("Location: mpform.php");
	exit();
}
?>