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
    <link rel="stylesheet" type="text/css" href="style8.css">
    <title>Admin Information</title>
</head>
<body>
    <div class="content">
        <button onclick="history.back();" class="back-btn">Back</button>


        <!-- Button to go to Admin Control -->
        <button onclick="window.location.href='Admin_Control.php';" class="Add_A">Add New Admin</button>

        <h2>Admin Information</h2>

        <form method="post" enctype="multipart/form-data">
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>

                <?php
                $sql = "SELECT * FROM admin";
                $result = mysqli_query($con, $sql);

                while ($record = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($record['admin_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($record['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($record['email']) . "</td>";
                    echo "<td>
                              <button type='submit' value='" . htmlspecialchars($record['admin_id']) . "' name='edit'>EDIT</button>
                              <button type='submit' value='" . htmlspecialchars($record['admin_id']) . "' name='delete' onclick='return confirm(\"Are you sure you want to delete this admin?\")'>DELETE</button>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </form>

        <?php
        // Handle Delete Admin
        if (isset($_POST['delete'])) {
            $admin_id = $_POST['delete'];

            $sql = "DELETE FROM admin WHERE admin_id=?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $admin_id);

            if ($stmt->execute()) {
                echo "<p style='color:green;'>Admin deleted successfully!</p>";
                echo "<script>window.location.href='AdminInfo.php';</script>"; // Refresh the page
                exit;
            } else {
                echo "<p style='color:red;'>Error deleting admin: " . $con->error . "</p>";
            }
        }
        ?>

        <?php
        // Handle Edit Admin
        if (isset($_POST['edit'])) {
            $admin_id = $_POST['edit'];
            $sql = "SELECT * FROM admin WHERE admin_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $admin_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($record = $result->fetch_assoc()) {
                ?>
                <h2>Edit Admin</h2>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="admin_id" value="<?php echo htmlspecialchars($record['admin_id']); ?>">
                    <table>
                        <tr>
                            <td><label>Username:</label></td>
                            <td><input type="text" name="username" value="<?php echo htmlspecialchars($record['username']); ?>" required></td>
                        </tr>
                        <tr>
                            <td><label>Email:</label></td>
                            <td><input type="email" name="email" value="<?php echo htmlspecialchars($record['email']); ?>" required></td>
                        </tr>
                        <tr>
                            <td colspan="2"><center><input type="submit" name="update_admin" value="Update Admin"></center></td>
                        </tr>
                    </table>
                </form>
                <?php
            }
        }

        // Handle Update Admin
        if (isset($_POST['update_admin'])) {
            $admin_id = $_POST['admin_id'];
            $username = $_POST['username'];
            $email = $_POST['email'];

            $sql = "UPDATE admin SET username=?, email=?, updated_at=NOW() WHERE admin_id=?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $admin_id);

            if ($stmt->execute()) {
                echo "<p style='color:green;'>Admin updated successfully!</p>";
                echo "<script>window.location.href='AdminInfo.php';</script>"; // Refresh the page
                exit;
            } else {
                echo "<p style='color:red;'>Error updating admin: " . $con->error . "</p>";
            }
        }
        ?>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
