<?php
$host = 'localhost';
$user = 'root';
$password = ''; // Leave empty if no password is set in XAMPP
$dbname = 'online_exam';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

