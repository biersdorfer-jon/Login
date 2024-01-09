<?php
require 'openConnection.php';
session_start();

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Check the connection  
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user inputs
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user data from the database based on the provided username
    $stmt = $conn->prepare("SELECT studentid, fname, lname, password FROM tblstudents WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($studentid, $fname, $lname, $storedPassword);
    $stmt->fetch();
    $stmt->close();

    // Check if a user with the given username exists
    if ($storedPassword !== null) {
        // Verify the entered password against the stored password
        if ($password === $storedPassword) {
            // Passwords match, set session variables and redirect to home page
			$_SESSION['studentid'] = $studentid;
			$_SESSION['username'] = $username;
            $_SESSION['fname'] = $fname; // Optionally, store other user information in session
            $_SESSION['lname'] = $lname;

            // Redirect to home page
            header("Location: addRegistrationForm.php");
            exit();
        } else {
            // Passwords do not match
            //echo "Invalid password";
        }
    } else {
        // User with the given username does not exist
        //echo "User not found";
    }
    
    // Close the connection
    $conn->close();
}



?>
<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset="utf-8">
		<title>Login Page</title>
		<link rel = "stylesheet" href = "registration.css">
	</head>
	<body bgcolor="#f3f3f3">
		<header>
			<h1>Login Page</h1>
		</header>
		
		<nav>
			<a href = "signInForm.php">Sign In</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href = "loginForm.php">Login</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href = "addRegistrationForm.php">Registration</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href = "cancelRegistrationForm.php">Cancel Registration</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href = "courseList.php">Course List</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href = "addCourseForm.php">Add New Course</a>&nbsp;&nbsp;&nbsp;&nbsp;
		</nav>
		
		<main>
			<form name = "signIn" action = "" method = "POST">
				Enter Username: <input type = "text" name = "username" required = "required" > <br><br>
				Enter Password: <input type = "password" name = "password" required = "required" ><br><br>
				<input type = "submit" name = "submit" value = "Login" >
				<div>
				<?php
                           if (isset($_POST['submit'])) {
// Check if a user with the given email exists
if ($storedPassword !== null) {
	// Verify the entered password against the stored password
	if (password_verify($password, $storedPassword)) {
		// Passwords match, set session variables and redirect to home page
		$_SESSION['studentid'] = $studentid;
		$_SESSION['username'] = $username;
		$_SESSION['fname'] = $fname; // Optionally, store other user information in session
		$_SESSION['lname'] = $lname;

		// Redirect to home page
		header("Location: addRegistrationForm.php");
		exit();
	} else {
		// Passwords do not match
		echo "Invalid password";
	}
} else {
	// User with the given username does not exist
	echo "The username is not found. Use the Sign In page to create a student account.";
}
}
                           ?>
				</div>
			</form>
		</main>
		
		<footer>
		
			<div id="copyright">
			
				<!-- Replace the flastin the anchor element with your first initial and last name.
					 -->
				<a mailto:flast@student.edu>JB@student.edu</a>
			</div>
		
		</footer>
	</body>
</html>