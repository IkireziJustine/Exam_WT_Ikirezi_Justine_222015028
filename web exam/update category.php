<?php
include('db_connection.php');

// Check if sales_Id is set
if (isset($_REQUEST['category_id'])) {
  $category_id = $_REQUEST['category_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $conn->prepare("SELECT * FROM category WHERE category_id=?");
  $stmt->bind_param("i", $category_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $category_id = $row['category_id'];
    $Name = $row['Name'];
    $Description = $row['Description'];
   
    
  } else {
    echo "category not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update category</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
     
    <h2><u>Update Form of category</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="Name ">Name :</label>
    <input type="text" name="Name " value="<?php echo isset($Name ) ? $Name  : ''; ?>">
    <br><br>

    <label for="Description">Description:</label>
    <input type="text" name="Description" value="<?php echo isset($Description) ? $Description : ''; ?>">
    <br><br>
    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php

include('db_connection.php');

if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $Name  = $_POST['Name'];
  $Description= $_POST['Description'];
  
  

  // Update the sales in the database (prepared statement again for security)
  $stmt = $conn->prepare("UPDATE category SET Name=?,Description=? WHERE category_id=?");
  $stmt->bind_param("ssi", $Name,$Description,$category_id);
  $stmt->execute();

  // Redirect to category.php
  header('Location:category.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($conn);
?>