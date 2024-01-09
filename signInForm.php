<?php
session_start(); 

require 'openConnection.php';

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user inputs (replace these with your actual form field names)
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Check if the username already exists
    $checkStmt = $conn->prepare("SELECT username FROM tblstudents WHERE username = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        //echo "Username already exists. Please choose a different username.";
    } else {
        // Username is unique, proceed with registration

        // Prepare and execute SQL statement
        $stmt = $conn->prepare("INSERT INTO tblstudents (fname, lname, username, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fname, $lname, $username, $password);

        if ($stmt->execute()) {
            header("Location: loginForm.php"); // Redirect to login page upon successful registration
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset="utf-8">
		<title>Sign In Page</title>
		<link rel = "stylesheet" href = "registration.css">
	</head>
	<body bgcolor="#f3f3f3">
		<header>
			<h1>Sign In Page</h1>
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
			<form name = "login" action = "" method = "post">
				First Name: <input type = "text" name = "fname" required = "required" > <br><br>
				Last Name: <input type = "text" name = "lname" required = "required" ><br><br>
				Enter Username: <input type = "text" name = "username" required = "required" > <br><br>
				Enter Password: <input type = "password" name = "password" required = "required" ><br><br>
				<?php

if (isset($_POST['submit'])) {
				if ($checkStmt->num_rows > 0) {
        echo "Username already exists. Please choose a different username.";
    } else {
        // Username is unique, proceed with registration

        // Prepare and execute SQL statement
        $stmt = $conn->prepare("INSERT INTO tblstudents (fname, lname, username, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fname, $lname, $username, $password);

        if ($stmt->execute()) {
            header("Location: loginForm.php"); // Redirect to login page upon successful registration
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
		
		$checkStmt->close();
        $stmt->close();
    }
}echo "<br><br>"
		?>
		
				<input type = "submit" name = "submit" value = "Sign In" >
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