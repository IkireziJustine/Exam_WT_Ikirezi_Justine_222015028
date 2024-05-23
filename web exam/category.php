<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <style>
        body {
            background-color: lightpink;
            font-family: Arial, sans-serif;
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
        <li><a href="contact.html">Contact</a></li>
        <li class="dropdown">
            <a href="#">Services</a>
            <div class="dropdown-contents">
                <a href="customers.php">Customers</a>
                <a href="product.php">Product</a>
                <a href="sales.php">Sales</a>
                <a href="purchase.php">Purchase</a>
                <a href="inventory.php">Inventory</a>
                <a href="warehouse.php">Warehouse</a>
                <a href="category.php">Category</a>
                <a href="employee.php">Employee</a>
                <a href="suppliers.php">Suppliers</a>
                <a href="transaction.php">Transaction</a>
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
<section class="content">
    <h1><u>Category Form</u></h1>
    <form method="post" onsubmit="return confirmInsert();">
        <label for="category_id">Category ID:</label>
        <input type="number" id="category_id" name="category_id"><br><br>

        <label for="Name">Name:</label>
        <input type="text" id="Name" name="Name" required><br><br>

        <label for="Description">Description:</label>
        <input type="text" id="Description" name="Description" required><br><br>

        <input type="submit" name="add" value="Insert">
    </form>

    <h2>Category List</h2>
    <table border="1">
        <tr>
            <th>Category ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
        // Include database connection
        include('db_connection.php');

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Prepare and bind the parameters
            $stmt = $conn->prepare("INSERT INTO category (category_id, Name, Description) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $category_id, $Name, $Description);

            // Set parameters and execute
            $category_id = $_POST['category_id'];
            $Name = $_POST['Name'];
            $Description = $_POST['Description'];

            // Execute the statement
            if ($stmt->execute()) {
                echo "New record has been added successfully";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }

        // Fetch and display category data
        $sql = "SELECT * FROM category";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['category_id'] . "</td>
                        <td>" . $row['Name'] . "</td>
                        <td>" . $row['Description'] . "</td>
                        <td><a href='delete category.php?category_id=" . $row['category_id'] . "'>Delete</a></td> 
                        <td><a href='update category.php?category_id=" . $row['category_id'] . "'>Update</a></td> 
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No data found</td></tr>";
        }

        // Close database connection
        $conn->close();
        ?>
    </table>
</section>
</body>
</html>
