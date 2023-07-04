<?php
require_once('submit.php');
?>
<!DOCTYPE html>
<html>

<head>
  <title>My Page</title>
  <link rel="stylesheet" href="css/login&registerForms.css">
</head>

<body>
  <div class="container">
    <form method="post" action="">
      <h2>Register</h2>
      <label for="name">Name:</label>
      <input type="text" id="name" name="name">
      <?php
      message_underFields('name');
      ?>
      <label for="user_name">user_name:</label>
      <input type="text" id="user_name" name="user_name">
      <?php
      message_underFields('user_name');
      ?>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password">
      <?php
      message_underFields('password');
      ?>
      <label for="confirm_password">Confirm Password:</label>
      <input type="password" id="confirm_password" name="confirm_password">
      <?php
      message_underFields('confirm_password');
      ?>
      <input type="submit" value="Register" name="submit">
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
  </div>
  <script src="js/script.php"></script>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
  submit($_POST, 'user', 'add');
}
?>