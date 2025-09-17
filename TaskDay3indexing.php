<?php
$servername="localhost";
$username="root";
$password="";
$database="ecommerce";
// create connection
$conn= new mysqli($servername,$username,$password,$database);
// connection check 
if($conn->connect_error){
    die("Connection Failed".$conn->connect_error);
}
//fuction to display a result as table formate
function disply($result,$title){
    if($result->num_rows>0){
        echo"<h3>$title</h3>";
        echo"<table border='3' cellpadding='5' cellspacing='0'>";
        echo"<tr>";
        //print column headers
        while($field=$result->fetch_field()){
            echo"<th>".$field->name."</th>";
        }
        echo"</tr>";
        //row printing
        $result->data_seek(0);
        while($row=$result->fetch_assoc()){
            echo"<tr>";
            foreach($row as $data){
                echo"<td>".$data."</td>";    
            }
            echo"</tr>";

        }"</table><br>";
    }else{
        echo"<h3>$title</h3><p>No data found</p>";
    }
}
//indexing 
$sql="SELECT * FROM employee WHERE deprtment='MECH'";
$result=$conn->query($sql);
disply($result,"MECH EMPLOYEES");
$sql1="SELECT COUNT(*) FROM employee WHERE deprtment='MECH'";
$result=$conn->query($sql1);
disply($result,"COUNT OF MECH EPLOYEES");
?>
