<?php
include('nav_bar.php');
include('DBconnect.php');

// Generate unique user_id
$result = mysqli_query($con, "SELECT MAX(user_id) AS max_id FROM enroll");
$row = mysqli_fetch_assoc($result);
$max_id = $row['max_id'];

// Increment the ID
if ($max_id) {
    $number = (int)substr($max_id, 2) + 1; // Get the numeric part and increment
} else {
    $number = 1; // Start from 1 if no records exist
}

$user_id = 'U-' . str_pad($number, 2, '0', STR_PAD_LEFT); // Format to U-01, U-02, etc.

// Fetch activity names
$sql_activities = "SELECT activity_id, activity_name FROM activities";
$result_activities = mysqli_query($con, $sql_activities);
$activities = mysqli_fetch_all($result_activities, MYSQLI_ASSOC);

// Fetch event names
$sql_events = "SELECT event_id, event_name FROM event";
$result_events = mysqli_query($con, $sql_events);
$events = mysqli_fetch_all($result_events, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style3.css">
    <title>Enrollment Form</title>
</head>

<body>
    <div class="content1">
        <button onclick="history.back();" class="back-btn">Back</button>
        <h2>Enrollment Form</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
            enctype="multipart/form-data">
            <table>
                <tr>
                    <td><label for="user_id">User ID:</label></td>
                    <td>
                        <input type="text" name="user_id" id="user_id"
                            value="<?php echo htmlspecialchars($user_id); ?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td><label for="type">Select Type:</label></td>
                    <td>
                        <select name="type" id="type">
                            <option value="">-- Select --</option>
                            <option value="activity">Activity</option>
                            <option value="event">Event</option>
                        </select>
                    </td>
                </tr>
                <tr id="activity_event_dropdown">
                    <td><label for="activity_event_id">Select Activity/Event:</label></td>
                    <td>
                        <select name="activity_event_id" id="activity_event_id">
                            <option value="">-- Select --</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="name">Name:</label></td>
                    <td><input type="text" name="name" id="name" required></td>
                </tr>
                <tr>
                    <td><label for="dob">Date of Birth:</label></td>
                    <td><input type="date" name="dob" id="dob" required></td>
                </tr>
                <tr>
                    <td><label for="gender">Gender:</label></td>
                    <td><input type="text" name="gender" id="gender" required></td>
                </tr>
                <tr>
                    <td><label for="phnumber">Phone Number:</label></td>
                    <td><input type="number" name="phnumber" id="phnumber" required></td>
                </tr>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" name="email" id="email" required></td>
                </tr>
                <tr>
                    <td><label for="e-name">Emergency Contact Name:</label></td>
                    <td><input type="text" name="e-name" id="e-name" required></td>
                </tr>
                <tr>
                    <td><label for="e-number">Emergency Contact Number:</label></td>
                    <td><input type="number" name="e-number" id="e-number" required></td>
                </tr>
                <tr>
                    <td><label for="medical_condition">Medical Condition:</label></td>
                    <td><input type="text" name="medical_condition" id="medical_condition" required>
                    </td>
                </tr>
                <tr>
                    <td><label for="current_medication">Current Medication:</label></td>
                    <td><input type="text" name="current_medication" id="current_medication" required>
                    </td>
                </tr>
                <tr>
                    <td><label for="preferred_time">Preferred Time:</label></td>
                    <td><input type="text" name="preferred_time" id="preferred_time" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <center>
                            <input type="submit" name="sub" value="Enroll" onclick="return confirmSubmission();">
                            <input type="reset" value="Reset" onclick="return confirmReset();">
                        </center>
                    </td>
                </tr>
            </table>
            <input type="hidden" id="hidden_activity" name="hidden_activity" value="">
            <input type="hidden" id="hidden_event" name="hidden_event" value="">
        </form>
        <script>
        const typeSelect = document.getElementById('type');
        const activityEventDropdown = document.getElementById('activity_event_dropdown');
        const activityEventIdSelect = document.getElementById('activity_event_id');
        const hiddenActivity = document.getElementById("hidden_activity");
        const hiddenEvent = document.getElementById("hidden_event");

        // Store activity and event options in JS arrays
        const activities = <?php echo json_encode($activities); ?>;
        const events = <?php echo json_encode($events); ?>;

        function populateDropdown(type) {
            activityEventIdSelect.innerHTML = '<option value="">-- Select --</option>'; // Clear existing options

            if (type === 'activity') {
                activities.forEach(activity => {
                    let option = document.createElement('option');
                    option.value = activity.activity_id;
                    option.textContent = activity.activity_name;
                    activityEventIdSelect.appendChild(option);
                });
                activityEventDropdown.style.display = 'table-row';
                hiddenActivity.value = 'true';
                hiddenEvent.value = '';
            } else if (type === 'event') {
                events.forEach(event => {
                    let option = document.createElement('option');
                    option.value = event.event_id;
                    option.textContent = event.event_name;
                    activityEventIdSelect.appendChild(option);
                });
                activityEventDropdown.style.display = 'table-row';
                hiddenActivity.value = '';
                hiddenEvent.value = 'true';
            } else {
                activityEventDropdown.style.display = 'none';
                hiddenActivity.value = '';
                hiddenEvent.value = '';
            }
        }

        typeSelect.addEventListener('change', function() {
            populateDropdown(this.value);
        });
        </script>

        <?php
        if (isset($_POST['sub'])) { // Check if the form is submitted
            include('DBconnect.php'); // Ensure database connection is included
        
            // Accept user data
            $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
            $type = mysqli_real_escape_string($con, $_POST['type']);
            $activity_event_id = mysqli_real_escape_string($con, $_POST['activity_event_id']);
            $name = mysqli_real_escape_string($con, $_POST['name']);
            $dob = mysqli_real_escape_string($con, $_POST['dob']);
            $gender = mysqli_real_escape_string($con, $_POST['gender']);
            $phnumber = mysqli_real_escape_string($con, $_POST['phnumber']);
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $e_name = mysqli_real_escape_string($con, $_POST['e-name']);
            $e_number = mysqli_real_escape_string($con, $_POST['e-number']);
            $medical_condition = mysqli_real_escape_string($con, $_POST['medical_condition']);
            $current_medication = mysqli_real_escape_string($con, $_POST['current_medication']);
            $preferred_time = mysqli_real_escape_string($con, $_POST['preferred_time']);
        
            // Determine event_id and activity_id based on the selected type
            $event_id = null;
            $activity_id = null;
        
            if ($type == 'event') {
                // Assign the selected activity/event ID to event_id
                $event_id = mysqli_real_escape_string($con, $_POST['activity_event_id']);
                // Ensure activity_id is NULL
                $activity_id = null;
            } elseif ($type == 'activity') {
                // Assign the selected activity/event ID to activity_id
                $activity_id = mysqli_real_escape_string($con, $_POST['activity_event_id']);
                // Ensure event_id is NULL
                $event_id = null;
            }
        

        
            // Insert query
            $sql = "INSERT INTO enroll (user_id, type, name, dob, gender, phnumber, email, e_name, e_number, medical_condition, current_medication, activity_id, event_id, preferred_time) 
                    VALUES ('$user_id', '$type', '$name', '$dob', '$gender', '$phnumber', '$email', '$e_name', '$e_number', '$medical_condition', '$current_medication',";
            
            // Dynamically set NULL values for activity_id and event_id
            if ($activity_id === null) {
                $sql .= "NULL, ";
            } else {
                $sql .= "'$activity_id', ";
            }
            
            if ($event_id === null) {
                $sql .= "NULL, ";
            } else {
                $sql .= "'$event_id', ";
            }
        
            $sql .= "'$preferred_time')";
        
            if (mysqli_query($con, $sql)) {
                echo "<script>alert('Enrollment successful!'); window.location.href='Home.php';</script>";
            } else {
                echo "Error: " . mysqli_error($con); // Show error message
            }
        }
        ?>
    </div>
    <?php include("footer.php"); ?>
</body>

</html>
