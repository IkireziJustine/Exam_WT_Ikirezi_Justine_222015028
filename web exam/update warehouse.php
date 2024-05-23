<?php
include('db_connection.php');

// Check if warehouse_id is set
if (isset($_REQUEST['warehouse_id'])) {
    $warehouse_id = $_REQUEST['warehouse_id'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $conn->prepare("SELECT * FROM warehouse WHERE warehouse_id=?");
    $stmt->bind_param("i", $warehouse_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $warehouse_id = $row['warehouse_id'];
        $location = $row['location'];
        $capacity = $row['capacity'];
    } else {
        echo "Warehouse not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<html>
<head>
    <title>Update warehouse</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update warehouse form -->
        <h2><u>Update Form of Warehouse</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <input type="hidden" name="warehouse_id" value="<?php echo isset($warehouse_id) ? $warehouse_id : ''; ?>">
            <label for="location">Location:</label>
            <input type="text" name="location" value="<?php echo isset($location) ? $location : ''; ?>"><br><br>

            <label for="capacity">Capacity:</label>
            <input type="number" name="capacity" value="<?php echo isset($capacity) ? $capacity : ''; ?>"><br><br>

            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $warehouse_id = $_POST['warehouse_id'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];

    // Update the warehouse in the database (prepared statement again for security)
    $stmt = $conn->prepare("UPDATE warehouse SET location=?, capacity=? WHERE warehouse_id=?");
    $stmt->bind_param("sii", $location, $capacity, $warehouse_id);
    $stmt->execute();

    // Redirect to warehouse.php
    header('Location: warehouse.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($conn);
?>
