<?php

include "connection.php";


$taskId = htmlspecialchars($_POST['id'], ENT_QUOTES);
$taskDesc = htmlspecialchars($_POST['task'], ENT_QUOTES);

if(isset($_POST['add'])){
    $stmt = $mysqli->query("INSERT INTO tasks (taskDesc) VALUES('$taskDesc')");
}
else if(isset($_POST['delete'])){
	$stmt = $mysqli->query("DELETE FROM tasks WHERE id = '$taskId'");  
}
else if(isset($_POST['update'])){
    $stmt = $mysqli->query("UPDATE tasks SET taskDesc='$taskDesc' WHERE id='$taskId'");
}

$mysqli->close();

?>