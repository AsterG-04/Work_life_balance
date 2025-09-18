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
// Handle deletion of user
if (isset($_POST['delete'])) {
    $user_id = $_POST['delete'];

    // Prevent SQL injection
    $user_id = mysqli_real_escape_string($con, $user_id);

    // Delete query
    $sql = "DELETE FROM enroll WHERE user_id = '$user_id'";
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Successfully Deleted');</script>";
        echo "<script>window.location.href='userinfo.php';</script>";
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}
?> 
<head>
    <link rel="stylesheet" type="text/css" href="style5.css">
</head>
<?php
// Handle editing of user information
if (isset($_POST['edit'])) {
    $user_id = $_POST['edit'];
    $user_id = mysqli_real_escape_string($con, $user_id);

    // Select query
    $sql = "SELECT * FROM enroll WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<div class='content1'>";
        echo "<form action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' method='post'>";
        echo "<table>";

        while ($record = mysqli_fetch_assoc($result)) {
            echo "<input type='hidden' name='user_id_value' value='" . htmlspecialchars($record['user_id']) . "'>";

            // Display form fields
            echo "<tr><td>Name</td><td><input type='text' name='name' value='" . htmlspecialchars($record['name']) . "'></td></tr>";
            echo "<tr><td>DOB</td><td><input type='date' name='dob' value='" . htmlspecialchars($record['dob']) . "'></td></tr>";
            echo "<tr><td>Gender</td><td><input type='text' name='gender' value='" . htmlspecialchars($record['gender']) . "'></td></tr>";
            echo "<tr><td>Phone Number</td><td><input type='number' name='phnumber' value='" . htmlspecialchars($record['phnumber']) . "'></td></tr>";
            echo "<tr><td>Email</td><td><input type='email' name='email' value='" . htmlspecialchars($record['email']) . "'></td></tr>";
            echo "<tr><td>Emergency Name</td><td><input type='text' name='e_name' value='" . htmlspecialchars($record['e_name']) . "'></td></tr>";
            echo "<tr><td>Emergency Number</td><td><input type='number' name='e_number' value='" . htmlspecialchars($record['e_number']) . "'></td></tr>";
            echo "<tr><td>Medical Condition</td><td><textarea name='medical_condition'>" . htmlspecialchars($record['medical_condition']) . "</textarea></td></tr>";
            echo "<tr><td>Current Medication</td><td><textarea name='current_medication'>" . htmlspecialchars($record['current_medication']) . "</textarea></td></tr>";
            echo "<tr><td>Event ID</td><td><input type='text' name='event_id' value='" . htmlspecialchars($record['event_id']) . "'></td></tr>";
            echo "<tr><td>Activity ID</td><td><input type='text' name='activity_id' value='" . htmlspecialchars($record['activity_id']) . "'></td></tr>";
            echo "<tr><td>Preferred Time</td><td><input type='text' name='preferred_time' value='" . htmlspecialchars($record['preferred_time']) . "'></td></tr>";

            // Update button
            echo "<tr><td colspan=2 style='text-align:center;'><input type='submit' name='sub' value='Update'></td></tr>";
        }

        echo "</table></form>";
        echo "</div>"; // Closing content1 div
    } else {
        echo "No record found for the selected user.";
    }
}

// Handle update submission
if (isset($_POST['sub'])) {
    // Gather form data
    $user_id = mysqli_real_escape_string($con, $_POST['user_id_value']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $phnumber = mysqli_real_escape_string($con, $_POST['phnumber']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $e_name = mysqli_real_escape_string($con, $_POST['e_name']);
    $e_number = mysqli_real_escape_string($con, $_POST['e_number']);
    $medical_condition = mysqli_real_escape_string($con, $_POST['medical_condition']);
    $current_medication = mysqli_real_escape_string($con, $_POST['current_medication']);
    
    // Handle null values for event_id and activity_id
    $event_id = empty($_POST['event_id']) ? 'NULL' : "'" . mysqli_real_escape_string($con, $_POST['event_id']) . "'";
    $activity_id = empty($_POST['activity_id']) ? 'NULL' : "'" . mysqli_real_escape_string($con, $_POST['activity_id']) . "'";
    
    $preferred_time = mysqli_real_escape_string($con, $_POST['preferred_time']);

    // Update query
    $sql = "UPDATE enroll SET 
                name='$name', 
                dob='$dob', 
                gender='$gender', 
                phnumber='$phnumber', 
                email='$email', 
                e_name='$e_name', 
                e_number='$e_number', 
                medical_condition='$medical_condition', 
                current_medication='$current_medication', 
                event_id=$event_id,
                activity_id=$activity_id, 
                preferred_time='$preferred_time'
            WHERE user_id='$user_id'";
    
    if (mysqli_query($con, $sql)) {
        echo "<p style='color:green;'>Successfully Edited</p>";
        echo "<script>window.location.href='userinfo.php';</script>";
    } else {
        echo "Edit Unsuccessful. Error: " . mysqli_error($con);
    }
}

include('footer.php');
?>
