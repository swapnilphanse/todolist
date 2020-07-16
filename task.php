<?php

session_start();
require('connection.php');
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}


if(isset($_POST['taskname']) && isset($_POST['teammember']) && isset($_POST['estimatedhours']) && isset($_POST['submit'])) {


    if ($stmt = $con->prepare('SELECT taskname FROM tasks WHERE taskname = ? AND pid = ?' )) {
        // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
        $stmt->bind_param('si', $_POST['taskname'], $_POST['p_id']);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
         
            echo 'Project task  already exists. Please add another project task!';
        } else {
           
          
    if ($stmt = $con->prepare('INSERT INTO tasks (eid,pid,hours,taskname) VALUES (?,?,?,?)')) {
       
        $stmt->bind_param('iids', $_POST['teammember'],$_POST['p_id'],$_POST['estimatedhours'],$_POST['taskname']);

        if($stmt->execute()) {

            echo '<script>alert("Task added successfully !");location="home.php";</script>';
        }
        else {

            echo("Error description: " . mysqli_error($con));
        }
        
        } else {
    
        echo 'Could not prepare statement!';

        }
    }
        
        $stmt->close();

    } else {
       
        echo 'Could not prepare statement!';
    }
    
    $con->close();
    
    }
    else {
    
    
        echo "error";
    }

    ?>