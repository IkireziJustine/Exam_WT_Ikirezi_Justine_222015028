<?php
include('db_connection.php');

// Check if Product_Id is set
if (isset($_REQUEST['inventory_id'])) {
  $inventory_id = $_REQUEST['inventory_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $conn->prepare("SELECT * FROM inventory WHERE inventory_id=?");
  $stmt->bind_param("i", $inventory_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $inventory_id = $row['inventory_id'];
    $quantity = $row['quantity'];
    $product_id = $row['product_id'];
    $warehouse_id = $row['warehouse_id'];
  } else {
    echo "inventory not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update inventory</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update products form -->
    <h2><u>Update Form of inventory</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="quantity">Product quantity:</label>
    <input type="text" name="quantity" value="<?php echo isset($quantity) ? $quantity: ''; ?>">
    <br><br>

    <label for="product_id">product_id:</label>
    <input type="number" name="product_id" value="<?php echo isset($product_id) ? $product_id : ''; ?>">

    <label for="warehouse_id">warehouse_id:</label>
    <input type="text" name="warehouse_id" value="<?php echo isset($warehouse_id) ? $warehouse_id : ''; ?>">
    <br><br>
    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
include('db_connection.php');

if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $quantity = $_POST['quantity'];
  $product_id = $_POST['product_id'];
  $warehouse_id = $_POST['warehouse_id'];

  // Update the product in the database (prepared statement again for security)
  $stmt = $conn->prepare("UPDATE inventory SET quantity=?, product_id=?,quantity=?, warehouse_id=? WHERE inventory_id=?");
  $stmt->bind_param("ssdii", $quantity, $product_id,$quantity, $warehouse_id, $inventory_id);
  $stmt->execute();

  // Redirect to product.php
  header('Location: inventory.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($conn);
?>