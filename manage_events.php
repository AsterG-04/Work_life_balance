<?php
session_start();
include('nav_bar.php');
include('DBconnect.php');
?>

<?php
// Check if admin is logged in
if (!isset($_SESSION['adminname'])) {
    echo "<p style='color:red;'>You need to be logged in as an admin to perform this action.</p>";
    include('footer.php'); // Ensure footer is included before exiting
    exit(); // Stop further execution
}
?>

<button onclick="history.back();" class="back-btn">Back</button>

<?php
// Handle editing of event information
if (isset($_GET['edit'])) {
    $event_id = $_GET['edit'];
    $event_id = mysqli_real_escape_string($con, $event_id);

    // Select query
    $sql = "SELECT * FROM event WHERE event_id = '$event_id'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<div class='content1'>";
        echo "<form action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' method='post'>";
        echo "<table>";

        while ($record = mysqli_fetch_assoc($result)) {
            echo "<input type='hidden' name='event_id_value' value='" . htmlspecialchars($record['event_id']) . "'>";

            // Display form fields
            echo "<h2>Edit Event</h2>";
            echo "<tr><td>Event Name</td><td><input type='text' name='event_name' value='" . htmlspecialchars($record['event_name']) . "' required></td></tr>";
            echo "<tr><td>Date</td><td><input type='date' name='event_date' value='" . htmlspecialchars($record['event_date']) . "' required></td></tr>";
            echo "<tr><td>Start Time</td><td><input type='time' name='start_time' value='" . htmlspecialchars($record['start_time']) . "' required></td></tr>";
            echo "<tr><td>End Time</td><td><input type='time' name='end_time' value='" . htmlspecialchars($record['end_time']) . "' required></td></tr>";
            echo "<tr><td>Location</td><td><input type='text' name='location' value='" . htmlspecialchars($record['location']) . "' required></td></tr>";
            echo "<tr><td>Description</td><td><input type='text' name='description' value='" . htmlspecialchars($record['description']) . "' required></td></tr>";
            echo "<tr><td>Max Participants</td><td><input type='number' name='max_participants' value='" . htmlspecialchars($record['max_participants']) . "' required></td></tr>";

            // Update button
            echo "<tr><td colspan=2 style='text-align:center;'><input type='submit' name='sub' value='Update'></td></tr>";
        }

        echo "</table></form>";
        echo "</div>"; // Closing content1 div
    } else {
        echo "No record found for the selected event.";
    }
}

// Handle deletion of event
if (isset($_POST['delete'])) {
    $event_id = $_POST['delete'];

    // Prevent SQL injection
    $event_id = mysqli_real_escape_string($con, $event_id);

    // Delete query
    $sql = "DELETE FROM event WHERE event_id = '$event_id'";
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Successfully Deleted');</script>";
        echo "<script>window.location.href='EventInfo.php';</script>";
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}

// Handle update submission
if (isset($_POST['sub'])) {
    // Gather form data
    $event_id = mysqli_real_escape_string($con, $_POST['event_id_value']);
    $event_name = mysqli_real_escape_string($con, $_POST['event_name']);
    $event_date = mysqli_real_escape_string($con, $_POST['event_date']);
    $start_time = mysqli_real_escape_string($con, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($con, $_POST['end_time']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $max_participants = mysqli_real_escape_string($con, $_POST['max_participants']);

    // Update query
    $sql = "UPDATE event SET 
                event_name='$event_name', 
                event_date='$event_date', 
                start_time='$start_time', 
                end_time='$end_time', 
                location='$location', 
                description='$description', 
                max_participants='$max_participants' 
            WHERE event_id='$event_id'";
    
    if (mysqli_query($con, $sql)) {
        echo "<p style='color:green;'>Successfully Edited</p>";
        header('Location: EventInfo.php'); // Redirect after successful edit
        exit();
    } else {
        echo "Edit Unsuccessful. Error: " . mysqli_error($con);
    }
}
?>

<head>
    <link rel="stylesheet" type="text/css" href="style5.css">
</head>


<?php include('footer.php'); ?>
