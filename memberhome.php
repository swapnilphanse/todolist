<?php
session_start();
require('connection.php');

if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link href="assests/css/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>ToDo List</h1>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
        </nav>
       
		<div class="content">
            
        
			<p style="font-size:20px;weight:700"><?=strtoupper($_SESSION['name']) ?>'s Project List </p>


<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Project Name</th>
      <th scope="col">Estimated Hours</th>
      <th scope="col">Team Members</th>
      <th scope="col">Actions</th>
     
    </tr>
  </thead>
  <tbody>

  <?php

        $stmt = $con->prepare('SELECT project.project_id,project.project_name, tasks.hours, project.hours from project, tasks, users where users.id = tasks.eid AND project.project_id = tasks.pid AND users.username=?');
		$stmt->bind_param('s',$_SESSION['name']);
		$stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($project_id,$project_name,$hours,$hour);
        $i = 0;

        while( $stmt->fetch()) {

            $stm = $con->prepare("SELECT GROUP_CONCAT( DISTINCT users.username ORDER BY users.username ASC SEPARATOR ' , ') 
            from users,project,tasks where project.project_id=tasks.pid AND tasks.eid = users.id AND project.project_id=?");
            $stm->bind_param('i',$project_id);
            $stm->execute();
			$stm->store_result();
			$stm->bind_result($username);
            $stm->fetch();

    ?>


    <tr>
      <th scope="row"><?php echo ++$i ;?></th>
      <td><?php echo $project_name; ?> </td>
	  <td><?php 
			 $st = $con->prepare('SELECT COUNT(DISTINCT tasks.eid) from tasks where tasks.pid = ?');
			
			 $st->bind_param('i',$project_id);
			 $st->execute();
			 $st->bind_result($count);
			 $st->fetch();
			 

			 if($count > 1) {
				 echo $hour;
			 }
			 else {
				echo $hours;
			 }

			 $st->close();
	   ?> 
	   </td>
      <td><?php echo $username;  ?> </td>
     <td> <a href="details.php?p_id=<?php echo $project_id; ?>" class="btn btn-outline-primary">View Details</a> </td> 
    </tr>
   
 


  <?php 
           
               
           $stm->close();
        }

        $stmt->close();
  ?>
   </tbody>
</table>
</div>


<div class="modal fade" id="exampleModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
            
<form method="post" action="projectsubmit.php">
      <div class="modal-body">

  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="projecName">Project Name</label>
      <input type="text" class="form-control" name="pname">
    </div>

  <input type="submit" name = "addproject" class="btn btn-primary" value= "Add Project">

      </div>
      </form>
    
    </div>
  </div>
</div>












<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    
    </body>
</html>



