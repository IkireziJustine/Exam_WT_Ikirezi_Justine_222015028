<?php
include('db_connection.php');

// Check if sales_Id is set
if (isset($_REQUEST['supplier_id'])) {
  $supplier_id = $_REQUEST['supplier_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $conn->prepare("SELECT * FROM suppliers WHERE supplier_id=?");
  $stmt->bind_param("i", $supplier_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $supplier_id = $row['supplier_id'];
    $name = $row['name'];
    $contact = $row['contact'];
    $address = $row['address'];
    
  } else {
    echo "suppliers not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update suppliers</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    
    <h2><u>Update Form of suppliers</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="name">name:</label>
    <input type="text" name="name" value="<?php echo isset($name) ? 
    $name : ''; ?>">
    <br><br>

    <label for="contact">contact:</label>
    <input type="text" name="contact" value="<?php echo isset($contact) ?
     $contact : ''; ?>">
    <br><br>
     <label for="address">address:</label>
    <input type="text" name="address" value="<?php echo isset($address) ? $address : ''; ?>">
    <br><br>

 
    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
include('db_connection.php');

if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $name = $_POST['name'];
  $contact = $_POST['contact'];
  $address = $_POST['address'];
  

  // Update the sales in the database (prepared statement again for security)
  $stmt = $conn->prepare("UPDATE suppliers SET name=?,contact=?,address=? WHERE supplier_id=?");
  $stmt->bind_param("sssi", $name,$contact,$address,$supplier_id);
  $stmt->execute();

  // Redirect to sales.php
  header('Location:suppliers.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($conn);
?>