<?php
session_start();
include('DBconnect.php');

// Accept username and password securely
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare SQL query using parameterized statements
$stmt = $con->prepare("SELECT * FROM admin WHERE username=? AND password=?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

$flag = false;

while ($record = $result->fetch_assoc()) {
    // Access data from the admin table
    $admin_id = $record['admin_id'];
    $username = $record['username'];
    $_SESSION['adminname'] = $username; // Store admin username in session

    $email = $record['email'];
    $flag = true;
}

if ($flag == false) {
    // Redirect to login page with failure message
    header('location:Login.php?fail');
} else {
    // Redirect to view page upon successful login
    header('location:Admin_Home.php');
}
?>
