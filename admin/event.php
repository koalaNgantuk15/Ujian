<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location:../login.php");
    exit;
}

include "../koneksi/koneksi.php";
/** @var mysqli $conn */

$query = mysqli_query($conn,"
SELECT
event.*,
kategori.nama_kategori
FROM event
JOIN kategori
ON event.id_kategori = kategori.id_kategori
ORDER BY event.tanggal_mulai DESC
");
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Data Event</title>
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
    background-color: rgb(0, 0, 0);
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
    background:rgb(30, 30, 30, 0.79);
}

.content{
    flex:1;
    padding:30px;
}

    .topbar{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:20px;

}

.btn{

background:#3498db;

color:white;

padding:10px 15px;

text-decoration:none;

border-radius:5px;

}

.btn:hover{

background:#2980b9;

}

table{

width:100%;

border-collapse:collapse;

background:white;

box-shadow:0 0 10px rgba(0,0,0,.1);

}

table th{

background:#2c3e50;

color:white;

padding:12px;

}

table td{

padding:10px;

border-bottom:1px solid #ddd;

text-align:center;

}

table tr:hover{

background:#f9f9f9;

}

.edit{

background:#27ae60;

color:white;

padding:6px 10px;

border-radius:4px;

text-decoration:none;

margin-right:5px;

}

.hapus{

background:#e74c3c;

color:white;

padding:6px 10px;

border-radius:4px;

text-decoration:none;

}

</style>
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

<div class="topbar">

<h2>Data Event</h2>

<a href="tambah_data.php" class="btn">
+ Tambah Event
</a>

</div>

<table>

<tr>

<th>No</th>

<th>Nama Event</th>

<th>Kategori</th>

<th>Tanggal</th>

<th>Lokasi</th>

<th>Status</th>

<th>Aksi</th>

</tr>

<?php

$no=1;

while($row=mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['nama_event']; ?></td>

<td><?= $row['nama_kategori']; ?></td>

<td>

<?= date('d-m-Y',strtotime($row['tanggal_mulai'])) ?>

</td>

<td><?= $row['lokasi']; ?></td>

<td><?= ucfirst($row['status']); ?></td>

<td>

<a class="edit"

href="edit_data.php?id=<?= $row['id_event']; ?>">

Edit

</a>

<a class="hapus"

onclick="return confirm('Yakin ingin menghapus?')"

href="hapus.php?id=<?= $row['id_event']; ?>">

Hapus

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>