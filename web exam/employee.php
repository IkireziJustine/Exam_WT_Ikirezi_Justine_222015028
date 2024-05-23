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
<body>
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
  <h1><u>Employee form</u></h1>
  <form method="post" onsubmit="return confirmInsert();">
    <label for="employee_id">Employee ID:</label>
    <input type="number" id="employee_id" name="employee_id"><br><br>

    <label for="Name">Name:</label>
    <input type="text" id="Name" name="Name" required><br><br>

    <label for="Position">Position:</label>
    <input type="text" id="Position" name="Position" required><br><br>

    <label for="Department">Department:</label>
    <input type="text" id="Department" name="Department" required><br><br>

    <input type="submit" name="add" value="Insert">
  </form>

  <?php
  // Database connection parameters
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $conn->prepare("INSERT INTO employee(employee_id, Name, Position, Department) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $employee_id, $Name, $Position, $Department);
    
    // Set parameters and execute
    $employee_id = $_POST['employee_id'];
    $Name = $_POST['Name'];
    $Position = $_POST['Position'];
    $Department=$_POST['Department'];
    
    if ($stmt->execute() === TRUE) {
        echo "New record has been added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// SQL query to fetch data from the Product table
$sql = "SELECT * FROM employee";
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
  <h2>Employee</h2>
  <table border="20">
    <tr>
      <th>employee_id</th>
      <th>Name</th>
      <th>Position</th>
      <th>Department</th>
      <th>Delete</th>
      <th>Update</th>
    </tr>
    <?php
include('db_connection.php');




    $sql = "SELECT * FROM employee";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $employee_id = $row['employee_id'];
            echo "<tr>
                <td>" . $row['employee_id'] . "</td>
                <td>" . $row['Name'] . "</td>
                <td>" . $row['Position'] . "</td>
                <td>" . $row['Department'] . "</td>
                <td><a href='delete employee.php?employee_id=$employee_id'>Delete</a></td> 
                <td><a href='update employee.php?employee_id=$employee_id'>Update</a></td> 
              </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No data found</td></tr>";
    }
    $conn->close();
    ?>
  </table>
</section>
</body>
</html>
