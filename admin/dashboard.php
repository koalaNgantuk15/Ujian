<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location:../login.php");
    exit;
}

include "../koneksi/koneksi.php";
/** @var mysqli $conn */

$totalEvent = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM event"));

$eventTerbaru = mysqli_query($conn,"
SELECT *
FROM event
ORDER BY tanggal_mulai DESC
LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>
<style>
    body{
        margin: 0px;
        padding: 0px;
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
    background:rgba(30, 30, 30, 0.79);
}

.content{
    flex:1;
    padding:30px;
}

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.admin{
    font-weight:bold;
}

.card{
    width:220px;
    background:white;
    padding:20px;
    border-radius:8px;
    box-shadow:0 2px 8px rgba(0,0,0,.15);
    margin-bottom:30px;
}

.card h3{
    color:#555;
}

.card h1{
    margin-top:10px;
    color:#3498db;
}

.welcome{
    background:white;
    padding:20px;
    border-radius:8px;
    margin-bottom:30px;
    box-shadow:0 2px 8px rgba(0,0,0,.15);
}

.table-box{
    background:white;
    padding:20px;
    border-radius:8px;
    box-shadow:0 2px 8px rgba(0,0,0,.15);
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

table th{
    background:#3498db;
    color:white;
    padding:12px;
}

table td{
    padding:10px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

table tr:hover{
    background:#f5f5f5;
}
</style>
</head>
<body>

<div class="container">

    <div class="sidebar">

        <h2>SMART EVENT</h2>

        <a href="dashboard.php" class="active">
            Dashboard
        </a>

        <a href="event.php">
            Data Event
        </a>

        <a href="portal.php">
            Portal Event
        </a>

        <a href="../logout.php">
            Logout
        </a>

    </div>

    <div class="content">

        <div class="topbar">

            <h2>Dashboard</h2>

            <div class="admin">
                <?= $_SESSION['nama']; ?>
            </div>

        </div>

        <div class="card">

            <h3>Total Event</h3>

            <h1><?= $totalEvent ?></h1>

        </div>

        <div class="welcome">

            <h3>Selamat Datang, <?= $_SESSION['nama']; ?></h3>

            <p>
                Selamat datang di halaman administrator Smart Event Campus.
                Gunakan menu <b>Data Event</b> untuk mengelola seluruh kegiatan kampus.
            </p>

        </div>

        <div class="table-box">

            <h3>Event Terbaru</h3>

            <table>

                <tr>
                    <th>No</th>
                    <th>Nama Event</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>

                <?php
                $no=1;
                while($e=mysqli_fetch_assoc($eventTerbaru)){
                ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td><?= $e['nama_event']; ?></td>

                    <td>
                        <?= date('d-m-Y',strtotime($e['tanggal_mulai'])); ?>
                    </td>

                    <td><?= ucfirst($e['status']); ?></td>

                </tr>

                <?php } ?>

            </table>

        </div>

    </div>

</div>

</body>
</html>