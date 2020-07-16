<?php
// session_start();
require('connection.php');
// if (!isset($_SESSION['loggedin'])) {
// 	header('Location: index.html');
// 	exit;
// }

if(isset($_POST['addproject']) && isset($_POST['pname'])) {


   if ($stmt = $con->prepare('SELECT project_name FROM project WHERE project_name = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['pname']);
	$stmt->execute();
	$stmt->store_result();
	
	if ($stmt->num_rows > 0) {
		// Username already exists
		echo 'Project aldready exists. Please add another project name!';
	} else {
		// Username doesnt exists, insert new account
if ($stmt = $con->prepare('INSERT INTO project (project_name) VALUES (?)')) {
	// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
	$stmt->bind_param('s', $_POST['pname']);
    $stmt->execute();
    
	echo '<script>alert("Project successfully !");location="home.php";</script>';'';
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

    echo "Wrong Page";
}
?>