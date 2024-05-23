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
    <h1>Purchase</h1>
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
 
<h1><u> Purchase Form </u></h1>
    <form method="post" onsubmit="return confirmInsert();">
            
        <label for="purchaseorder_id">Purchase Id:</label>
        <input type="number" id="purchaseorder_id" name="purchaseorder_id"><br><br>

        <label for="supplier_id">Supplier Id:</label>
        <input type="text" id="supplier_id" name="supplier_id" required><br><br>

        <label for="OrderDate">Date:</label>
        <input type="Date" id="OrderDate" name="OrderDate" required><br><br>

        <label for="Amount">Amount:</label>
        <input type="number" id="Amount" name="Amount" required><br><br>

        

        <input type="submit" name="add" value="Insert">
      

    </form>
</section>
</body>
</html>

<?php
include('db_connection.php');


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $conn->prepare("INSERT INTO purchase(purchaseorder_id, supplier_id, OrderDate, Amount) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $purchaseorder_id, $supplier_id, $OrderDate, $Amount);
    
    // Set parameters and execute
    $purchaseorder_id = $_POST['purchaseorder_id'];
    $supplier_id = $_POST['supplier_id'];
    $OrderDate = $_POST['OrderDate'];
    $Amount = $_POST['Amount'];
    
    if ($stmt->execute() === TRUE) {
        echo "New record has been added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// SQL query to fetch data from the Purchase table
$sql = "SELECT * FROM purchase";
$result = $conn->query($sql);
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
<body>
    <center><h2>Table of Purchases</h2></center>
    <table border="20">
        <tr>
            <th>purchaseorder_id</th>
            <th>supplier_id</th>
            <th>OrderDate</th>
            <th>Amount</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        include('db_connection.php');

        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row['purchaseorder_id'] . "</td>
                    <td>" . $row['supplier_id'] . "</td>
                    <td>" . $row['OrderDate'] . "</td>
                    <td>" . $row['Amount'] . "</td>
                    <td><a style='padding:4px' href='delete purchase.php?purchaseorder_id=" . $row['purchaseorder_id'] . "'>Delete</a></td> 
                    <td><a style='padding:4px' href='update purchase.php?purchaseorder_id=" . $row['purchaseorder_id'] . "'>Update</a></td> 
                </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No data found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
