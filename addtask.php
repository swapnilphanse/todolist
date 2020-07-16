<?php
session_start();
require('connection.php');
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
require_once ('head.php');
?>

       
		<div class="content">
            
            <h2 >Task Lists</h2>
        
            <form method="post" action="task.php">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Task Name</label>
      <input type="text" class="form-control" name="taskname" required>
    </div>

    <div class="form-group col-md-6">
      <label for="inputEmail4">Estimated Hours</label>
      <input type="number" step="0.5" class="form-control" name="estimatedhours" required>
    </div>
</div>
<input type="hidden" value="<?php echo $_GET['p_id']; ?>" name= "p_id">
<div class="form-row">
    <div class="form-group col-md-12">
      <label for="teammember">Member Name</label>
     <select name="teammember" class="form-control" required>
         <option selected value= ""> Select One </option>
   <?php
    
        $value = 2;
        $stmt = $con->prepare("SELECT id,username from users where admin = ?");
        $stmt->bind_param('i',$value);
        $stmt->execute();

        $stmt->bind_result($id,$username);
        
        while($stmt->fetch()) {
        
   ?>
   
         <option value="<?php echo $id;?>"> <?php echo $username; ?> </option>
    <?php
        }
     $stmt->close();
    ?>
    </select>
    </div>
    </div>
    <div class="form-row">
    <div class="col-md-12">
    <input type="submit"  name="submit"style="width:100%" class="btn btn-primary" value ="Save">
    </div>
    </div>
</form>

<div class="row">
    <div class="col-md-12">

    <h2 style="text-align:center"> Task List</h2>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Task Name</th>
      <th scope="col">Team Member</th>
      <th scope="col">Estimated Hours</th>
     
    </tr>
  </thead>
  <tbody>

  <?php
        $p =  $_GET['p_id'];
        $stmt1 = $con->prepare('SELECT taskname,tasks.hours,username from tasks,project,users where tasks.eid = users.id AND tasks.pid= project.project_id AND project.project_id =?');
        $stmt1->bind_param('i', $p);
        $stmt1->execute();

            $stmt1->bind_result($taskname,$hours,$username);
            $i = 0;
           while( $stmt1->fetch()) {

        ?>


    <tr>
      <th scope="row"><?php echo ++$i ;?></th>
      <td><?php echo $taskname; ?> </td>
      <td> <?php echo $username; ?> </td>
      <td> <?php echo $hours; ?> </td>
    </tr>
   
 


  <?php 
  
        }

        $stmt1->close();
  ?>
   </tbody>
</table>
<button onclick="goBack()" class="btn btn-outline-primary">Go Back</button>
    </div>
    </div> 

   
    </div>
    </div> 
<?php require_once ('footer.php'); ?>