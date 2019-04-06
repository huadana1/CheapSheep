<!-- Home page -->

<!-- include the server to connect with database (back-end) -->
<?php include('server.php') ?>

<!-- destroy the session info when logout button clicked -->
<?php
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['email']);
  }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

  <!-- title: $$cheapsheep(img)$$ -->
  <h1><strong>$$ <img src = "logo.png" alt = "shopping sheep cartoon"/> $$</strong></h1>

  <!-- Search Bar -->
    <div class="topnav">
      <a href = "index.php">Home</a>
      <a href = "upload.php">Upload</a>
      <a href = "tradepage.php">My Stuff</a>
      <div class = "dropdown">
          <span style = 'display: block; color: black; text-align: center; padding: 14px 16px; text-decoration: none; font-size: 17px;'>Trade Space</span>
        <div class = "dropdown-content">
            <p><a href = "tradeSpace.php">All</a></p>
            <p><a href = "tops.php">Tops</a></p>
            <p><a href = "bottoms.php">Bottoms</a></p>
            <p><a href = "dresses.php">Dresses</a></p>
            <p><a href = "accessories.php">Accessories</a></p>
            <p><a href = "shoes.php">Shoes</a></p>
            <p><a href = "offers.php">Make a Trade</a></p>
        </div>
      </div>
      <a href = "thriftfinder.html">Thrift Finder</a>
      <a href = "donations.html">Donate</a>
      <div class="search-container">
        <form method = "POST" action="search.php">
          <input type="text" placeholder="Search.." name="search">
          <button name = 'searchS' type="submit"><i class="fa fa-search"></i></button>
        </form>
      </div>
    </div>
    <br>

  <!--page content -->
  <div class="content">
    <!-- logged in notification message -->
    <?php if (isset($_SESSION['success'])) : ?>
    <div class="error success" >
      <h3>
        <?php
          echo $_SESSION['success'];
          unset($_SESSION['success']);
        ?>
      </h3>
    </div>
    <?php endif ?>

    <!-- condition: logged in or not page format -->
    <?php
    if (isset($_SESSION['email'])) {           //logged in
      //log out button
      echo ("
        <p> <a href='index.php?logout='1'' style = 'color: white;
        float: right; margin-right: 15px; margin-top: 0px;
        font-size: 25px; padding: 3px; border-radius: 5px;
        background: red'>logout</a> </p>
      ");

      //about site info style: left
      echo ("
        <div class = 'about' style = 'margin-left: 10px;'>
          <h3><em><strong>Our Mission</strong></em></h3>
          <p id = 'p1'>
            Our mission is to reduce the amount of clothes thrown away into landfills
            annually to improve our environment. We also work to provide an easy way
            for low-income people to afford higher-end clothes.
          </p>
          <h3><em><strong>How Cheap Sheep Works</strong></em></h3>
          <p id = 'p1'>
            Upload images of old wearable clothes and trade with other users globally.
            All clothes not traded can be donated to an organization of
            your choice in order to provide for the less fortunate such as the
            homeless and children in poverty. You can also choose
            to immediately donate the clothes.
          </p>
        </div>
      ");

    } else {                      //not logged in

      //login form
      echo ("
        <div class = 'login'>
          <p id = 'login'>LOGIN:</p>
          <br>
          <br>
          <form method='post' action='login.php'>
          	<?php include('errors.php'); ?>
          	<div>
          		<label>Email: </label>
              <br>
              <br>
          		<input type='email' name='email' >
          	</div>
            <br>
          	<div>
          		<label>Password: </label>
              <br>
              <br>
          		<input type='password' name='password'>
          	</div>
            <br>
          	<div>
          		<button type='submit' class='btn' name='login_user'>Login</button>
              <a href = 'register.php'><button type = 'button' class = 'btn' href = 'register.php'>New Sheeper?</button></a>
          	</div>
          </form>
        </div>
      ");

      //about site info style: on right next to login form
      echo ("
        <div class = 'about'>
          <h3><em><strong>Our Mission</strong></em></h3>
          <p id = 'p1'>
            Our mission is to reduce the amount of clothes throw away into landfills
            annually to improve environmental factors. We also work to provide a way
            for low-income people to afford clothes.
          </p>
          <h3><em><strong>How Cheap Sheep Works</strong></em></h3>
          <p id = 'p1'>
            Upload images of old wearable clothes and trade with other users globally.
            All clothes not traded after 90 days will be donated to an organization of
            your choice in order to provide for the less fortunate. You can also choose
            to immediately donate the clothes.
          </p>
        </div>
      ");
    }
    ?>
  </div>

</body>
</html>
