<?php
session_start();
include('nav_bar.php');
include('DBconnect.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style4.css">
    <title>Admin Home</title>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="UserInfo.php">Manage Enrollments</a>
        <a href="Event_Form.php">Add Event</a>
        <a href="EventInfo.php">Manage Events</a>
        <a href="Activity_Form.php">Add Activity</a>
        <a href="ActivityInfo.php">Manage Activities</a>
        <a href="Main_Admin_Login.php">Admin Control</a>
        <a href="Logout.php">Logout</a>
    </div>

    <!-- Page Content -->
    <div class="content">
        <button onclick="history.back();" class="back-btn">Back</button>
        <h2>Admin Control Panel</h2>
        <h3 class="A">Welcome to the admin control panel. Use the sidebar to manage different aspects of the application.</h3>
        
    </div>

</body>

</html>
