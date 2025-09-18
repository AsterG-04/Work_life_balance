<?php
include("nav_bar.php");
include("DBconnect.php");

// Fetch data from the database
$sql = "SELECT * FROM activities";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style3.css">
    <title>Activities</title>
</head>
<body>

<div class="container">
    <button onclick="history.back();" class="back-btn">Back</button>
    <div class="activity-grid">  <!-- Added a wrapper for the grid layout -->
    <?php
    // Display each record in a styled box
    while ($record = mysqli_fetch_array($result)) {
        echo "<div class='data-box'>";
        echo "<img src='image_1/" . htmlspecialchars($record['uploadimage']) . "' alt='Activity Image' class='activity-image'>";
        echo "<h3>Activity Name: " . htmlspecialchars($record['activity_name']) . "</h3>";
        echo "<p><strong>Description:</strong> " . htmlspecialchars($record['description']) . "</p>";
        echo "<p><strong>Duration (minutes):</strong> " . htmlspecialchars($record['duration']) . "</p>";
        echo "<p><strong>Fees:</strong> " . htmlspecialchars($record['Fees']) . "</p>";
        //Formatting the timestamp
        $created_at = date_format(date_create($record['created_at']),"Y/m/d H:i:s");
        $updated_at = date_format(date_create($record['updated_at']),"Y/m/d H:i:s");
        echo "<p><strong>Created:</strong> " . htmlspecialchars($created_at) . "</p>";
        echo "<p><strong>Updated:</strong> " . htmlspecialchars($updated_at) . "</p>";

        echo "<button class='btn_join' onclick='redirectToActivityForm()'>Join Now</button>";

        echo "</div>";
    }
    ?>
    </div>

    <script>
        function redirectToActivityForm() {
            window.location.href = 'Enroll_Form.php';
        }
    </script>

</div>

</body>
</html>
