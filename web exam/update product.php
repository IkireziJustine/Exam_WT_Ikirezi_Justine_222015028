<?php
include('db_connection.php');

// Check if Product_Id is set
if (isset($_REQUEST['product_id'])) {
  $product_id = $_REQUEST['product_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $conn->prepare("SELECT * FROM product WHERE product_id=?");
  $stmt->bind_param("i", $product_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $product_id = $row['product_id'];
    $name = $row['name'];
    $price = $row['price'];
    $quantity = $row['quantity'];
    $category_id = $row['category_id'];
  } else {
    echo "Product not found.";
  }
}

$stmt->close(); // Close the statement after use

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update products</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update products form -->
    <h2><u>Update Form of products</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    <label for="name">Product Name:</label>
    <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
    <br><br>

    <label for="price">Price:</label>
    <input type="number" name="price" value="<?php echo isset($price) ? $price : ''; ?>">
    <br><br>
     <label for="quantity">quantity:</label>
    <input type="number" name="quantity" value="<?php echo isset($quantity) ? $quantity : ''; ?>">
    <br><br>

    <label for="category_id">Category:</label>
    <input type="text" name="category_id" value="<?php echo isset($category_id) ? $category_id : ''; ?>">
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
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];
  $category_id = $_POST['category_id'];

  // Update the product in the database (prepared statement again for security)
  $stmt = $conn->prepare("UPDATE product SET name=?, price=?,quantity=?, category_id=? WHERE product_id=?");
  $stmt->bind_param("ssdii", $name, $price,$quantity, $category_id, $product_id);
  $stmt->execute();

  // Redirect to product.php
  header('Location: product.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($conn);
?>