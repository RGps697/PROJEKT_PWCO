<?php

include "connection.php";

?>

<html>
    <head>
    
    </head> 

    <body>
        <br/>

        <form method="post" action="taskOperation.php">
        <label>Nowe zadanie:</label><br/>
        <input type="text" name="task"></input><br />
        <input type="submit" name="add" value="Dodaj"></input><br/>
        <label>Id:</label><br/>
        <input type="text" name="id"></input><br />
        <input type="submit" name="delete" value="Usuń"></input>
        <input type="submit" name="update" value="Edytuj"></input>
        </form>

        <?php
        $stmt = $mysqli->query("SELECT tasks.id, tasks.taskDesc FROM tasks");

        echo('<table><tr><th>ID</th><th>Opis</th></tr>');
        while($row = $stmt->fetch_assoc()){
            echo('<tr><td>' . $row['id'] . '</td><td>' . $row['taskDesc'] . '</td></tr>');
        }
        echo('</table><br />');

        ?>
    </body>


</html>




