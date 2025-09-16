<?php 
// Database Connection 
$servername = "localhost";
$username = "root";
$password = "";
$database = "school";

// Create Connection
$conn = new mysqli($servername,$username,$password,$database);

// check connection
if ($conn->connect_error){
    die("Connection failed" . $conn->connect_error);
}

//Fetch DATA 

$sql = "SELECT * FROM Students";
$result = $conn->query($sql);

//Student Table

if($result->num_rows > 0){
   echo "<h2>Student Table</h2>";
   echo "<table border = '1' cellpaddinf='10' style='margin-top:30px;'>";
   echo "<tr><th>ID</th><th>Name</th><th>Age</th><th>Address</th></tr>";
   
   while($row = $result->fetch_assoc()){
        echo "<tr>";
        echo "<td>" . $row["Std_id"]."</td>";
        echo "<td>" .$row["Name"]."</td>";
        echo "<td>" .$row["Age"]."</td>";
        echo "<td>" .$row["Adress"]. "</td>";
        echo "</tr>";
   }
  echo "</table><br><br>"; 
 
} else{
   echo "NO RECORDS FOUND!!!";
}
$sql = "SELECT * FROM Subjects";
$result = $conn->query($sql);

//display data in HTML table

if($result->num_rows > 0){
   echo "<h2>Subjects Table</h2>";
   echo "<table border = '1' cellpaddinf='10' style='margin-top:30px;'>";
   echo "<tr><th>ID</th><th>Subject1</th><th>Subject2</th><th>Subject3</th></tr>";
   
   while($row = $result->fetch_assoc()){
        echo "<tr>";
        echo "<td>" . $row["Std_id"]."</td>";
        echo "<td>" .$row["sub1"]."</td>";
        echo "<td>" .$row["sub2"]."</td>";
        echo "<td>" .$row["sub3"]. "</td>";
        echo "</tr>";
   }
  echo "</table><br><br>"; 
 
} else{
   echo "NO RECORDS FOUND!!!";
}
//INNER Join

$sql1 = "SELECT *,CONCAT_WS(',', sub.sub1,sub.sub2,sub.sub3) AS Languages FROM Students s INNER JOIN Subjects sub ON s.Std_id = sub.Std_id ORDER BY s.Std_id";

$result1 = $conn->query($sql1);

if ($result1->num_rows >0){
    echo "<h2>INNER JOIN</h2>";
    echo "<table border='1' cellpadding='10' cellspacing='0' style='margin-top:30px;'>
          <tr>
            <th>Std_id</th>
            <th>Name</th>
            <th>Languages</th>
            <th>Age</th>
            <th>Adress</th>
          </tr>"; 
    while ($row1 = $result1->fetch_assoc()) {
        echo "<tr>
                <td>" . $row1["Std_id"] . "</td>
                <td>" . $row1["Name"] . "</td>
                <td>" . ($row1["Languages"]? $row1["Languages"] : "---") . "</td>
                <td>" . $row1["Age"] . "</td>
                <td>" . $row1["Adress"] . "</td>
            </tr>";
    }
    echo "</table><br><br>"; 

}else {
    echo "NO RECORD FOUND";}
//Left Join

$sql2 = "SELECT *,CONCAT_WS(',', sub.sub1,sub.sub2,sub.sub3) AS Languages FROM Students s LEFT JOIN Subjects sub ON s.Std_id = sub.Std_id ORDER BY s.Std_id";

$result2 = $conn->query($sql2);

if ($result2->num_rows >0){
   echo "<h2>LEFT JOIN</h2>";
    echo "<table border='1' cellpadding='10' cellspacing='0' style='margin-top:30px;'>
          <tr>
            <th>Std_id</th>
            <th>Name</th>
            <th>Languages</th>
            <th>Age</th>
            <th>Adress</th>
          </tr>"; 
    while ($row2 = $result2->fetch_assoc()) {
        echo "<tr>
                <td>" . $row2["Std_id"] . "</td>
                <td>" . $row2["Name"] . "</td>
                <td>" . ($row2["Languages"]? $row2["Languages"] : "---") . "</td>
                <td>" . $row2["Age"] . "</td>
                <td>" . $row2["Adress"] . "</td>
            </tr>";
    }
    echo "</table>"; 

}else {
    echo "NO RECORD FOUND";}
$conn->close();
?>
