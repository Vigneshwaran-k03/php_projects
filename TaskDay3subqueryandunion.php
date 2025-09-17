<?php
$servername = "localhost";
$username = "root";
$password="";
$database="school";
// Create a connection
$conn = new mysqli($servername, $username, $password, $database);
//connection check
if($conn->connect_error){
    die("Connection Failed Check the Connection" . $conn->connect_error);

}
// Function the display the result in table
function displaytable($result,$title){
    if($result->num_rows > 0){
        echo "<h3>$title</h3>";
        echo "<table border='2' cellpadding='5' cellspacing='0'>";
        echo"<tr>";
        //print colum headers
        while($field = $result->fetch_field()){
            echo"<th>" .$field->name. "</th>";
        }
        echo"</tr>";
        //print rows
        $result->data_seek(0);
        while($row = $result->fetch_assoc()){
            echo"<tr>";
            foreach($row as $data){
                echo"<td>" .$data. "</td>";

            }
            echo"</tr>";
        }
        echo"</table><br>";

    }else{
        echo"<h3>$title</h3><p> No data found</p>";
    }

}
//Sub Query Example 1
$sql1="SELECT * FROM students WHERE Std_id IN(Select Std_id FROM result WHERE Result='Pass')";
$result1=$conn->query($sql1);
displaytable($result1,"Sub Query Example 1 (Students who passed)");
//Sub Query Example 2
$sql2="SELECT*From students where Std_id in (Select Std_id from result where Std_id in (Select Std_id from subjects))";
$result2=$conn->query($sql2);
displaytable($result2,"Sub Query Example 2 (Students who have subjects)");
//Union Example
echo"<h3>Union Example</h3>";
$unionsql="SELECT Name,Age From students Where Std_id in(SELECT Std_id From result where Rank in(1,2,3)) UNION SELECT Mark,Result from result where Rank in(1,2,3)";
$unionresult=$conn->query($unionsql);
displaytable($unionresult,"Union of Students and Marks of Top 3 Rank Holders");
$unionsql1="SELECT * FROM students UNION SELECT * FROM students2";
$unionresult1=$conn->query($unionsql1);
displaytable($unionresult1,"Union of Students and Students2 Table");
$conn->close ();
?>
