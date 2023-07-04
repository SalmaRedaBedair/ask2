<?php
function Message($type,$message,$sessionType){
    $_SESSION["$sessionType"]="<div class='$type'>$message<span class='close'>&times;</span></div>";
}
?>