<?php
require_once('convert-to-string.php');
function number_validation($conn,$number,$type)
{
    $number=mysqli_real_escape_string($conn,$number);
    if(empty($number))
    {
        $_SESSION["$type"] = "$type is required.";
    }
    else if (!preg_match('/^\d+$/', $number)){
        $type2=strtolower($type);
        $_SESSION["$type"] = "Invalid $type2 format.";
    }
    return $number;
}
?>