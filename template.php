<!-- Student name:                    -->
<!-- Due date:                        -->

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
			<form name = "signIn" action = "signIn.php" method = "POST">
				Enter Username: <input type = "text" name = "username" required = "required" > <br><br>
				Enter Password: <input type = "password" name = "password" required = "required" ><br><br>
				<input type = "submit" name = "submit" value = "Login" >
			</form>
		</main>
		
		<footer>
		
			<div id="copyright">
			
				<!-- Replace the flastin the anchor element with your first initial and last name.
					 -->
				<a mailto:flast@student.edu>flast@student.edu</a>
			</div>
		
		</footer>
	</body>
</html>