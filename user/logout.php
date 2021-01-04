<?php 
session_start();
unset($_SESSION['user']);
session_destroy();
echo'<script>';
echo'window.location.href="/crypto2/index.php";';
echo'</script>';
?>
