<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tables</title>
    <style>

        body {
            background-color:lightpink;
            font-family: Arial, algerian;
            margin: 0;
            padding: 0;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #333; /* Dark gray header background */
            border-bottom: 5px solid #555; /* Darker gray border */
        }
        .logo {
            width: 60px;
            height: auto;
        }
        .navigation {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: none;
            flex-grow: 2; 
        }
        .navigation li {
            display: inline-block;
            margin-right: 5px;
            padding: 5px;
        }
        .navigation li:last-child {
            margin-right: 0;
        }
        .navigation li a {
            text-decoration: none;
            color: #fff; /* White text */
        }
        .dropdown-contents {
            display: none;
            position: absolute;
            background-color: mediumvioletred; 
            text-decoration: none;
        }
        .dropdown-contents a {
            color: mediumvioletred; /* Dark gray dropdown text */
            text-decoration: none;
            display: block;
        }
        .dropdown-contents a:hover {
            background-color: blueviolet; 
        }
        .dropdown:hover .dropdown-contents {
            display: block;
        }
        .content {
            padding: 20px;
        }
        footer {
            background-color: #333; /* Dark gray footer background */
            text-align: center; 
            width: 100%; 
            height: 90px; 
            color: #fff; /* White footer text */
            font-size: 25px; 
            margin-top: 20px; 
            bottom: 0; 
            left: 0;
            position: fixed;
        }
    </style>
    <script>
        function confirmInsert() {
            return confirm('Are you ready to insert this record?');
        }
    </script>
</head>
    <body style="background-image: url('./Images/Goal.jpg');background-repeat: no-repeat;background-size:cover;">
  <!-- Header section -->
  <header>
    <h1>Sales</h1>
  </header>
  <!-- Search form -->
  <form class="d-flex" role="search" action="search.php">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
    <button class="btn btn-outline-success" type="submit">Search</button>
  </form>
<div class="header">
    <img class="logo" src="tt.png" alt="Logo">
    <h3><i>Inventory Management System For Retail</i></h3>
    <ul class="navigation">
        <li><a href="home.html">Home</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="contact.html">Contact </a></li>
        </li>
        <li class="dropdown">
            <a href="#">Services</a>
            <div class="dropdown-contents">
                <a href="customers.php">customers</a>
                <a href="product.php">product</a>
                <a href="sales.php">sales</a>
                <a href="purchase.php">purchase</a>
                <a href="inventory.php">inventory</a>
                <a href="warehouse.php">warehouse</a>
                <a href="category.php">category</a>
                <a href="employee.php">employee</a>
                <a href="suppliers.php">suppliers</a>
                <a href="transaction.php">transaction</a>
            </div>
        </li>
        <li class="dropdown">
            <a href="#">Settings</a>
            <div class="dropdown-contents">
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
                <a href="logout.php">Logout</a>
            </div>
        </li>
    </ul>
</div>
<section>
  <h1><u>Sales form</u></h1>
  <form method="post" onsubmit="return confirmInsert();">
    <label for="sales_id">Sales ID:</label>
    <input type="number" id="sales_id" name="sales_id"><br><br>

    <label for="customer_id">Customer ID:</label>
    <input type="number" id="customer_id" name="customer_id" required><br><br>

    <label for="Date">Date:</label>
    <input type="Date" id="Date" name="Date" required><br><br>

    <label for="Amount">Amount:</label>
    <input type="number" id="Amount" name="Amount" required><br><br>

    <input type="submit" name="add" value="Insert">
  </form>

  <?php
 // Database connection parameters
include('db_connection.php');




// Close connection


  // Check if the form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Prepare and bind the parameters
      $stmt = $conn->prepare("INSERT INTO sales( customer_id, Date , Amount) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $customer_id, $Date, $Amount);

      // Set parameters and execute
      $customer_id = $_POST['customer_id'];
      $Date = $_POST['Date'];
      $Amount = $_POST['Amount'];

      if ($stmt->execute() == TRUE) {
          echo "New record has been added successfully";
      } else {
          echo "Error: " . $stmt->error;
      }
      $stmt->close();
       $conn->close();
  }
 
  ?>
 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail information Of Products</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
  <h2>Sales</h2>
  <table border="20">
    <tr>
      <th>sales_id</th>
      <th>customer_id</th>
      <th>Date</th>
      <th>Amount</th>
      <th>Delete</th>
      <th>Update</th>
    </tr>
    <?php
include('db_connection.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo "Connected successfully";

// Close connection
$conn->close();
}




    $sql = "SELECT * FROM sales";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sales_id = $row['sales_id'];
            echo "<tr>
                <td>" . $row['sales_id'] . "</td>
                <td>" . $row['customer_id'] . "</td>
                <td>" . $row['Date'] . "</td>
                <td>" . $row['Amount'] . "</td>
                <td><a href='delete sales.php?sales_id=$sales_id'>Delete</a></td> 
                <td><a href='update sales.php?sales_id=$sales_id'>Update</a></td> 
              </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No data found</td></tr>";
    }
  
    ?>
  </table>
</section>



</body>
</html>