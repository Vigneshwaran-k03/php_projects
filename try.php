<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "ecommerce";  // your DB name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to display results in table
function displayTable($result, $title) {
    if ($result->num_rows > 0) {
        echo "<h3>$title</h3>";
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr>";
        // Print column headers
        while ($field = $result->fetch_field()) {
            echo "<th>" . $field->name . "</th>";
        }
        echo "</tr>";

        // Print rows
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $data) {
                echo "<td>" . $data . "</td>";
            }
            echo "</tr>";
        }
        echo "</table><br>";
    } else {
        echo "<h3>$title</h3><p>No records found.</p>";
    }
}

// 1. WHERE Example - Paid Orders
$whereQuery = "SELECT * FROM ecommerce WHERE Order_status = 'Paid'";
$whereResult = $conn->query($whereQuery);
displayTable($whereResult, "WHERE Example (Paid Orders)");

// 2. ORDER BY Example - sort by Amount DESC
$orderQuery = "SELECT * FROM ecommerce ORDER BY Amount DESC";
$orderResult = $conn->query($orderQuery);
displayTable($orderResult, "ORDER BY Example (Amount DESC)");

// 3. LIKE Example - city starts with 'S'
$likeQuery = "SELECT * FROM ecommerce WHERE Name LIKE 'Ra%'";
$likeResult = $conn->query($likeQuery);
displayTable($likeResult, "LIKE Example (Name starts with 'Ra')");

// 4. Aggregate Functions
$aggQuery = "SELECT 
                SUM(Amount) AS TotalAmount,
                AVG(Amount) AS AverageAmount,
                MIN(Amount) AS MinAmount,
                MAX(Amount) AS MaxAmount,
                COUNT(*) AS TotalOrders
             FROM ecommerce";
$aggResult = $conn->query($aggQuery);
displayTable($aggResult, "Aggregate Functions");

$conn->close();
?>
