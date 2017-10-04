<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php 
	if(isset($_SESSION['message'])) {
		echo $_SESSION['message'];
		$_SESSION['message']=null;
	}
?>
<?php	
	if (isset($_POST['submit'])) {
	    $usn = $_POST['usn'];
	    $password = $_POST['password'];
	    $found_admin = attempt_login($usn, $password);
    	if ($found_admin) {
      		// Success
    		// Mark user as logged in
    		$_SESSION["name"] = $found_admin["name"];
    		$_SESSION["usn"] = $found_admin["usn"];
    	}
    	else {
            echo "Incorrect usn/Password";
        }
	}
	if(!isset($_SESSION['usn'])) {
?>
    <html>
    <head><title>Login PAGE</title></head>  
    <body>
		<div id="login_form">
			<form  action = "login.php" method = "post">
				<table align = "center">	
					<p><tr>
						<td style = "padding : '10px'">usn : </td>
						<td><input id="username_textbox" type="text" name="usn" value="" /></p></td>
					</tr>
					<tr>
     					<td>Password : </td>
     					<td><input id="password_textbox" type="password" name="password" value="" /></td>
      				</tr>
      				<tr>
      					<td colspan = "2"><input id="login_button" type="submit" name="submit" value="Login" class = "custom-button"/></td>
      				</tr>
      				<tr>
      					<td colspan = "2">Dont have an account?</td>
      				</tr>
      				<tr>
      					<td colspan = "2"><a href="signup.php" class = "sign-up">Sign Up</a></td>
      				</tr>
				</table>
			</form>
		</div>

<?php } 
else 
{
	echo "Logged in";
	redirect_to("index.php"); 
}
?>
    </body>
</html>