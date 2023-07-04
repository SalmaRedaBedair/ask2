<?php
function message_underFields($name)
{
    if (isset($_SESSION["$name"])) {
        $msg = $_SESSION["$name"];
        echo "<small class='error-text'><br>* $msg</small>";
        unset($_SESSION["$name"]);
    }
}
?>