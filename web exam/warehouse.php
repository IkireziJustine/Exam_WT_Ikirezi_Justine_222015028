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
        /* Table style */
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
      background-color: #f2f2f2;
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
    <h1>Warehouse</h1>
  </header>
  <!-- Search form -->
  <form class="d-flex" role="search" action="search.php">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
    <button class="btn btn-outline-success" type="submit">Search</button>
  </form>
<div class="header">
    <img class="logo" src="tt.png" alt="Logo">
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
    </header>

    <section>
        <h1><u>Warehouse Form</u></h1>
        <form method="post" onsubmit="return confirmInsert();">
            <label for="warehouse_id">Warehouse ID:</label>
            <input type="number" id="warehouse_id" name="warehouse_id"><br><br>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required><br><br>

            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" required><br><br>

            <input type="submit" name="add" value="Insert">
        </form>

        <?php
        // Database connection
        include('db_connection.php');

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Prepare and bind the parameters
            $stmt = $conn->prepare("INSERT INTO warehouse(warehouse_id, location, capacity) VALUES (?, ?, ?)");

            // Check if warehouse_id already exists
            $warehouse_id = $_POST['warehouse_id'];
            $stmt_check = $conn->prepare("SELECT * FROM warehouse WHERE warehouse_id = ?");
            $stmt_check->bind_param("i", $warehouse_id);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                echo "Error: Warehouse ID already exists.";
            } else {
                // Set parameters and execute
                $location = $_POST['location'];
                $capacity = $_POST['capacity'];
                $stmt->bind_param("iss", $warehouse_id, $location, $capacity);

                if ($stmt->execute() === TRUE) {
                    echo "New record has been added successfully";
                } else {
                    echo "Error: " . $stmt->error;
                }
            }

            $stmt->close();
            $stmt_check->close();
        }
        ?>

        <h2>Warehouse Data</h2>
        <table border="1">
            <tr>
                <th>Warehouse ID</th>
                <th>Location</th>
                <th>Capacity</th>
                <th>Delete</th>
                <th>Update</th>
            </tr>
            <?php
            // Database connection
            include('db_connection.php');

            // Fetch and display warehouse data
            $sql = "SELECT * FROM warehouse";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $warehouse_id = $row['warehouse_id'];
                    echo "<tr>
                            <td>" . $row['warehouse_id'] . "</td>
                            <td>" . $row['location'] . "</td>
                            <td>" . $row['capacity'] . "</td>
                            <td><a href='delete warehouse.php?warehouse_id=$warehouse_id'>Delete</a></td> 
                            <td><a href='update warehouse.php?warehouse_id=$warehouse_id'>Update</a></td> 
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No data found</td></tr>";
            }

            $conn->close();
            ?>
        </table>
    </section>
</body>
</html>
