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
    <title>Activity Form</title>
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
                    <td><label>Enter Activity Name:</label></td>
                    <td><input type="text" name="activity_name" id="activity_name" required></td>
                </tr>
                <tr>
                    <td><label>Enter Description:</label></td>
                    <td><textarea name="description" id="description" rows="4" cols="50" required></textarea></td>
                </tr>
                <tr>
                    <td><label>Enter Duration (minutes):</label></td>
                    <td><input type="text" name="duration" id="duration" required></td>
                </tr>
                <tr>
                    <td><label>Enter Fees:</label></td>
                    <td><input type="number" name="Fees" id="Fees" required></td>
                </tr>
                <tr>
                    <td><label>Enter Created Time:</label></td>
                    <td><input type="datetime-local" name="created_at" id="created_at" required></td>
                </tr>
                <tr>
                    <td><label>Enter Updated Time:</label></td>
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

        <!-- JavaScript for confirmation -->
        <script>
            function confirmSubmission() {
                return confirm("Are you sure you want to register this activity?");
            }

            function confirmReset() {
                return confirm("Are you sure you want to reset this form?");
            }
        </script>

        <?php
        if (isset($_POST['sub'])) {
            // Accept user data and sanitize inputs
            $activity_name = mysqli_real_escape_string($con, $_POST['activity_name']);
            $description = mysqli_real_escape_string($con, $_POST['description']);
            $duration = mysqli_real_escape_string($con, $_POST['duration']);
            $Fees = mysqli_real_escape_string($con, $_POST['Fees']);
            $created_at = mysqli_real_escape_string($con, $_POST['created_at']);
            $updated_at = mysqli_real_escape_string($con, $_POST['updated_at']);

            if (isset($_FILES['uploadimage']) && $_FILES['uploadimage']['error'] === UPLOAD_ERR_OK) {
                $filename = mysqli_real_escape_string($con, $_FILES['uploadimage']['name']);
                $temp = $_FILES['uploadimage']['tmp_name'];
                $folder = './image_1/' . $filename;

                if (move_uploaded_file($temp, $folder)) {
                    // Generate unique activity_id
                    $result = mysqli_query($con, "SELECT MAX(activity_id) AS max_id FROM activities");
                    $row = mysqli_fetch_assoc($result);
                    $max_id = $row['max_id'];

                    // Increment the ID
                    if ($max_id) {
                        $number = (int)substr($max_id, 2) + 1; // Get the numeric part and increment
                    } else {
                        $number = 1; // Start from 1 if no records exist
                    }

                    $activity_id = 'A-' . str_pad($number, 2, '0', STR_PAD_LEFT); // Format to A-01, A-02, etc.

                    // Insert query
                    $sql = "INSERT INTO activities (activity_id, activity_name, description, duration, Fees, created_at, updated_at, uploadimage) 
                            VALUES ('$activity_id', '$activity_name', '$description', '$duration', '$Fees', '$created_at', '$updated_at', '$filename')";

                    // Execute query
                    if (mysqli_query($con, $sql)) {
                        echo "<script>alert('Activity Successfully Registered!');</script>";
                    } else {
                        echo "Input Unsuccessful: " . mysqli_error($con); // Show error message
                    }
                } else {
                    echo "<script>alert('Failed to upload the image. Please try again.');</script>";
                }
            } else {
                echo "<script>alert('Please upload a valid image file.');</script>";
            }
        }
        ?>
    </div>

    <?php include("footer.php"); ?>
</body>
</html>
