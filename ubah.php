<?php 
session_start();
if (!isset($_SESSION["login"])) {
	echo "<script>document.location.href = 'login.php';</script>";
	exit();
}

require "functions.php";

//ambil data url
$id=$_GET["id"];

//query ber id
$siswa = query("SELECT * FROM siswa WHERE id = $id")[0];



if(isset($_POST["submit"]) ){


	//cek keberhasilan ubah
	if (ubah($_POST) > 0) {
		echo "<script>
		alert('data berhasil diubah');
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
	<title>Update data</title>
</head>
<body>
<h1>Update Data Siswa</h1>

<form action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php echo $siswa["id"];  ?>">
	<input type="hidden" name="gambarlama" value="<?php echo $siswa["gambar"];  ?>">
	<ul>
		<li>
			<label for="nama">Nama : </label>
			<input type="text" name="nama" id="nama" required value="<?php echo $siswa["nama"];  ?>">
		</li>
		<li>
			<label for="nis">Nis : </label>
			<input type="text" name="nis" id="nis" value="<?php echo $siswa["nis"];  ?>">
		</li>
		<li>
			<label for="email">email : </label>
			<input type="text" name="email" id="email" value="<?php echo $siswa["email"];  ?>">
		</li>
		<li>
			<label for="jurusan">jurusan : </label>
			<input type="text" name="jurusan" id="jurusan" value="<?php echo $siswa["jurusan"];  ?>">
		</li>
		<li>
			<label for="gambar">gambar : </label>
			<img width="50" src="img/<?php echo $siswa['gambar']; ?>"><br>
			<input type="file" name="gambar" id="gambar" >
		</li>
		<li>
			<button type="submit" name="submit">Submit</button>
		</li>
	</ul>
</form>
<a href="index.php">balik</a>

</body>
</html>