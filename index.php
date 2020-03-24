<?php 
session_start();
if (!isset($_SESSION["login"])) {
	echo "<script>document.location.href = 'login.php';</script>";
	exit();
}


require 'functions.php';
//pagination
//konfigurasi
$jumlahdata = 2;
$total = count (query("SELECT * FROM siswa"));
$jumlahhalaman = ceil($total / $jumlahdata);
$halamanaktif=(isset($_GET["halaman"]))?$_GET["halaman"]:1;

$awaldata = ($jumlahdata * $halamanaktif)-$jumlahdata;


$siswa = query("SELECT * FROM siswa LIMIT $awaldata, $jumlahdata");

//cari diklik
if (isset($_POST["cari"])) {
	$siswa = cari($_POST["key"]);
}
 ?>



<!DOCTYPE html>
<html>
<head>

	<title>Admin</title>
	<link href="img/stm.png" rel="icon" type="image/png" />
</head>
<body>
<a href="logout.php" onclick="return confirm('Apakah anda ingin keluar?')">logout</a>
<h1>Daftar Mahasiswa</h1>
<a href="tambah.php">Tambah data siswa</a>
<br>
<br>
<form action="" method="post">
	<input type="text" name="key" size="40" autofocus placeholder="masukkan" autocomplete="off">
	<button type="submit" name="cari">Cari</button>
</form>
<!--navigasi-->
<br>
<?php if($halamanaktif>1): ?>
<a href="?halaman= <?php echo $halamanaktif-1 ; ?>">&laquo</a>
<?php endif; ?>


<?php for ($i=1; $i <= $jumlahhalaman ; $i++) : ?>
	<?php if ($i==$halamanaktif): ?>
		<a href="?halaman=<?php echo "$i"; ?>" style="font-weight:bold; color:red;"><?php echo "$i"; ?></a> 
<?php else: ?>
	<a href="?halaman=<?php echo "$i"; ?>"><?php echo "$i"; ?></a>
<?php endif ?>
		
<?php endfor ;?>
<?php if($halamanaktif<$jumlahhalaman): ?>
<a href="?halaman= <?php echo $halamanaktif+1 ; ?>">&raquo</a>
<?php endif; ?>
<br>
<table  border="1" cellpadding="10" cellspacing="0">
	<tr>
		<th>No</th>
		<th>Aksi</th>
		<th>Foto</th>
		<th>Nama</th>
		<th>NIS</th>
		<th>Email</th>
		<th>Jurusan</th>
	</tr>
	<?php $i = 1; ?>
<?php foreach($siswa as $row): ?>
	<tr>
		<td><?php echo $i; ?></td>
		<td><a href="ubah.php?id=<?php echo $row["id"]; ?>">ubah</a>|<a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('Apakah anda ingin menghapus data?')">hapus</a></td>
		<td><img src="img/<?php echo $row["gambar"]; ?>" width="50"></td>
		<td><?php echo $row["nama"]; ?></td>
		<td><?php echo $row["nis"]; ?></td>
		<td><?php echo $row["email"]; ?></td>
		<td><?php echo $row["jurusan"]; ?></td>
	</tr>
	<?php $i++ ?>
<?php endforeach ?>
</table>

</body>
</html>