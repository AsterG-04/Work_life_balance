<?php
include("nav_bar.php");
include("DBconnect.php");

// Fetch data from the database
$sql = "SELECT * FROM event";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style3.css">
    <title>Events</title>
</head>

<button onclick="history.back();" class="back-btn">Back</button>

<body>

<div class="container">
    <div class="event-grid">  <!-- Added a wrapper for the grid layout -->
    <?php
    // Display each record in a styled box
    while ($record = mysqli_fetch_array($result)) {
        echo "<div class='data-box'>";
       echo "<img src='image_1/" . htmlspecialchars($record['uploadimage']) . "' alt='Event Image' class='event-image'>";
        echo "<h3>Event Name: " . htmlspecialchars($record['event_name']) . "</h3>";
        echo "<p><strong>Date:</strong> " . htmlspecialchars($record['event_date']) . "</p>";
        echo "<p><strong>Time:</strong> " . htmlspecialchars($record['start_time']) . " - " . htmlspecialchars($record['end_time']) . "</p>";
        echo "<p><strong>Location:</strong> " . htmlspecialchars($record['location']) . "</p>";
        echo "<p class='description'><strong>Description:</strong> " . htmlspecialchars($record['description']) . "</p>";
        echo "<p><strong>Participants:</strong> " . htmlspecialchars($record['max_participants']) . "</p>";
        echo "<p><strong>Created:</strong> " . htmlspecialchars($record['created_time']) . "</p>";
        echo "<p><strong>Updated:</strong> " . htmlspecialchars($record['updated_time']) . "</p>";

        echo "<button class='btn_join' onclick='redirectToEventForm()'>Join Now</button>";

        echo "</div>";
    }
    ?>
    </div>

    <script>
        function redirectToEventForm() {
            window.location.href = 'Enroll_Form.php';
        }
    </script>

</div>

</body>
<?php
    include("footer.php");
?>
</html>
