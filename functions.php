<?php 
//koneksi database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");


function query($query){
	global $conn;
	$result=mysqli_query($conn, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[]=$row; 
	}
	return $rows;
}




function tambah($data){
	global $conn;
	$nama = htmlspecialchars($data["nama"]);
	$nis = htmlspecialchars($data["nis"]);
	$email = htmlspecialchars($data["email"]);
	$jurusan = htmlspecialchars($data["jurusan"]);


	// uploud gambar

$gambar=uploud();
if (!$gambar) {
	return false;
}
	
	$query = "INSERT INTO siswa VALUES (NULL, '$nama', '$nis', '$email', '$jurusan', '$gambar');";
	mysqli_query($conn, $query);
return mysqli_affected_rows($conn);
}

function uploud(){
	$namafile = $_FILES['gambar']['name'];
	$ukuranfile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpname = $_FILES['gambar']['tmp_name'];

	//cek
	if ($error===4) {
	echo "<script>alert('Silahkan masukkan gambar!');</script>";
	return false;
	}
	// cek type
	$ekstensivalid= ['jpg', 'jpeg', 'png'];
	$ekstensigambar = explode('.', $namafile);
	$ekstensigambar= strtolower (end($ekstensigambar));
	if (!in_array($ekstensigambar, $ekstensivalid)) {
		echo "<script>alert('Yang anda uploud bukan gambar');</script>";
		return false;
	}

	//cek ukuran
	if ($ukuranfile>10000000) {
		echo "<script>alert('Ukuran terlalu besar');</script>";
		return false;
	}

	//lolos pengecekan
	//nama baru

	$namabaru = uniqid();
	$namabaru .= ".";
	$namabaru .=$ekstensigambar;


	move_uploaded_file($tmpname, 'img/'.$namabaru);
	return $namabaru;
}


function hapus($id){
	global $conn;
	mysqli_query($conn, "DELETE FROM siswa WHERE id = $id" );
return mysqli_affected_rows($conn);

}


function ubah($data){
	global $conn;

	$id = $data["id"];
	$nama = htmlspecialchars($data["nama"]);
	$nis = htmlspecialchars($data["nis"]);
	$email = htmlspecialchars($data["email"]);
	$jurusan = htmlspecialchars($data["jurusan"]);

	$gambarlama = $data["gambarlama"];
if ($_FILES['gambar']['error']===4) {
	$gambar=$gambarlama;
}else{
	$gambar = uploud();
}
	

	
	$query = "UPDATE siswa SET nama = '$nama', nis='$nis', email='$email', jurusan='$jurusan', gambar='$gambar' WHERE id = $id;";
	mysqli_query($conn, $query);
return mysqli_affected_rows($conn);

}

function cari($key){
	$query = "SELECT * FROM siswa WHERE
				nama LIKE '%$key%' OR
				nis LIKE '%$key%'OR
				email LIKE '%$key%'OR
				jurusan LIKE '%$key%'
				";
	return query($query);

}

function registrasi($data){
	global $conn;

	$username = strtolower (stripslashes($data['username']));
	$password = mysqli_real_escape_string($conn, $data['password']);
	$password2 = mysqli_real_escape_string($conn, $data['password2']);

	//cek username
	$result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
	if (mysqli_fetch_assoc($result)) {
		echo "<script>alert('Username sudah ada');</script>";
		return false;
	}

	if ($password !== $password2) {
		echo "<script>alert ('Password salah')</script>";
		return false;
	}
	
//enkrip password
$password = password_hash($password, PASSWORD_DEFAULT);

mysqli_query($conn, "INSERT INTO users VALUES(NULL, '$username', '$password')");
return mysqli_affected_rows($conn);
}




 ?>
