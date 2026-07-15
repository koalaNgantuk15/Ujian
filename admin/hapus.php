<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location:../login.php");
    exit;
}

include "../koneksi/koneksi.php";
/** @var mysqli $conn */

$id = $_GET['id'];

$data = mysqli_query($conn,"
SELECT poster
FROM event
WHERE id_event='$id'
");

$row = mysqli_fetch_assoc($data);

if($row['poster']!=""){

    @unlink("../assets/upload/".$row['poster']);

}

mysqli_query($conn,"
DELETE FROM event
WHERE id_event='$id'
");

echo "<script>

alert('Event berhasil dihapus');

window.location='event.php';

</script>";

?>