<!-- Student name:                    -->
<!-- Due date:                        -->

<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset="utf-8">
		<title>Add New Course</title>
		<link rel = "stylesheet" href = "registration.css">
	</head>
	<body bgcolor="#f3f3f3">
		<header>
			<h1>Add New Course</h1>
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
		
		<form name = "frmAddCourse" action = "addCourse.php" method = "post">
			<p>
				<label for "coursecode">Course Code:</label>
				<input type = "text" name = "coursecode" id="coursecode" required = "required" > 
			</p>
			
			<p>
				<label for "coursename">Course Name:</label>
				<input type = "text" name = "coursename" id="coursename" required = "required" > 
			</p>
			
			<p>
				<label for "capacity">Capacity:</label>
				<input type = "text" name = "capacity" id="capacity" required = "required" > 
			</p>
						
			<input style="margin-left:80px" type = "submit" name = "submit" value = "Add Course" >
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
	
	
	
	
	
	
	
	
	
	
	
	