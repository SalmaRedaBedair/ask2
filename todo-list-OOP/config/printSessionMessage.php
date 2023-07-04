<?php
session_start();
$_SESSION['arrayOfSessionMessageNames']=array(
    'database'
);
class printSessionMessage{
    function __construct(){
        foreach($_SESSION['arrayOfSessionMessageNames'] as $name){
            if(isset($_SESSION["$name"])){
                echo $_SESSION["$name"];
                unset($_SESSION["$name"]);
            }
        }
    }
}
return new printSessionMessage();
?>