<!DOCTYPE html>
<html>

<head>
  <title>My Page</title>
  <link rel="stylesheet" href="css/login&registerForms.css">
</head>

<body>
  <div class="container">
    <form action='' method="post">
      <h2>Login</h2>
      <?php
      require_once('submit.php');
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
      <input type="submit" value="Login" name='submit'>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
  </div>
  <script src="js/script.php"></script>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
  submit($_POST, 'user', 'login');
}
?>