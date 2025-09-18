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
    <link rel="stylesheet" type="text/css" href="style3.css">
    <title>Add Admin</title>
</head>
<body>
    <div class="content1"> 
    <button onclick="history.back();" class="back-btn">Back</button>
     <!-- CHANGED FROM content2 to content1 -->
        <h2>Add New Admin</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td><label>Username:</label></td>
                    <td><input type="text" name="username" required></td>
                </tr>
                <tr>
                    <td><label>Password:</label></td>
                    <td><input type="password" name="password" required></td>
                </tr>
                <tr>
                    <td><label>Email:</label></td>
                    <td><input type="email" name="email" required></td>
                </tr>
                 <tr>
                    <td><label>Enter Created Time: </label></td>
                    <td><input type="datetime-local" name="created_at" id="created_at" required></td>
                </tr>
                <tr>
                    <td><label>Enter Updated Time: </label></td>
                    <td><input type="datetime-local" name="updated_at" id="updated_at" required></td>
                </tr>
                <tr>
                    <td colspan="2"><center><input type="submit" name="add_admin" value="Add Admin"></center></td>
                </tr>
            </table>
        </form>
    </div>

    <?php
    if (isset($_POST['add_admin'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
        $email = $_POST['email'];
        $created_at = $_POST['created_at'];
        $updated_at = $_POST['updated_at'];

        $sql = "INSERT INTO admin (username, password, email, created_at, updated_at) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssss", $username, $password, $email, $created_at, $updated_at);

        if ($stmt->execute()) {
            echo "<p style='color:green; text-align:center;'>Admin added successfully!</p>";
        } else {
            echo "<p style='color:red; text-align:center;'>Error adding admin: " . $con->error . "</p>";
        }
    }
    ?>

    <?php include('footer.php'); ?>
</body>
</html>
