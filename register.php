<?php
include ('./includes_css/header.html');
require_once('mysql_connect.php');
?>

<html>
<div id="site_content">
<head>	
<title>Register</title>
</head>
<body>
<div id="site_content" align="center">
<style>
input[type=submit] {
    width: 30%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
</style>
<h2>Registration Form</h2>
<form action="" method="POST">
<h3>Username: <input type="text" name="user" required /><br/></h3>
<h3>Password: <input type="password" name="pass" required /><br/></h3>	

<input type="submit" value="Register" name="submit" >
</form>
<?php 
if (isset($_POST['submit'])){

require_once('mysql_connect.php');
$user = $_POST['user'];
$pass = $_POST['pass'];


$query="SELECT * FROM login WHERE user='$user'";
$result = mysqli_query($dbc, $query);
if ( mysqli_num_rows($result) == 0)
{
//md5() calculates the MD5 hash of a string
$encrypt_password=md5($pass);

$query = "INSERT INTO login (user, pass) VALUES ('$user', '$encrypt_password')";

$result = mysqli_query($dbc, $query);


if($result!=1) 
{
echo "Failure!";
}
else{
echo "Account Successfully Created";
}
} else {
echo "That username already exists! Please try again with another.";
}

}
?>
</body>
</div>
</html>
<?php
include ('./includes_css/footer.html');
?> 