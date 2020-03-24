<?php 

session_start();
if (!isset($_SESSION["login"])) {
	echo "<script>document.location.href = 'login.php';</script>";
	exit();
}

require "functions.php";


if(isset($_POST["submit"]) ){


	//cek keberhasilan
	if (tambah($_POST) > 0) {
		echo "<script>
		alert('data berhasil dikirim');
		document.location.href = 'index.php';
		</script>";
	}
	else{
		echo "gagal";
	}
}
 ?>





<!DOCTYPE html>
<html>
<head>
	<title>Tambah data</title>
</head>
<body>
<h1>Tambah Data Siswa</h1>

<form action="" method="post" enctype="multipart/form-data">
	<ul>
		<li>
			<label for="nama">Nama : </label>
			<input type="text" name="nama" id="nama" required>
		</li>
		<li>
			<label for="nis">Nis : </label>
			<input type="text" name="nis" id="nis">
		</li>
		<li>
			<label for="email">email : </label>
			<input type="text" name="email" id="email">
		</li>
		<li>
			<label for="jurusan">jurusan : </label>
			<input type="text" name="jurusan" id="jurusan">
		</li>
		<li>
			<label for="gambar">gambar : </label>
			<input type="file" name="gambar" id="gambar">
		</li>
		<li>
			<button type="submit" name="submit">Tambah</button>
		</li>
	</ul>
</form>
<a href="index.php">balik</a>

</body>
</html>