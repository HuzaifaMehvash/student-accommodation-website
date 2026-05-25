<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password"; // Default XAMPP password is empty
$dbname = "ypur_database";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();
?>