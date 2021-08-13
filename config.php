<?php
$server = "localhost";
$user = "root";
$password = "";
$dbname = "mydb";

$conn = mysqli_connect($server,$user,$password,$dbname);

if(!$conn){
    die("Could not connect to the database" . mysqli_connect_error());
}
else{
    
}
?>