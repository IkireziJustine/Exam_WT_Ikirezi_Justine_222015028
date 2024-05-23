<?php
include('db_connection.php');

// Check if customer_id is set
if (isset($_REQUEST['customer_id'])) {
    $customer_id = $_REQUEST['customer_id'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $conn->prepare("SELECT * FROM customers WHERE customer_id=?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $product_id = $row['product_id'];
        $transaction_id = $row['transaction_id'];
    } else {
        echo "Customer not found.";
    }
    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update customers</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update customer form -->
        <h2><u>Update Form of customers</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <input type="hidden" name="customer_id" value="<?php echo isset($customer_id) ? $customer_id : ''; ?>">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>"><br><br>

            <label for="product_id">Product ID:</label>
            <input type="text" name="product_id" value="<?php echo isset($product_id) ? $product_id : ''; ?>"><br><br>
            
            <label for="transaction_id">Transaction ID:</label>
            <input type="text" name="transaction_id" value="<?php echo isset($transaction_id) ? $transaction_id : ''; ?>"><br><br>

            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
include('db_connection.php');

if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $customer_id = $_POST['customer_id'];
    $name = $_POST['name'];
    $product_id = $_POST['product_id'];
    $transaction_id = $_POST['transaction_id'];

    // Update the customer in the database (prepared statement again for security)
    $stmt = $conn->prepare("UPDATE customers SET name=?, product_id=?, transaction_id=? WHERE customer_id=?");
    $stmt->bind_param("siii", $name, $product_id, $transaction_id, $customer_id);
    $stmt->execute();

    // Redirect to customers.php
    header('Location: customers.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($conn);
?>
