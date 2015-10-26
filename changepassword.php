<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "Lpk27460", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>

Change Password
<hr>
<?PHP
	if(isset($_POST['submit'])){
		$oldpassword = trim($_POST['oldpassword']);
		$newpassword = trim($_POST['newpassword']);
		$confirmpassword = trim($_POST['confirmpassword']);
		$id = $_SESSION['ID'];
		$query = "SELECT * FROM LOGIN WHERE id='$id' and password='$oldpassword'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		// Fetch each row in an associative array
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		if($row && $confirmpassword == $newpassword){
			$query = "UPDATE LOGIN SET password='$newpassword' WHERE id='$id'";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			header("location: MemberPage.php");
			
		}else{
			echo "fail.";
		}
	};
	oci_close($conn);
?>

<form action='changepassword.php' method='post'>
	Old password <br>
	<input name='oldpassword' type='password'><br>
	New password<br>
	<input name='newpassword' type='password'><br>
	Confirm password<br>
	<input name='confirmpassword' type='password'><br><br>
	<input name='submit' type='submit' value='change_password'>
</form>