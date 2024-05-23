<?php
include('db_connection.php');

// Check if Product_Id is set
if(isset($_REQUEST['supplier_id'])) {
    $supplier_id = $_REQUEST['supplier_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $conn->prepare("DELETE FROM suppliers WHERE supplier_id=?");
    $stmt->bind_param("i", $supplier_id);
     ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Record</title>
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this record?");
            }
        </script>
    </head>
    <body>
        <form method="post" onsubmit="return confirmDelete();">
            <input type="hidden" name="supplier_id" value="<?php echo $supplier_id; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($stmt->execute()) {
        echo "Record deleted successfully.<br><br>";
        echo "<a href='suppliers.php'>OK</a>";
    } else {
        echo "Error deleting data: " . $stmt->error;
    }
}
?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "supplier_id is not set.";
}

$conn->close();
?>
