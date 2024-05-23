<?php
// Database credentials
include('db_connection.php');

// Handling POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieving form data and sanitizing inputs
    $fname  = $conn->real_escape_string($_POST['fname']);
    $lname = $conn->real_escape_string($_POST['lname']);
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    $telephone = $conn->real_escape_string($_POST['telephone']);
    $password = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_DEFAULT);
    $activation_code = $conn->real_escape_string($_POST['activation_code']);
    
    // Preparing SQL query with placeholders
    $sql = "INSERT INTO users (first_name,last_name, email, username, password, telephone, activation_code) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    // Creating prepared statement
    $stmt = $conn->prepare($sql);
    
    // Binding parameters
    $stmt->bind_param("sssssss", $fname, $lname, $email, $username, $password, $telephone, $activation_code);
    
    // Executing prepared statement
    if ($stmt->execute()) {
        // Redirecting to login page on successful registration
        header("Location: login.html");
        exit();
    } else {
        // Displaying error message if query execution fails
        echo "Error: " . $stmt->error;
    }
    
    // Closing prepared statement
    $stmt->close();
}

// Closing database connection
$conn->close();
?>
