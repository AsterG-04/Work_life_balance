<?php
session_start();
include('nav_bar.php');

if (isset($_GET['fail'])) {
    echo "<p>Login Unsuccessful. Please try Again!</p>";
}

// Redirect if already logged in
if (isset($_SESSION['adminname'])) {
    header('location:Admin_Home.php?already');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style4.css">
    <title>Admin Login</title>
</head>
<body>
<div class="content3">
    <!-- Login Page -->
    <form action="admin.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label for="username">Enter Username:</label></td>
                <td><input type="text" name="username" id="username" required></td>
            </tr>
            <tr>
                <td><label for="password">Enter Password:</label></td>
                <td><input type="password" name="password" id="password" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <center><input type="submit" name="sub" value="Login"></center>
                </td>
            </tr>
        </table>
    </form>
</div>
<?php include('footer.php'); ?>
</body>
</html>
