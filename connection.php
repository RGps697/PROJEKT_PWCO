<?php
$mysqli = new mysqli("localhost", "root", "", "projektpwco");

if ($mysqli->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
else{
    echo "connected, hello world";
}

?>