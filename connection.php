
<?php
$host="localhost";
$username="root";
$password="";
$database="Hotel_management";

$conn=mysqli_connect($host,$username,$password,$database);
if($conn->connect_error)
  {
    echo "Connection Failed:".$conn->connect_error;
  }

 ?>