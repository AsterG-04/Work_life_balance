<?php
session_start();
include('nav_bar.php');
include('DBconnect.php');

// Check if admin is logged in
if (!isset($_SESSION['adminname'])) {
    echo "<p style='color:red;'>You need to be logged in as an admin to perform this action.</p>";
    include('footer.php'); // Ensure footer is included before exiting
    exit(); // Stop further execution
}
?>

<button onclick="history.back();" class="back-btn">Back</button>

<?php
// Handle editing of activity information
if (isset($_GET['edit'])) {
    $activity_id = $_GET['edit'];
    $activity_id = mysqli_real_escape_string($con, $activity_id);

    // Select query
    $sql = "SELECT * FROM activities WHERE activity_id = '$activity_id'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<div class='content1'>";
        echo "<form action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' method='post' enctype='multipart/form-data'>";
        echo "<table>";

        while ($record = mysqli_fetch_assoc($result)) {
            echo "<input type='hidden' name='activity_id_value' value='" . htmlspecialchars($record['activity_id']) . "'>";

            // Display form fields
            echo "<h2>Edit Activity</h2>";
            echo "<tr><td>Activity Name</td><td><input type='text' name='activity_name' value='" . htmlspecialchars($record['activity_name']) . "' required></td></tr>";
            echo "<tr><td>Description</td><td><textarea name='description' rows='4' required>" . htmlspecialchars($record['description']) . "</textarea></td></tr>";
            echo "<tr><td>Duration (minutes)</td><td><input type='text' name='duration' value='" . htmlspecialchars($record['duration']) . "' required></td></tr>";
            echo "<tr><td>Fees</td><td><input type='number' name='Fees' value='" . htmlspecialchars($record['Fees']) . "' required></td></tr>";
            echo "<tr><td>Created At</td><td><input type='datetime-local' name='created_at' value='" . htmlspecialchars($record['created_at']) . "' required></td></tr>";
            echo "<tr><td>Updated At</td><td><input type='datetime-local' name='updated_at' value='" . htmlspecialchars($record['updated_at']) . "' required></td></tr>";
            echo "<tr><td>Upload Image</td><td><input type='file' name='uploadimage'></td></tr>";

            // Update button
            echo "<tr><td colspan=2 style='text-align:center;'><input type='submit' name='sub' value='Update'></td></tr>";
        }

        echo "</table></form>";
        echo "</div>"; // Closing content1 div
    } else {
        echo "No record found for the selected activity.";
    }
}

// Handle deletion of activity
if (isset($_POST['delete'])) {
    $activity_id = $_POST['delete'];

    // Prevent SQL injection
    $activity_id = mysqli_real_escape_string($con, $activity_id);

    // Delete query
    $sql = "DELETE FROM activities WHERE activity_id = '$activity_id'";
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Successfully Deleted');</script>";
        echo "<script>window.location.href='ActivityInfo.php';</script>";
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}

// Handle update submission
if (isset($_POST['sub'])) {
    // Gather form data
    $activity_id = mysqli_real_escape_string($con, $_POST['activity_id_value']);
    $activity_name = mysqli_real_escape_string($con, $_POST['activity_name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $duration = mysqli_real_escape_string($con, $_POST['duration']);
    $Fees = mysqli_real_escape_string($con, $_POST['Fees']);
    $created_at = mysqli_real_escape_string($con, $_POST['created_at']);
    $updated_at = mysqli_real_escape_string($con, $_POST['updated_at']);

    // Handle image upload if provided
    if (isset($_FILES['uploadimage']) && $_FILES['uploadimage']['error'] === UPLOAD_ERR_OK) {
        $filename = $_FILES['uploadimage']['name'];
        $temp = $_FILES['uploadimage']['tmp_name'];
        $folder = './image_1/' . $filename;

        move_uploaded_file($temp, $folder);
        
        // Update query with image
        $sql = "UPDATE activities SET 
                    activity_name='$activity_name', 
                    description='$description', 
                    duration='$duration', 
                    Fees='$Fees', 
                    created_at='$created_at', 
                    updated_at='$updated_at', 
                    uploadimage='$filename' 
                WHERE activity_id='$activity_id'";
    } else {
        // Update query without image
        $sql = "UPDATE activities SET 
                    activity_name='$activity_name', 
                    description='$description', 
                    duration='$duration', 
                    Fees='$Fees', 
                    created_at='$created_at', 
                    updated_at='$updated_at' 
                WHERE activity_id='$activity_id'";
    }

    if (mysqli_query($con, $sql)) {
        echo "<p style='color:green;'>Successfully Edited</p>";
        header('Location: ActivityInfo.php'); // Redirect after successful edit
        exit();
    } else {
        echo "Edit Unsuccessful. Error: " . mysqli_error($con);
    }
}
?>

<head>
    <link rel="stylesheet" type="text/css" href="style7.css">
</head>

<?php include('footer.php'); ?>
