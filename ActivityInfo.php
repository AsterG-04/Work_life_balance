<?php
session_start();
include('nav_bar.php');
include('DBconnect.php');

// Handle delete request
if (isset($_POST['delete'])) {
    $activity_id = intval($_POST['activity_id']); // Use intval for security

    // Delete query
    $delete_sql = "DELETE FROM activities WHERE activity_id = '$activity_id'";
    
    if (mysqli_query($con, $delete_sql)) {
        header('Location: ActivityInfo.php');
        exit;
    } else {
        echo "Error deleting activity: " . mysqli_error($con);
    }
}

// Fetch activity data from the database
$activities = [];
$sql = "SELECT * FROM activities";
$result = mysqli_query($con, $sql);

if ($result) {
    while ($record = mysqli_fetch_assoc($result)) {
        $activities[] = $record;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style7.css">
    <title>Activity Information</title>
</head>
<body>

<div class="content1">
    <button onclick="history.back();" class="back-btn">Back</button>
    
    <h2>Activities Info</h2>
    
    <?php if (!empty($activities)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Activity ID</th>
                    <th>Activity Name</th>
                    <th>Description</th>
                    <th>Duration (minutes)</th>
                    <th>Fees</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activities as $activity): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($activity['activity_id']); ?></td>
                        <td><?php echo htmlspecialchars($activity['activity_name']); ?></td>
                        <td><?php echo htmlspecialchars($activity['description']); ?></td>
                        <td><?php echo htmlspecialchars($activity['duration']); ?></td>
                        <td><?php echo htmlspecialchars($activity['Fees']); ?></td>
                        <td><?php echo htmlspecialchars($activity['created_at']); ?></td>
                        <td><?php echo htmlspecialchars($activity['updated_at']); ?></td>
                        <td><img src="./image_1/<?php echo htmlspecialchars($activity['uploadimage']); ?>" alt="<?php echo htmlspecialchars($activity['activity_name']); ?>" style="width:100px; height:auto;"></td>

                        <!-- Action Buttons -->
                        <td>
                            <!-- Edit Button -->
                            <form method="get" action="manage_activity.php" style="display:inline;" enctype="multipart/form-data">
                                <input type="hidden" name="edit" value="<?php echo htmlspecialchars($activity['activity_id']); ?>">
                                <button type="submit" class="edit-btn">Edit</button>
                            </form>

                            <!-- Delete Button -->
                            <form method="post" style="display:inline;" enctype="multipart/form-data">
                                <input type="hidden" name="activity_id" value="<?php echo htmlspecialchars($activity['activity_id']); ?>">
                                <button type="submit" name="delete" class="delete-btn" onclick="return confirm('Are you sure you want to delete this activity?');">Delete</button>
                            </form>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>
        <p>No activities found.</p>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>
</body>

</html>
