<?php
session_start();
session_unset();
session_destroy();
header("Location: http://localhost/CrackTheCode/Frontend/login.php"); 
exit();
