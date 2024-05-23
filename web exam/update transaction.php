<?php
include('db_connection.php');

// Check if transaction_id is set
if (isset($_REQUEST['transaction_id'])) {
    $transaction_id = $_REQUEST['transaction_id'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $conn->prepare("SELECT * FROM transaction WHERE transaction_id=?");
    $stmt->bind_param("i", $transaction_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $type = $row['type'];
        $date = $row['date'];
        $amount = $row['amount'];
    } else {
        echo "Transaction not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update transaction</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <h2><u>Update Form of Transaction</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="type">Type:</label>
            <input type="text" name="type" value="<?php echo isset($type) ? $type : ''; ?>">
            <br><br>
            <label for="date">Date:</label>
            <input type="date" name="date" value="<?php echo isset($date) ? $date : ''; ?>">
            <br><br>
            <label for="amount">Amount:</label>
            <input type="number" name="amount" value="<?php echo isset($amount) ? $amount : ''; ?>">
            <br><br>
            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
include('db_connection.php');

if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $type = $_POST['type'];
    $date = $_POST['date'];
    $amount = $_POST['amount'];

    // Update the transaction in the database (prepared statement again for security)
    $stmt = $conn->prepare("UPDATE transaction SET type=?, date=?, amount=? WHERE transaction_id=?");
    $stmt->bind_param("ssdi", $type, $date, $amount, $transaction_id);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Record updated successfully";
        
        // Redirect to transaction.php
        header('Location: transaction.php');
        exit(); // Ensure no other content is sent after redirection
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}

// Close the connection (important to close after use)
mysqli_close($conn);
?>
