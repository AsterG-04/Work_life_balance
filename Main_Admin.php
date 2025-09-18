<?php
session_start();
include('DBconnect.php');

// Accept username and password securely
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare SQL query using parameterized statements
$stmt = $con->prepare("SELECT * FROM main_admin WHERE username=? AND password=?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

$flag = false;

while ($record = $result->fetch_assoc()) {
    // Access data from the admin table
    $admin_id = $record['main_admin_id'];
    $username = $record['username'];
    $_SESSION['main_adminname'] = $username; // Store admin username in session

    $email = $record['email'];
    $flag = true;
}

if ($flag == false) {
    // Redirect to login page with failure message
    header('location:Main_Admin_Login.php?fail');
} else {
    // Redirect to view page upon successful login
    header('location:AdminInfo.php');
} 
?>
