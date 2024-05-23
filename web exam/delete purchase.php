<?php
include('db_connection.php');

// Check if Product_Id is set
if(isset($_REQUEST['purchaseorder_id'])) {
    $purchaseorder_id = $_REQUEST['purchaseorder_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $conn->prepare("DELETE FROM purchase WHERE purchaseorder_id=?");
    $stmt->bind_param("i", $purchaseorder_id);
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
            <input type="hidden" name="purchaseorder_id" value="<?php echo $purchaseorder_id; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($stmt->execute()) {
        echo "Record deleted successfully.<br><br>";
        echo "<a href='purchase.php'>OK</a>";    } else {
        echo "Error deleting data: " . $stmt->error;
    }
}
?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "purchaseorder_id is not set.";
}

$conn->close();
?>
