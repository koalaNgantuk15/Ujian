<?php
include "koneksi/koneksi.php";

$query = mysqli_query($conn,"
SELECT
    event.*,
    kategori.nama_kategori
FROM event
JOIN kategori
ON event.id_kategori = kategori.id_kategori
ORDER BY event.tanggal_mulai ASC
");


$totalEvent = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS total FROM event")
);

$totalKategori = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS total FROM kategori")
);

$akanDatang = mysqli_fetch_assoc(
    mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM event
    WHERE status='akan_datang'
    ")
);

$berlangsung = mysqli_fetch_assoc(
    mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM event
    WHERE status='berlangsung'
    ")
);

$selesai = mysqli_fetch_assoc(
    mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM event
    WHERE status='selesai'
    ")
);

if( isset($_POST["submit"])) {
    $cari = $_POST["cari"];
    $query = mysqli_query($conn,"SELECT
    event.*,
    kategori.nama_kategori
FROM event
JOIN kategori
ON event.id_kategori = kategori.id_kategori
where nama_event LIKE '%$cari%'
");

}

if( isset($_POST["semua"])) {
    $query = mysqli_query($conn,"SELECT
    event.*,
    kategori.nama_kategori
FROM event
JOIN kategori
ON event.id_kategori = kategori.id_kategori
");

}
if( isset($_POST["lomba"])) {
    $query = mysqli_query($conn,"SELECT
    event.*,
    kategori.nama_kategori
FROM event
JOIN kategori
ON event.id_kategori = kategori.id_kategori
where nama_kategori = 'Lomba'
");

}
if( isset($_POST["pelatihan"])) {
    $query = mysqli_query($conn,"SELECT
    event.*,
    kategori.nama_kategori
FROM event
JOIN kategori
ON event.id_kategori = kategori.id_kategori
where nama_kategori = 'Pelatihan'
");

}
if( isset($_POST["seminar"])) {
    $query = mysqli_query($conn,"SELECT
    event.*,
    kategori.nama_kategori
FROM event
JOIN kategori
ON event.id_kategori = kategori.id_kategori
where nama_kategori = 'Seminar'
");

}
if( isset($_POST["workshop"])) {
    $cari = $_POST["cari"];
    $query = mysqli_query($conn,"SELECT
    event.*,
    kategori.nama_kategori
FROM event
JOIN kategori
ON event.id_kategori = kategori.id_kategori
where nama_kategori = 'Workshop'
");

}

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Event Campus</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

html{
    scroll-behavior:smooth;
}

body{
    background:#111;
    color:white;
}

header{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    background: black;
    padding:20px 60px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    z-index:100;
}

.logo{
    font-size:28px;
    font-weight:bold;
}

.login{
    color:white;
    text-decoration:none;
    font-size:18px;
}

.hero{
    height:100vh;
    background:
    linear-gradient(rgba(0,0,0,.6),rgba(0,0,0,.6)),
    url("gambar/event.png");

    background-size:cover;
    background-position:center;

    display:flex;
    justify-content:center;
    align-items:center;
    text-align:center;
}

.overlay{
    max-width:850px;
}

.overlay h1{
    font-size:70px;
    margin-bottom:20px;
}

.overlay p{
    font-size:22px;
    margin-bottom:35px;
}

.shine-button {
  position: relative;
  padding: 10px;
  font-size: 1.1rem;
  font-weight: 0;
  border: none;
  border-radius: 12px;
  cursor: pointer;
  overflow: hidden;
  transition: all 0.3s ease;
  letter-spacing: 0.5px;
  min-width: 200px;
}

.shine-button::before {
  content: '';
  position: absolute;
  height: 200px;
  width: 40px;
  top: 0;
  left: -60px;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
  transform: rotate(45deg) translateY(-35%);
  animation: shine 3s ease infinite;
}

@keyframes shine {
  0% {
    left: -80px;
  }
  40% {
    left: calc(100% + 20px);
  }
  100% {
    left: calc(100% + 20px);
  }
}


.button-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
}
.button-chrome {
  background: linear-gradient(135deg, #bdc3c7 0%, #000000 100%);
  color: #fff;
  box-shadow: 
    0 10px 30px rgba(45, 62, 80, 0.4),
    inset 0 1px 0 rgba(255, 255, 255, 0.2),
    inset 0 -1px 0 rgba(0, 0, 0, 0.1);
}

.button-chrome:hover {
  background: linear-gradient(135deg, #d5dbdb 0%, #252626 100%);
  transform: translateY(-3px);
  box-shadow: 
    0 15px 40px rgba(45, 62, 80, 0.6),
    inset 0 1px 0 rgba(255, 255, 255, 0.3),
    inset 0 -1px 0 rgba(0, 0, 0, 0.1);
}

.stat{
    display:flex;
    justify-content:center;
    gap:80px;
    margin-top:60px;
}

.stat h2{
    font-size:38px;
}

.event{
    background:black;
    color:white;
    padding:70px;
    
}

.event h1{
    text-align:center;
    margin-bottom:40px;
    color:white;
}

.cari{
    padding-bottom : 30px;
    color: white;
}
.input-cari{
    height: 50px;
    background: none;
    border: 5px;
    border-color: white;
    border-radius: 50px;
}
.cari-btn{
     display:inline-block;
    margin-top:15px;
    background:gray;
    color:whitesmoke;
    padding:10px 20px;
    border-radius:5px;
    text-decoration:none;
}

.cari-btn:hover{
    background-color: rgba(24, 24, 24, 0.6);
    color:white;
}

.cari-btn:active{
     background:#3498db;
    color:white;
}

.card-container{

    display:grid;

    grid-template-columns:repeat(auto-fit,minmax(320px,1fr));

    gap:25px;

}

.card{

    background:gray;

    border-radius:10px;

    overflow:hidden;

    box-shadow:0 5px 15px rgba(0,0,0,.15);

    transition:.3s;

}

.card:hover{

    transform:translateY(-8px);

}

.card img{

    width:100%;

    height:220px;

    object-fit:cover;

}

.isi{

    padding:20px;

}

.isi h2{

    color:white;

    margin-bottom:10px;

}

.isi p{

    margin:8px 0;

    line-height:24px;

}

.detail{

    display:inline-block;

    margin-top:15px;
background: linear-gradient(135deg, #bdc3c7 0%, #000000 100%);
  color: #fff;
  box-shadow: 
    0 10px 30px rgba(45, 62, 80, 0.4),
    inset 0 1px 0 rgba(255, 255, 255, 0.2),
    inset 0 -1px 0 rgba(0, 0, 0, 0.1);
    text-decoration:none;

}

.detail:hover{
background: linear-gradient(135deg, #d5dbdb 0%, #252626 100%);
  transform: translateY(-3px);
  box-shadow: 
    0 15px 40px rgba(45, 62, 80, 0.6),
    inset 0 1px 0 rgba(255, 255, 255, 0.3),
    inset 0 -1px 0 rgba(0, 0, 0, 0.1);
}

footer{

    background:#222;

    color:white;

    text-align:center;

    padding:20px;

}

</style>

</head>

<body>

<header>

<div class="logo">
Event Campus
</div>

<a href="login.php" class="login">
Login
</a>

</header>

<section class="hero">

<div class="overlay">

<h1>
Saksikan<br>
Event Campus
</h1>

<p>
Temukan berbagai seminar, workshop, lomba dan pelatihan mahasiswa.
</p>

 <div class="button-wrapper">
      <a href="#event"><button class="shine-button button-chrome" >Jelajahi Event</button></a>
    </div>


<div class="stat">

<div>
<h2><?= $totalEvent['total']; ?></h2>
<span>Event</span>
</div>

<div>
<h2><?= $totalKategori['total']; ?></h2>
<span>Kategori</span>
</div>

<div>
<h2><?= $akanDatang['total']; ?></h2>
<span>Akan Datang</span>
</div>

<div>
<h2><?= $berlangsung['total']; ?></h2>
<span>Berlangsung</span>
</div>

<div>
<h2><?= $selesai['total']; ?></h2>
<span>Selesai</span>
</div>

</div>

</div>

</section>

<section class="event" id="event">
    

<h1>Daftar Event Kampus</h1>

<div class="cari">
        <form action="" method="post">
            <label>Cari</label>
            <input type="text" name="cari" size="100" class="input-cari" placeholder="Cari Event" autocomplete="off">
            <input type="submit" name="submit"  class="shine-button button-chrome" value="submit" />
        <br>
        <h3 style="color: white;">Cari berdasarkan kategori</h3><br>
            <button type="submit" name="semua" class="shine-button button-chrome">Semua</button>
            <button type="submit" name="lomba" class="shine-button button-chrome">Lomba</button>
            <button type="submit" name="pelatihan" class="shine-button button-chrome">Pelatihan</button>
            <button type="submit" name="workshop" class="shine-button button-chrome">Workshop</button>
            <button type="submit" name="seminar" class="shine-button button-chrome">Seminar</button>
        </form>

    </div>
<br>
<div class="card-container">

<?php while($row=mysqli_fetch_assoc($query)){ ?>

<div class="card">

<?php

if($row['poster']!=""){

?>

<img src="assets/upload/<?= $row['poster']; ?>">

<?php } else { ?>

<img src="gambar/no-image.png">

<?php } ?>

<div class="isi">

<h2><?= $row['nama_event']; ?></h2>

<p>
<b>Kategori :</b>
<?= $row['nama_kategori']; ?>
</p>

<p>
<b>Tanggal :</b>
<?= date('d F Y',strtotime($row['tanggal_mulai'])); ?>
</p>

<p>
<b>Lokasi :</b>
<?= $row['lokasi']; ?>
</p>

<p>

<?= substr($row['deskripsi'],0,100); ?>...

</p>

<a align="center" href="detail_event.php?id=<?= $row['id_event']; ?>" class="shine-button detail">

Lihat Detail

</a>

</div>

</div>

<?php } ?>

</div>

</section>

<footer>

&copy; 2026 Smart Event Campus

</footer>

</body>
</html>