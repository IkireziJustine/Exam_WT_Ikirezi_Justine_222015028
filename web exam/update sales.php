<?php
include('db_connection.php');


// Check if sales_Id is set
if (isset($_REQUEST['sales_id'])) {
  $sales_id = $_REQUEST['sales_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $conn->prepare("SELECT * FROM sales WHERE sales_id=?");
  $stmt->bind_param("i", $sales_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $sales_id = $row['sales_id'];
    $customer_id = $row['customer_id'];
    $Date = $row['Date'];
    $Amount = $row['Amount'];
    
  } else {
    echo "Product not found.";
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
    <!-- Update sales form -->
    <h2><u>Update Form of sales</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="customer_id ">customer_id :</label>
    <input type="number" name="customer_id " value="<?php echo isset($customer_id ) ? $customer_id  : ''; ?>">
    <br><br>

    <label for="Date">Date:</label>
    <input type="Date" name="Date" value="<?php echo isset($Date) ? $Date : ''; ?>">
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
  $customer_id  = $_POST['customer_id '];
  $Date = $_POST['Date'];
  $Amount = $_POST['Amount'];
  

  // Update the sales in the database (prepared statement again for security)
  $stmt = $conn->prepare("UPDATE sales SET customer_id=?, Date=?,Amount=? WHERE sales_id=?");
  $stmt->bind_param("idii", $customer_id , $Date,$Amount,$sales_id);
  $stmt->execute();

  // Redirect to sales.php
  header('Location:sales.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($conn);
?>