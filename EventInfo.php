<?php
session_start();
include('nav_bar.php');
include('DBconnect.php');

// Handle delete request
if (isset($_POST['delete'])) {
    $event_id = intval($_POST['event_id']); // Use intval for security

    // Delete query
    $delete_sql = "DELETE FROM event WHERE event_id = '$event_id'";
    
    if (mysqli_query($con, $delete_sql)) {
        header('Location: EventInfo.php');
        exit;
    } else {
        echo "Error deleting event: " . mysqli_error($con);
    }
}

// Fetch event data from the database
$events = [];
$sql = "SELECT * FROM event";
$result = mysqli_query($con, $sql);

if ($result) {
    while ($record = mysqli_fetch_assoc($result)) {
        $events[] = $record;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style6.css">
    <title>Event Information</title>
</head>
<body>

<div class="content">
    <button onclick="history.back();" class="back-btn">Back</button>
    <h2>Event Information</h2>

    <?php if (!empty($events)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Event ID</th>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Location</th>
                    <th>Description</th>
                    <th>Max Participants</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($event['event_id']); ?></td>
                        <td><?php echo htmlspecialchars($event['event_name']); ?></td>
                        <td><?php echo htmlspecialchars($event['event_date']); ?></td>
                        <td><?php echo htmlspecialchars($event['start_time']); ?></td>
                        <td><?php echo htmlspecialchars($event['end_time']); ?></td>
                        <td><?php echo htmlspecialchars($event['location']); ?></td>
                        <td><?php echo htmlspecialchars($event['description']); ?></td>
                        <td><?php echo htmlspecialchars($event['max_participants']); ?></td>
                        <td><?php echo htmlspecialchars($event['created_time']); ?></td>
                        <td><?php echo htmlspecialchars($event['updated_time']); ?></td>
                        <td><img src="./image_1/<?php echo htmlspecialchars($event['uploadimage']); ?>" alt="Event Image" style="width:100px; height:auto;"></td>

                        <!-- Action Buttons -->
                        <td>
                            <!-- Edit Button -->
                            <form method="get" action="manage_events.php" style="display:inline;" enctype="multipart/form-data">
                                <input type="hidden" name="edit" value="<?php echo htmlspecialchars($event['event_id']); ?>">
                                <button type="submit" class="edit-btn">Edit</button>
                            </form>

                            <!-- Delete Button -->
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event['event_id']); ?>" enctype="multipart/form-data">
                                <button type="submit" name="delete" class="delete-btn" onclick="return confirm('Are you sure you want to delete this event?');">Delete</button>
                            </form>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No events found.</p>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>
</body>
</html>
