<?php
include_once 'classes/db1.php';

// Fetch the newly registered students
$sql = "SELECT * FROM participent";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Call the stored procedure to calculate the total number of newly registered members
$procedureSql = "CALL CalculateNewRegistrations()";
$procedureResult = mysqli_query($conn, $procedureSql);

if (!$procedureResult) {
    die("Stored procedure execution failed: " . mysqli_error($conn));
}

// Fetch the result of the stored procedure
$row = mysqli_fetch_assoc($procedureResult);
$totalNewRegistrations = $row['totalRegistrations'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>cems</title>
    <?php require 'utils/styles.php'; ?>
</head>
<body>
    <?php require 'utils/adminHeader.php'; ?>
    <div class="content">
        <div class="container">
            <h1>Newly Registered Students</h1>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table class="table table-hover">
                    <tr>
                        <th>USN</th>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>Semester</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>College</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row["usn"]; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["branch"]; ?></td>
                            <td><?php echo $row["sem"]; ?></td>
                            <td><?php echo $row["email"]; ?></td>
                            <td><?php echo $row["phone"]; ?></td>
                            <td><?php echo $row["college"]; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>No newly registered students.</p>
            <?php endif; ?>
            
            <!-- Display total number of newly registered members -->
            <p>Total newly registered members: <?php echo $totalNewRegistrations; ?></p>
        </div>
    </div>
    <?php require 'utils/footer.php'; ?>
</body>
</html>
