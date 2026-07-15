<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location:../login.php");
    exit;
}

include "../koneksi/koneksi.php";
/** @var mysqli $conn */


// Ambil data kategori
$kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori ASC");

if (isset($_POST['simpan'])) {

    $nama = $_POST['nama_event'];
    $kategori_id = $_POST['id_kategori'];
    $deskripsi = $_POST['deskripsi'];
    $tgl_mulai = $_POST['tanggal_mulai'];
    $tgl_selesai = $_POST['tanggal_selesai'];
    $lokasi = $_POST['lokasi'];
    $status = $_POST['status'];

    $poster = "";

    if ($_FILES['poster']['name'] != "") {

        $poster = time() . "_" . $_FILES['poster']['name'];

        move_uploaded_file(
            $_FILES['poster']['tmp_name'],
            "../asset/upload/" . $poster
        );
    }

    mysqli_query($conn, "INSERT INTO event(

        nama_event,
        id_kategori,
        deskripsi,
        tanggal_mulai,
        tanggal_selesai,
        lokasi,
        status,
        poster,
        id_admin

    ) VALUES(

        '$nama',
        '$kategori_id',
        '$deskripsi',
        '$tgl_mulai',
        '$tgl_selesai',
        '$lokasi',
        '$status',
        '$poster',
        '".$_SESSION['id_admin']."'

    )");

    echo "<script>
    alert('Event berhasil ditambahkan');
    window.location='event.php';
    </script>";

}
?>

<!DOCTYPE html>
<html>
<head>

    <style>

    body{
    padding: 0px;
    margin: 0px;
}
 .container{
    display:flex;
    min-height:100vh;
    background:#f4f6f9;
}

.sidebar{
    width:230px;
    background-color: rgba(0, 91, 210, 0.67);
    padding:20px;
}

.sidebar h2{
    color:white;
    text-align:center;
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:12px;
    margin-bottom:10px;
    border-radius:5px;
}

.sidebar a:hover,
.sidebar .active{
    background:rgba(0, 46, 105, 0.67);
}

.content{
    flex:1;
    padding:30px;
}

        form{

background:white;

padding:25px;

border-radius:8px;

box-shadow:0 0 10px rgba(0,0,0,.1);

}

label{

display:block;

margin-top:15px;

font-weight:bold;

}

input,
select,
textarea{

width:100%;

padding:10px;

margin-top:5px;

border:1px solid #ccc;

border-radius:5px;

}

.btn{

background:#3498db;

color:white;

padding:10px 18px;

border:none;

border-radius:5px;

cursor:pointer;

text-decoration:none;

}

.btn:hover{

background:#2980b9;

}

.btn-batal{

background:#7f8c8d;

color:white;

padding:10px 18px;

border-radius:5px;

text-decoration:none;

margin-left:10px;

}
    </style>

<meta charset="UTF-8">
<title>Tambah Event</title>

<link rel="stylesheet" href="../style.css">

</head>

<body>

<div class="container">

<div class="sidebar">

<h2>SMART EVENT</h2>

<a href="dashboard.php">Dashboard</a>

<a href="event.php" class="active">Data Event</a>

<a href="portal.php">
            Portal Event
        </a>

<a href="../logout.php">Logout</a>

</div>

<div class="content">

<h2>Tambah Event</h2>

<form method="POST" enctype="multipart/form-data">

<label>Nama Event</label>

<input type="text"
name="nama_event"
required>

<label>Kategori</label>

<select name="id_kategori" required>

<option value="">-- Pilih Kategori --</option>

<?php while($k=mysqli_fetch_assoc($kategori)){ ?>

<option value="<?= $k['id_kategori']; ?>">

<?= $k['nama_kategori']; ?>

</option>

<?php } ?>

</select>

<label>Deskripsi</label>

<textarea
name="deskripsi"
rows="5"></textarea>

<label>Tanggal Mulai</label>

<input
type="datetime-local"
name="tanggal_mulai"
required>

<label>Tanggal Selesai</label>

<input
type="datetime-local"
name="tanggal_selesai">

<label>Lokasi</label>

<input
type="text"
name="lokasi"
required>

<label>Status</label>

<select name="status">

<option value="akan_datang">Akan Datang</option>

<option value="berlangsung">Berlangsung</option>

<option value="selesai">Selesai</option>

</select>

<label>Poster</label>

<input
type="file"
name="poster">

<br><br>

<button class="btn" name="simpan">

Simpan Event

</button>

<a href="event.php" class="btn-batal">

Kembali

</a>

</form>

</div>

</div>

</body>
</html>