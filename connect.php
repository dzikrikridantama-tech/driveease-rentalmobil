<?php
$localhost = "localhost";
$username  = "root";
$password  = "";
$dbname    = "rental_mobil";

$con = new mysqli($localhost, $username, $password, $dbname);

if ($con->connect_error) {
    // Diubah dari $conn menjadi $con agar tidak error
    die("Koneksi gagal: " . $con->connect_error); 
}
?>