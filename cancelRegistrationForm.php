<?php
session_start();

require 'openConnection.php';

// Check if the form is submitted  
if (isset($_POST['cancel'])) {
    // Get the selected courses to cancel
    $coursesToCancel = isset($_POST['cancel_course']) ? $_POST['cancel_course'] : [];

    foreach ($coursesToCancel as $courseId) {
        // Fetch course information before deletion
        $courseInfoStmt = $conn->prepare("SELECT coursename FROM tblcourses WHERE courseid = ?");
        $courseInfoStmt->bind_param("i", $courseId);
        $courseInfoStmt->execute();
        $courseInfoStmt->bind_result($coursename);
        $courseInfoStmt->fetch();
        $courseInfoStmt->close();

        // Remove the registration record
        $cancelStmt = $conn->prepare("DELETE FROM tblregistration WHERE studentid = ? AND courseid = ?");
        $cancelStmt->bind_param("ii", $_SESSION['studentid'], $courseId);

        if ($cancelStmt->execute()) {
            echo "Cancellation successful for course: $coursename<br>";
        } else {
            echo "Error canceling registration: " . $cancelStmt->error . "<br>";
        }

        $cancelStmt->close();

        // Increase capacity in tblcourses
        $increaseCapacityStmt = $conn->prepare("UPDATE tblcourses SET capacity = capacity + 1 WHERE courseid = ?");
        $increaseCapacityStmt->bind_param("i", $courseId);

        if ($increaseCapacityStmt->execute()) {
            echo "Capacity increased for course: $coursename<br>";
        } else {
            echo "Error increasing capacity: " . $increaseCapacityStmt->error . "<br>";
        }

        $increaseCapacityStmt->close();
    }

    // Close the connection
   
}

// Fetch the courses the student is registered for
$registeredCoursesStmt = $conn->prepare("SELECT r.courseid, c.coursename FROM tblregistration r JOIN tblcourses c ON r.courseid = c.courseid WHERE r.studentid = ?");
$registeredCoursesStmt->bind_param("i", $_SESSION['studentid']);
$registeredCoursesStmt->execute();
$registeredCoursesStmt->bind_result($courseId, $coursename);

// HTML form for cancellation

?>
<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset="utf-8">
		<title>Cancel Registration</title>
		<link rel = "stylesheet" href = "registration.css">
	</head>
	<body bgcolor="#f3f3f3">
		<header>
			<h1>Cancel RegistrationPage</h1>
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
			
		<form method="post" action="">
    <table border="1">
        <tr>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Cancel</th>
        </tr>

        <?php while ($registeredCoursesStmt->fetch()) : ?>
            <tr>
                <td><?php echo $courseId; ?></td>
                <td><?php echo $coursename; ?></td>
                <td><input type="checkbox" name="cancel_course[]" value="<?php echo $courseId; ?>"></td>
            </tr>
        <?php endwhile; 
		 $conn->close();?>

    </table>
    <br>
    <input type="submit" name="cancel" value="Cancel Selected Courses">
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