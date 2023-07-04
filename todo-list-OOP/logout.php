<?php 
require_once('config/connection.php');
unset($_SESSION['id']);
header('LOCATION:'.SITEURL.'login.php');
?>