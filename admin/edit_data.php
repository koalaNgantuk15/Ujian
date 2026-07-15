<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location:../login.php");
    exit;
}

include "../koneksi/koneksi.php";
/** @var mysqli $conn */

$id = $_GET['id'];

$event = mysqli_query($conn,"
SELECT * FROM event
WHERE id_event='$id'
");

$data = mysqli_fetch_assoc($event);

$kategori = mysqli_query($conn,"SELECT * FROM kategori");

if(isset($_POST['update'])){

    $nama = $_POST['nama_event'];
    $id_kategori = $_POST['id_kategori'];
    $deskripsi = $_POST['deskripsi'];
    $tgl_mulai = $_POST['tanggal_mulai'];
    $tgl_selesai = $_POST['tanggal_selesai'];
    $lokasi = $_POST['lokasi'];
    $status = $_POST['status'];

    $poster = $data['poster'];

    if($_FILES['poster']['name']!=""){

        if($poster!=""){
            @unlink("../assets/upload/".$poster);
        }

        $poster=time()."_".$_FILES['poster']['name'];

        move_uploaded_file(
            $_FILES['poster']['tmp_name'],
            "../assets/upload/".$poster
        );

    }

    mysqli_query($conn,"
    UPDATE event SET

    nama_event='$nama',
    id_kategori='$id_kategori',
    deskripsi='$deskripsi',
    tanggal_mulai='$tgl_mulai',
    tanggal_selesai='$tgl_selesai',
    lokasi='$lokasi',
    status='$status',
    poster='$poster'

    WHERE id_event='$id'
    ");

    echo "<script>
    alert('Data berhasil diupdate');
    window.location='event.php';
    </script>";

}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Edit Event</title>

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
    background:#fff;
    padding:25px;
    border-radius:8px;
    box-shadow:0 2px 8px rgba(0,0,0,.1);
}

label{
    display:block;
    margin-top:15px;
    margin-bottom:5px;
    font-weight:bold;
}

input,
select,
textarea{
    width:100%;
    padding:10px;
    border:1px solid #ccc;
    border-radius:5px;
    font-size:15px;
}

.btn{
    background:#3498db;
    color:white;
    border:none;
    padding:10px 18px;
    border-radius:5px;
    cursor:pointer;
}

.btn:hover{
    background:#2980b9;
}

.btn-batal{
    background:#6c757d;
    color:white;
    padding:10px 18px;
    border-radius:5px;
    text-decoration:none;
    margin-left:10px;
}
</style>
</head>

<body>

<div class="container">

<div class="sidebar">

<h2>SMART EVENT</h2>

<a href="dashboard.php">Dashboard</a>

<a href="event.php" class="active">Data Event</a>

<a href="../logout.php">Logout</a>

</div>

<div class="content">

<h2>Edit Event</h2>

<form method="POST" enctype="multipart/form-data">

<label>Nama Event</label>

<input
type="text"
name="nama_event"
value="<?= $data['nama_event']; ?>"
required>

<label>Kategori</label>

<select name="id_kategori">

<?php
while($k=mysqli_fetch_assoc($kategori)){
?>

<option
value="<?= $k['id_kategori']; ?>"

<?= ($k['id_kategori']==$data['id_kategori']) ? "selected":""; ?>

>

<?= $k['nama_kategori']; ?>

</option>

<?php } ?>

</select>

<label>Deskripsi</label>

<textarea
name="deskripsi"
rows="5"><?= $data['deskripsi']; ?></textarea>

<label>Tanggal Mulai</label>

<input
type="datetime-local"
name="tanggal_mulai"
value="<?= date('Y-m-d\TH:i',strtotime($data['tanggal_mulai'])) ?>">

<label>Tanggal Selesai</label>

<input
type="datetime-local"
name="tanggal_selesai"
value="<?= date('Y-m-d\TH:i',strtotime($data['tanggal_selesai'])) ?>">

<label>Lokasi</label>

<input
type="text"
name="lokasi"
value="<?= $data['lokasi']; ?>">

<label>Status</label>

<select name="status">

<option value="akan_datang" <?= $data['status']=="akan_datang"?"selected":""; ?>>Akan Datang</option>

<option value="berlangsung" <?= $data['status']=="berlangsung"?"selected":""; ?>>Berlangsung</option>

<option value="selesai" <?= $data['status']=="selesai"?"selected":""; ?>>Selesai</option>

</select>

<label>Poster</label>

<?php
if($data['poster']!=""){
?>

<img
src="../assets/upload/<?= $data['poster']; ?>"
width="150">

<br><br>

<?php } ?>

<input
type="file"
name="poster">

<br><br>

<button class="btn" name="update">

Update Event

</button>

<a href="event.php" class="btn-batal">

Kembali

</a>

</form>

</div>

</div>

</body>

</html>