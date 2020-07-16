<?php
include_once 'DBConnector.php';
include_once 'user.php';
$conn = new DBConnector;
if (isset($_POST['btn-save'])){
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$city = $_POST['city_name'];

	$user = new User($first_name, $last_name, $city);
	$uploader = new FileUploader;
	if (!$user -> validateForm()){
		$user -> createFormErrorSessions ();
		header ("Refresh:0");
		die();
	}
	$sql = $user ->save();

	$file_upload_response = $uploader -> uploadFile();

	if($res && $file_upload_response){
		echo "Save operation was successful";
	}else{
		echo "An error ocurred!";
	}
	$conn -> closeDatabase();
}?>
<html>
<head>
	<title>User</title>
	<script type ="text/javascript" src = "validate.js"></script>
	<link rel = "stylesheet" type = "text/css" href ="validate.css">

</head>
<body>
	<form method = "post" name = "user_details" id = "user_details" onsubmit = "return validateForm()" action = "<? = $_SERVER['PHP_SELF']?>">
		<table align = "center">
			<tr>
				<td>
					<div id = "form-errors">
						<?php
						session_start();
						if (!empty ($_SESSION['form_errors'])){
							echo " " . $_SESSION ['form_errors'];
							unset ($_SESSION['form_errors']);
						}
						?>
					</div>
				</td>
			</tr>
			<tr>
				<td><input type = "text" name = "first_name" required placeholder = "First Name"/></td>
			</tr>
			<tr>
				<td><input type = "text" name = "last_name" placeholder = "Last Name"/></td>
			</tr>
			<tr>
				<td><input type = "text" name = "city_name" placeholder = "City"/></td>
			</tr>
			<tr>
				<td><input type = "text" name = "username" placeholder = "Username"/></td>
			</tr>
			<tr>
				<td><input type = "password" name = "password" placeholder = "Password"/></td>
			</tr>
			<tr>
				<td>Profile image: <input type = "file" name = "fileToUpload" id = "fileToUpload"></td>
			</tr>
			<tr>
				<td><button type = "submit" name = "btn-save"><strong> SAVE</strong></button></td>
			</tr>
			<tr>
				<td><a href = "login.php">Login</a></td>
			</tr>
		</table>
	</form>
</body>
</html>

