<?php
require ('connection.php');

if ( !isset($_POST['username'], $_POST['password']) ) {
	
	exit('Please fill both the username and password fields!');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT id, password, admin FROM users WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password, $admin);
        $stmt->fetch();
        
        if (password_verify($_POST['password'], $password)) {
            session_start();
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;

            if($admin == 1) {
                
            header('Location: home.php');
            } else {
                header('Location: memberhome.php');
            }
        } else {
            echo '<script>alert("Incorrect Password !");location="index.html";</script>';
        }
    } else {
        echo '<script>alert("Incorrect Username !");location="index.html";</script>';
    }
	$stmt->close();
}
?>