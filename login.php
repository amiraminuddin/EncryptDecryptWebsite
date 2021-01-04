<?php
session_start();
include ('./includes_css/header.html');
require_once('mysql_connect.php');
?>

<html>
<head>	
<title>Login</title>
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
<h2>Login Form</h2>
<form action="" method="POST">
<h3>Username: <input type="text" name="user" required /><br/></h3>
<h3>Password: <input type="password" name="pass" required /><br/></h3>	

<input type="submit" value="Login" name="submit">
</form>

<?php 
if (isset($_POST['submit'])){

$user = $_POST['user'];
$pass = $_POST['pass'];


$encrypt_password=md5($pass);

$query = "SELECT * FROM login WHERE user='$user' AND pass='$encrypt_password'";
$result = mysqli_query($dbc, $query);
if ( mysqli_num_rows($result) == 1)
{
session_start();
$_SESSION['user']=$user;
$_SESSION['pass']=$pass;    

echo'<script>';
echo'window.location.href="/crypto2/user/index.php";';
echo'</script>';
}
else {
echo "Invalid username or password!";
}

}
?>
</body>
</html>
</div>
<?php
include ('./includes_css/footer.html');
?> 