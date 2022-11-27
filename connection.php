<?php
$mysqli = new mysqli("todolistapp.cxlwfzkypbrr.us-east-1.rds.amazonaws.com", "root", "Pwco202223!App", "projektpwco");

if ($mysqli->connect_error) {
  echo "Connection failed: " . $mysqli->connect_error;
  die("Connection failed: " . $mysqli->connect_error);
}
else{
    //echo "connected, hello world!!!!";
}

?>