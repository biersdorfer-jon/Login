<?php
session_start();

require 'openConnection.php';  

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Check if the user is already registered for the selected course
    $selectedCourseId = $_POST['courseid'];
    $studentid = $_SESSION['studentid'];

    $checkStmt = $conn->prepare("SELECT * FROM tblregistration WHERE studentid = ? AND courseid = ?");
    $checkStmt->bind_param("ii", $studentid, $selectedCourseId);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "You are already registered for this course.";
    } else {
        // Get course capacity
        $capacityStmt = $conn->prepare("SELECT capacity FROM tblcourses WHERE courseid = ?");
        $capacityStmt->bind_param("i", $selectedCourseId);
        $capacityStmt->execute();
        $capacityStmt->bind_result($capacity);
        $capacityStmt->fetch();
        $capacityStmt->close();

        // Check if there is still capacity available
        if ($capacity > 0) {
            // Decrease capacity by one
            $newCapacity = $capacity - 1;

            // Update course capacity
            $updateCapacityStmt = $conn->prepare("UPDATE tblcourses SET capacity = ? WHERE courseid = ?");
            $updateCapacityStmt->bind_param("ii", $newCapacity, $selectedCourseId);
            $updateCapacityStmt->execute();
            $updateCapacityStmt->close();

            // Insert registration record
            $insertStmt = $conn->prepare("INSERT INTO tblregistration (studentid, courseid) VALUES (?, ?)");
            $insertStmt->bind_param("ii", $studentid, $selectedCourseId);

            if ($insertStmt->execute()) {
                echo "Registration successful!";
            } else {
                echo "Error registering for the course: " . $insertStmt->error;
            }

            $insertStmt->close();
        } else {
            echo "Sorry, the course is full. Registration failed.";
        }
    }

    // Close the connection
    $checkStmt->close();
    
}

// Fetch course information for the table
$courseQuery = "SELECT courseid, coursecode, coursename, professorFirst, professorLast, capacity FROM tblcourses";
$result = $conn->query($courseQuery);

?>
<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset="utf-8">
		<title>Add New Course</title>
		<link rel = "stylesheet" href = "registration.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
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
	<body bgcolor="#f3f3f3">

<h2>Available Courses</h2>

<?php
 if (isset($_SESSION['fname'])) {
    echo "<h3>Welcome, " . $_SESSION['fname'] . "!</h3>";

echo "<table border='1'>";
echo "<tr>";
    echo  "<th>Course Code</th>";
        echo  "<th>Course Name</th>";
        echo  "<th>Professor</th>";
        echo  "<th>Capacity</th>";
    echo "</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['coursecode'] . "</td>";
        echo "<td>" . $row['coursename'] . "</td>";
        echo "<td>" . $row['professorLast'] . ", "  . $row['professorFirst'] . "</td>";
        echo "<td>" . $row['capacity'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
else {
    // Display a message for guests to sign up
    echo "<h3>Welcome, Guest!</h3>";
    echo "<p>Please <a href='signInForm.php'>sign up</a> to view available courses and register.</p>";
}

    ?>


<h2>Course Registration</h2>

<form method="post" action="">
    <label for="courseid">Select Course:</label>
    <select name="courseid" id="course">
        <?php
        // Fetch course names for the dropdown list
        $dropdownQuery = "SELECT courseid, coursename FROM tblcourses";
        $dropdownResult = $conn->query($dropdownQuery);

        while ($row = $dropdownResult->fetch_assoc()) {
            echo "<option value='" . $row['courseid'] . "'>" . $row['coursename'] . "</option>";
        }
        $conn->close();
        ?>
    </select>
    <input type="submit" name="submit" value="Register">
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
	
	
	
	
	
	
	
	
	
	
	
	