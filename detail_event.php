<?php

include "koneksi/koneksi.php";

if(!isset($_GET['id'])){
    header("Location:index.php");
    exit;
}

$id = $_GET['id'];

$query = mysqli_query($conn,"
SELECT
event.*,
kategori.nama_kategori,
admin.nama
FROM event
JOIN kategori
ON event.id_kategori = kategori.id_kategori
JOIN admin
ON event.id_admin = admin.id_admin
WHERE event.id_event='$id'
");

$data = mysqli_fetch_assoc($query);

if(!$data){
    echo "Data tidak ditemukan";
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= $data['nama_event']; ?></title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    background:#f4f4f4;
}

header{

    background:#0099ff;
    color:white;
    padding:18px 50px;

    display:flex;
    justify-content:space-between;
    align-items:center;

}

header a{

    color:white;
    text-decoration:none;
    font-weight:bold;

}

.container{

    width:90%;
    max-width:1100px;

    margin:40px auto;

}

.card{

    background:white;

    border-radius:10px;

    box-shadow:0 5px 15px rgba(0,0,0,.15);

    overflow:hidden;

}

.poster{

    width:100%;
    height:420px;
    object-fit:cover;

}

.content{

    padding:30px;

}

.content h1{

    color:#3498db;
    margin-bottom:20px;

}

.info{

    margin-bottom:25px;

}

.info p{

    margin:10px 0;

    font-size:17px;

}

.deskripsi{

    line-height:28px;
    text-align:justify;

}

.btn{

    display:inline-block;

    margin-top:30px;

    background:#3498db;

    color:white;

    text-decoration:none;

    padding:12px 25px;

    border-radius:5px;

}

.btn:hover{

    background:#217dbb;

}

.status{

    display:inline-block;

    padding:5px 12px;

    border-radius:20px;

    color:white;

    font-size:14px;

}

.akan_datang{
    background:#f39c12;
}

.berlangsung{
    background:#27ae60;
}

.selesai{
    background:#7f8c8d;
}

</style>

</head>

<body>

<header>

<h2>Smart Event Campus</h2>

<a href="index.php">
← Kembali
</a>

</header>

<div class="container">

<div class="card">

<?php

if($data['poster']!=""){

?>

<img

src="assets/upload/<?= $data['poster']; ?>"

class="poster">

<?php

}else{

?>

<img

src="gambar/no-image.png"

class="poster">

<?php } ?>

<div class="content">

<h1>

<?= $data['nama_event']; ?>

</h1>

<div class="info">

<p>

<b>Kategori :</b>

<?= $data['nama_kategori']; ?>

</p>

<p>

<b>Tanggal Mulai :</b>

<?= date('d F Y H:i',strtotime($data['tanggal_mulai'])); ?>

</p>

<p>

<b>Tanggal Selesai :</b>

<?= date('d F Y H:i',strtotime($data['tanggal_selesai'])); ?>

</p>

<p>

<b>Lokasi :</b>

<?= $data['lokasi']; ?>

</p>

<p>

<b>Status :</b>

<span class="status <?= $data['status']; ?>">

<?= ucfirst(str_replace("_"," ",$data['status'])); ?>

</span>

</p>

<p>

<b>Admin :</b>

<?= $data['nama']; ?>

</p>

</div>

<h3>Deskripsi Event</h3>

<br>

<p class="deskripsi">

<?= nl2br($data['deskripsi']); ?>

</p>

<a href="index.php#event" class="btn">

Kembali ke Daftar Event

</a>

</div>

</div>

</div>

</body>

</html>