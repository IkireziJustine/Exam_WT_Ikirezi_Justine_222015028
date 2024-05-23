<?php
include('db_connection.php');

// Check if Product_Id is set
if (isset($_REQUEST['employee_id'])) {
  $employee_id = $_REQUEST['employee_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $conn->prepare("SELECT * FROM employee WHERE employee_id=?");
  $stmt->bind_param("i", $employee_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $employee_id = $row['employee_id'];
    $Name = $row['Name'];
    $Position = $row['Position'];
    $Department = $row['Department'];
  } else {
    echo "employee not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update employees</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update employee form -->
    <h2><u>Update Form of employee</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="Name">Employee Name:</label>
    <input type="text" name="Name" value="<?php echo isset($Name) ? $Name : ''; ?>">
    <br><br>

    <label for="Position">Position:</label>
    <input type="text" name="Position" value="<?php echo isset($Position) ? $Position : ''; ?>">
    <br><br>
     <label for="Department">Department:</label>
    <input type="text" name="Department" value="<?php echo isset($Department) ? $Department : ''; ?>">
    <br><br>

    <br><br>
    <input type="submit" name="up" value="Update">

  </form>
</body>
</html>

<?php
include('db_connection.php');

if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $Name = $_POST['Name'];
  $Position = $_POST['Position'];
  $Department = $_POST['Department'];
 

  // Update the employee in the database (prepared statement again for security)
  $stmt = $conn->prepare("UPDATE employee SET Name=?, Position=?,Department=?  WHERE employee_id=?");
  $stmt->bind_param("sssi", $Name, $Position,$Department,$employee_id);
  $stmt->execute();

  // Redirect to employee.php
  header('Location: employee.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($conn);
?>