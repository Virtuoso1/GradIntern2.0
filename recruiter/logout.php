<?php
session_start();
$_SESSION = [];
session_destroy();
setcookie("recruiter_email", "", time() - 3600); 
header("Location: recruiter-login.php");
exit();
?>
