<?php
include('db_connection.php');


// Check if sales_Id is set
if (isset($_REQUEST['purchaseorder_id'])) {
  $purchaseorder_id = $_REQUEST['purchaseorder_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $conn->prepare("SELECT * FROM purchase WHERE purchaseorder_id=?");
  $stmt->bind_param("i", $purchaseorder_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $purchaseorder_id = $row['purchaseorder_id'];
    $supplier_id = $row['supplier_id'];
    $OrderDate = $row['OrderDate'];
    $Amount = $row['Amount'];
    
  } else {
    echo "purchaser not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update sales</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update purchase form -->
    <h2><u>Update Form of purchase</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="supplier_id ">supplier_id :</label>
    <input type="number" name="supplier_id " value="<?php echo isset($supplier_id ) ? $supplier_id  : ''; ?>">
    <br><br>

    <label for="OrderDate">Date:</label>
    <input type="Date" name="OrderDate" value="<?php echo isset($OrderDate) ? $OrderDate : ''; ?>">
    <br><br>
     <label for="Amount">Amount:</label>
    <input type="number" name="Amount" value="<?php echo isset($Amount) ? $Amount : ''; ?>">
    <br><br>

 
    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
include('db_connection.php');

if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $supplier_id  = $_POST['supplier_id '];
  $OrderDate = $_POST['OrderDate'];
  $Amount = $_POST['Amount'];
  

  // Update the sales in the database (prepared statement again for security)
  $stmt = $conn->prepare("UPDATE purchase SET supplier_id=?,OrderDate=?,Amount=? WHERE purchaseorder_id=?");
  $stmt->bind_param("idii", $supplier_id , $OrderDate,$Amount,$purchaseorder_id);
  $stmt->execute();

  // Redirect to sales.php
  header('Location:purchase.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($conn);
?>