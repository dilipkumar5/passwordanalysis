<?php
//session_start();
$conn=mysqli_connect('localhost','root','' );

$db = mysqli_select_db($conn, 'loginsystemtut');

if(isset($_POST['login-submit']))
{
	$user = $_POST['username'];
	$pass = $_POST['password'];
	
	$sql = "select * from mpusers where mpUid='$user' and mpPwd='$pass' ";
	$data = mysqli_query($conn,$sql);
	
	$total = mysqli_num_rows($data);
	if($total!=0)
	{
		echo "Login Successful";
		$_SESSION['username'] = $user;
		header('location: index1.php');
	}
	else
	{
		echo "Login Failed";
		header('location: index.php');
	}
}
else
{
	echo "lol";
}
?>