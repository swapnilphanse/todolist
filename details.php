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
  <title>Add Tasks</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
  <link href="assests/css/style.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>

<body class="loggedin">
  <nav class="navtop">
    <div>
      <h1>ToDo List</h1>
      <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
  </nav>

  <div class="content">

    <div class="row">

      <?php 

$stmt= $con->prepare('SELECT project_name,hours from project where project_id=?');
$stmt->bind_param('i', $_GET['p_id']);
$stmt->execute();
$stmt->bind_result($pname,$hours);
$stmt->fetch();

?>

      <div class="col-md-6">
        <h1> <?php echo $pname;?></h1>
      </div>

      <div class="col-md-6">
        <h1 style="float:right"> <?php echo $hours." hours";?></h1>
      </div>
      <?php
    $stmt->close();
    ?>
      <div class="col-md-12">
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

    <script>
      function goBack() {
        window.history.back();
      }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
      integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
      integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>

</body>

</html>