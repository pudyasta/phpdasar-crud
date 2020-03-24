<?php
 require 'functions.php';
session_start();

//cek cookie 
if (isset($_COOKIE['id'])&& isset($_COOKIE['key'])) {
	$id=$_COOKIE['id'];
	$key =$_COOKIE['key'];
	$result = mysqli_query($conn, "SELECT username FROM users WHERE id = $id");
	$row = mysqli_fetch_assoc($result);
	//cek match
	if ($key===hash('sha256', $row['username'])) {
		$_SESSION['login']=true;
	}
}


if (isset($_SESSION["login"])) {
	echo "<script>document.location.href = 'index.php';</script>";
	exit();
}



if (isset($_POST["login"])) {
	$username=$_POST["username"];
	$password=$_POST["password"];

	$result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
	if (mysqli_num_rows($result) === 1) {
		$row = mysqli_fetch_assoc($result);
		if(password_verify($password, $row["password"])){
			//set session
			$_SESSION["login"]=true;

			//cek remember me
			if (isset($_POST['remember'])) {

				setcookie('id', $row['id'], time()+60);
				setcookie('key', hash('sha256', $row['username']), time()+60);
			}

			// header("Location : login.php");
			echo "<script>document.location.href = 'index.php';</script>";
			exit;
		}
	}

	$error=true;
}


 ?>


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>

<h1>Halaman Login</h1>

<?php if (isset($error)):?>
<p>username/password salah</p>
<?php endif ?>
<form action="" method="post">
	<ul>
		<li>
			<label for="username">Username</label>
			<input type="text" name="username" id="username">
		</li>
		<li>
			<label for="password">password</label>
			<input type="password" name="password" id="password">
		</li>
		<li>
	
			<input type="checkbox" name="remember" id="remember">
			<label for="remember">Remember me</label>
		</li>
		<li>
			<button type="submit" name="login">Login</button>
		</li>

	</ul>

</form>

</body>
</html>