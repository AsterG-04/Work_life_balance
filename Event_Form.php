<?php
include('nav_bar.php');
include('DBconnect.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style3.css">
	<title>Event_Form</title>
</head>
<body>
	<div class="content1">
		<button onclick="history.back();" class="back-btn">Back</button>
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
		    <table>
		        <tr>
		            <td><label>Enter Image: </label></td>
		            <td><input type="file" name="uploadimage"><br><p class="warning-message">The image file name must not have spaces between each word. It should be like_this.</p></td>
		        </tr>
		        <tr>
		            <td><label>Enter Event Name: </label></td>
		            <td><input type="text" name="event_name" id="name" required></td>
		        </tr>
		        <tr>
		            <td><label>Enter Event Date: </label></td>
		            <td><input type="date" name="event_date" id="event_date" required></td>
		        </tr>
		        <tr>
		            <td><label>Enter Start Time: </label></td>
		            <td><input type="time" name="start_time" id="start_time" required></td>
		        </tr>
		        <tr>
		            <td><label>Enter End Time: </label></td>
		            <td><input type="time" name="end_time" id="end_time" required></td>
		        </tr>
		        <tr>
		            <td><label>Enter Location: </label></td>
		            <td><input type="text" name="location" id="location" placeholder="Enter Address" required></td>
		        </tr>
		        <tr>
		            <td><label>Enter Description: </label></td>
		            <td><textarea name="description" id="description" rows="4" cols="50" required></textarea></td>
		        </tr>
		        <tr>
		            <td><label>Enter Max Participants: </label></td>
		            <td><input type="number" name="max_participants" id="max_participants" required></td>
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
		            <td colspan="2"><center> 
				    <input type="submit" name="sub" value="Register" onclick="return confirmSubmission();"> 
				    <input type="reset" name="reset" onclick="return confirmReset();">
					</center></td>
		        </tr>
		    </table>
		</form>

		<script>
			function confirmSubmission() {
			    return confirm("Are you sure you want to register this event?");
			}


			function confirmReset() {
			    return confirm("Are you sure you want to reset this event?"); // Confirmation dialog
			}
		</script>
		

	<?php
		if (isset($_POST['sub'])) {
    // accept user data
    $name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $max_participants = $_POST['max_participants'];
    $created_at = $_POST['created_at'];
    $updated_at = $_POST['updated_at'];
    $filename = $_FILES['uploadimage']['name'];
    $temp = $_FILES['uploadimage']['tmp_name'];
    $folder = './image_1/' . $filename;

    move_uploaded_file($temp, $folder);

    
        // Generate unique event_id
        $result = mysqli_query($con, "SELECT MAX(event_id) AS max_id FROM event");
        $row = mysqli_fetch_assoc($result);
        $max_id = $row['max_id'];

        // Increment the ID
        if ($max_id) {
            $number = (int)substr($max_id, 2) + 1; // Get the numeric part and increment
        } else {
            $number = 1; // Start from 1 if no records exist
        }

        $event_id = 'E-' . str_pad($number, 2, '0', STR_PAD_LEFT); // Format to E-01, E-02, etc.

        // insert query
        $sql = "INSERT INTO event(event_id, event_name, event_date, start_time, end_time, location, description, max_participants, created_time, updated_time, uploadimage) 
                VALUES('$event_id', '$name', '$event_date', '$start_time', '$end_time', '$location', '$description', '$max_participants', '$created_at', '$updated_at', '$filename')";

        // insert into table
        if (mysqli_query($con, $sql)) {
            echo "<script>alert('Your Data is Successfully Inserted');</script>";
        } else {
            echo "Input Unsuccessful: " . mysqli_error($con); // Show error message
        }
    }
    ?>
    </div>
</body>


<?php
include("footer.php");
?>



