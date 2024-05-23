<?php
include('db_connection.php');

// Check if the query parameter is set
if (isset($_GET['query'])) {
    // Sanitize input to prevent SQL injection
    $searchTerm = $conn->real_escape_string($_GET['query']);

    // Queries for different tables
    $queries = [
        'category' => "SELECT Name FROM category WHERE Name LIKE '%$searchTerm%'",
        'customers' => "SELECT customer_id FROM customers WHERE customer_id LIKE '%$searchTerm%'",
        'employee' => "SELECT Position FROM employee WHERE Position LIKE '%$searchTerm%'",
        'inventory' => "SELECT quantity FROM inventory WHERE quantity LIKE '%$searchTerm%'",
        'product' => "SELECT price FROM product WHERE price LIKE '%$searchTerm%'",
        'purchase' => "SELECT Amount FROM purchase WHERE Amount LIKE '%$searchTerm%'",
        'sales' => "SELECT sales_id FROM sales WHERE sales_id LIKE '%$searchTerm%'",
        'suppliers' => "SELECT address FROM suppliers WHERE address LIKE '%$searchTerm%'",
        'transaction' => "SELECT type FROM transaction WHERE type LIKE '%$searchTerm%'",
        'warehouse' => "SELECT capacity FROM warehouse WHERE capacity LIKE '%$searchTerm%'",
    ];

    // Output search results
    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $result = $conn->query($sql);
        echo "<h3>Table of $table:</h3>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . $row[array_keys($row)[0]] . "</p>"; // Dynamic field extraction from result
            }
        } else {
            echo "<p>No results found in $table matching the search term: '$searchTerm'</p>";
        }
    }

    // Close the connection
    $conn->close();
} else {
    echo "<p>No search term was provided.</p>";
}
?>


