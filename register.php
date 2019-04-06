<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <title>Register</title>
</head>
<body>
  <div class="header">
  	<h2>Register</h2>
  </div>

  <form method="post" action="register.php" id = "form">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>First Name</label>
  	  <input type="text" name="first_name" value="<?php echo $first_name; ?>">
  	</div>
    <div class="input-group">
      <label>Last Name</label>
      <input type="text" name="last_name" value="<?php echo $last_name; ?>">
    </div>
    <div class="input-group">
      <label>Address</label>
      <input type="text" name="address" value="<?php echo $address; ?>">
    </div>
    <div class="input-group">
      <label>DOB</label>
      <input type="date" name="DOB" value="<?php echo $DOB; ?>">
    </div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a sheeper? <a href="login.php">Sign in</a>
  	</p>
    <br>
    <a href = "index.php">Home</a>
  </form>
</body>
</html>
