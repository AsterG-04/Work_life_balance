<?php
session_start();
include('nav_bar.php');
include('DBconnect.php');
?>

<head>
    <link rel="stylesheet" type="text/css" href="style5.css">
</head>
<div class="content">
    <button onclick="history.back();" class="back-btn">Back</button>
    <table class="Status">
        <tr>
            <th>Admin Name</th>
        </tr>
        <tr>
            <td>
                <?php
                    // Display admin name or "Not Logged In" if session is not set
                    if (isset($_SESSION['adminname'])) {
                        echo htmlspecialchars($_SESSION['adminname']);
                    } else {
                        echo "Not Logged In";
                    }
                ?>
            </td>
        </tr>
    </table>

    <!-- Enroll table -->
    <form action="manage_enroll.php" method="post" enctype="multipart/form-data">
        <table border="1">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>DOB</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Event ID</th>
                    <th>Activity ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Fetch data from the enroll table
                    $sql = "SELECT * FROM enroll";
                    $result = mysqli_query($con, $sql);

                    if ($result) {
                        while ($record = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($record['user_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($record['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($record['dob']) . "</td>";
                            echo "<td>" . htmlspecialchars($record['gender']) . "</td>";
                            echo "<td>" . htmlspecialchars($record['phnumber']) . "</td>";
                            echo "<td>" . htmlspecialchars($record['email']) . "</td>";
                            echo "<td>" . htmlspecialchars(($record['event_id'] ?? 'N/A')) . "</td>"; // Handle null values gracefully
                            echo "<td>" . htmlspecialchars(($record['activity_id'] ?? 'N/A')) . "</td>";

                            // Add delete and edit buttons with appropriate values
                            echo "<td>";
                            // Conditionally display buttons based on admin login status
                            if (isset($_SESSION['adminname'])) {
                                echo "<button type='submit' value='" . htmlspecialchars($record['user_id']) . "' name='delete' onclick=\"return confirm('Are you sure you want to delete?')\">DELETE</button>";
                                echo "<button type='submit' value='" . htmlspecialchars($record['user_id']) . "' name='edit'>EDIT</button>";
                            } else {
                                echo "<a>Login as Admin to edit</a>"; // Provide a message or link to login
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "Error fetching data: " . mysqli_error($con);
                    }
                ?>
            </tbody>
        </table>
    </form>
</div>

<?php include('footer.php'); ?>
