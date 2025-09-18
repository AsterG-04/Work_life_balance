<?php
session_start();
include('nav_bar.php');

if (isset($_GET['fail'])) {
    echo "<p>Login Unsuccessful. Please try Again!</p>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style4.css">
    <title>Main Admin Login</title>
</head>

    <button onclick="history.back();" class="back-btn">Back</button>

<body>
<div class="content3">
    <!-- Login Page -->
    <form action="Main_Admin.php" method="post" enctype="multipart/form-data">
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
