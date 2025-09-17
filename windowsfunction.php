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
//Row_number() function example
echo"<h3> Window Function (Partition by Result and order by Mark)</h3>";
$sql="SELECT *,ROW_NUMBER() OVER(PARTITION BY Result ORDER BY Mark Asc) AS ROWNUMBER FROM result";
$result=$conn->query($sql);
displaytable($result,"Row_Number() Function Example ");
//Rank and Dense Rank Function example
$sql1="SELECT *,RANK() OVER(PARTITION BY Result ORDER by Mark DESC) AS rank,DENSE_RANK() over(PARTITION BY Result ORDER BY MARK DESC)AS denserank FROM result";
$result1=$conn->query($sql1);
displaytable($result1,"Rank and Dense RANK Function Example");
//Aggregate Function Example
$sql2="SELECT *,SUM(Mark) OVer(PARTITION BY Result) AS sum , AVG(Mark) OVER(PARTITION BY Result)AS Avg,MIN(Mark) over(PARTITION BY Result)AS Min,MAX(Mark)Over(PARTITION BY Result)AS Max FROM result";
$result2=$conn->query($sql2);            
displaytable($result2,"Aggregate Function Example");
//Running Total Example
$sql3="SELECT *,SUM(Mark) OVer(PARTITION BY Result Order by Std_id) AS sum , AVG(Mark) OVER(PARTITION BY Result ORDER BY Std_id)AS Avg,MIN(Mark) over(PARTITION BY Result ORDER BY Std_id)AS Min,MAX(Mark)Over(PARTITION BY Result ORDER by Std_id)AS Max FROM result";
$result3=$conn->query($sql3);            
displaytable($result3,"Running Function Example");
//Lad and Lead Function Example
$sql4="SELECT *,LEAD(Mark) OVER(PARTITION BY Result ORDER BY Mark) AS Lead, LAG(Mark) OVER(PARTITION BY Result ORDER BY Mark) AS Lag FROM result";
$result4=$conn->query($sql4);            
displaytable($result4,"Lad and Lead Function Example");
//NTILE Function Example
$sql5="SELECT *,NTILE(2) OVER(PARTITION BY Result ORDER BY Mark DESC) AS Ntile FROM result";
$result5=$conn->query($sql5);            
displaytable($result5,"NTILE Function Example");
$conn->close ();
?>