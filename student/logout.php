<?php
session_start();
$_SESSION = [];
session_destroy();
setcookie("student_email", "", time() - 3600); 
header("Location: student-login.php");
exit();
?>
