<?php
$conn=require_once('config/connection.php');
?>
<script>
document.addEventListener("DOMContentLoaded", function () {
  var closeButton = document.querySelector(".close");
  closeButton.addEventListener("click", function () {
    var errorMessage = document.querySelector(".error");
    errorMessage.parentNode.removeChild(errorMessage);
  });
});


</script>

