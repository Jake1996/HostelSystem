<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php
if (isset($_POST['submit'])) {
	// Process the form
	$name = mysql_prep($_POST['name']);
	$usn = mysql_prep($_POST['usn']);
	if($_POST['password']!=$_POST['confirmPassword']) {
		$_SESSION['message']="Invalid Password";
		redirect_to("signup.php");
	}
	$password = mysql_prep($_POST['password']);
	$email = mysql_prep($_POST['email']);
	$hashedPassword = password_encrypt($password);
	$query  = "INSERT INTO Student (";
	$query .= "  name, usn, paswd, email";
	$query .= ") VALUES (";
	$query .= "  '{$name}', '{$usn}', '{$hashedPassword}', '{$email}'";
	$query .= ")";
	$result = mysqli_query($connection, $query);
	if ($result) {
		// Success
		redirect_to("login.php");
	} else {
		// Failure
		$_SESSION['message']="Invalid Usename/Password";
		redirect_to("signup.php");
	}
}

?>

<html>
<Head><title>SIGN UP</title>

<body>
    <form action="signup.php" method="post">
    	<table align="center">
    		<p><tr><td>Name : </td> <td> <input type="text" name="name" value="" /></p></td></tr>
    		<p><tr><td>USN : </td> <td><input type="text" name="usn" value="" /></p></td></tr>
    		<p><tr><td>Password : </td> <td><input type="password" name="password" value="" /></p></td></tr>
    		<p><tr><td>Confirm Password : </td> <td><input type="password" name="confirmPassword" value="" /></p></td></tr>
    		<p><tr><td>E-Mail : </td> <td><input type="text" name="email" value="" /></p></td></tr>
    		<p><tr><td colspan="2" align="center"><input type="submit" name="submit" value="Submit" class = "custom-button" id = "submit"/></p></td></tr>
	    </table>
	</form>
</body>
</html>  