<?php
    require_once 'server.php';

    // Check if user is logged in, redirect to login if not
      if (!isset($_SESSION['email'])) {
          echo "<script>
              alert('You must log in first');
              window.location = 'login.php';
          </script>";
      }

    $db = mysqli_connect("localhost", "root", "", "registration");

    //max limit in input areas depending on number of items uploaded in images
    $result = mysqli_query($db, "SELECT * FROM images");
    $num_rows = mysqli_num_rows($result);

    if (isset($_POST["trade"])) {
        $user = $_SESSION["email"];

        //items up for trade
        $wanted_item_id = mysqli_real_escape_string($db, $_POST['wanted_item_id']);
        $unwanted_item_id = mysqli_real_escape_string($db, $_POST['unwanted_item_id']);

        //get owner of the unwanted item
        $result = mysqli_query($db, "SELECT * from images WHERE id='$unwanted_item_id'");

        while ($row = mysqli_fetch_array($result)) {
            $owner_unwanted = $row['user_email'];
        }

        //get owner of the wanted item
        $result = mysqli_query($db, "SELECT * from images WHERE id='$wanted_item_id'");

        while ($row = mysqli_fetch_array($result)) {
            $owner_wanted = $row['user_email'];
        }

        //check if wanted item belongs to user
        //if true, then alert message
        //if false, then check if unwanted item belongs to user
        //check if unwanted item belongs to user
        //if true, save offer
        //if false, alert message
        if ($user == $owner_wanted) {
            echo "You can't trade with youself!";
        } elseif ($user == $owner_unwanted) {
            //save into offers table
            $query = "INSERT INTO offers (owner_unwanted, owner_wanted, unwanted_item, wanted_item) VALUES ('$owner_unwanted', '$owner_wanted' , '$unwanted_item_id', '$wanted_item_id')";
            mysqli_query($db, $query);
        } else {
            echo "This item does not belong to you! No stealing sheep you big, bad wolf!";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trade</title>
    <link rel = 'stylesheet' href = 'tradepagedetails.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>My Offers</title>
    <style>
        table {
          width: 90%;
          color: black;
        }

        td {
          padding: 50px;
          height: 300px;
          color: black;
        }
        th {
          font-size: 20px;
        }
        img {
            width: 210px;
            height: 160px;
            margin: 60px;
        }
        h3 {
            margin-left: 2px;
        }

        #cheapSheep {
            float: left;
            margin: 0px;
        }

        .trade {
            font-size: 30px;
        }

    </style>
</head>
<body>
    <img id= "cheapSheep" src="logo.png">

    <h1><center>My Offers</center></h1>
    <br><br><br>

    <!-- NAV BAR -->
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

    <!-- input items to trade -->
    <div class = 'trade'>
        <center>
        <form method = "post" action="offers.php" enctype="multipart/form-data" >
            <label>ID # of wanted item: </label>
            <input type = "number" min = "1" max = <?php echo $num_rows ?> name = "wanted_item_id" value = "<? php echo $wanted_item_id; ?>">

            <label>ID # of unwanted item: </label>
            <input type = "number" min = "1" max = <?php echo $num_rows ?> name = "unwanted_item_id" value = "<?php echo $unwanted_item_id; ?>">

            <button type = "submit" name = "trade">Trade</button>
        </form>
        </center>
    </div>

    <!-- display outgoing offers in table -->
    <?php
      require_once 'server.php';

      $all = mysqli_query($db, "SELECT * FROM offers");

      echo "<h3>Outgoing Offers<h3>";
      echo "<center><table>";
      echo "<tr><th>My Item</th><th>for...</th><th>Their Item</th>";
      while($row = mysqli_fetch_array($all)) {

        if ($row['owner_unwanted'] == $_SESSION['email']) {

            $unwanted_id = $row['unwanted_item'];
            $uitem = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM images WHERE id = '$unwanted_id'"));
            $unwanted_item = $uitem['image'];
            $u_user = $uitem['user_email'];
            $u_value = $uitem['monetary'];
            $u_size = $uitem['sizes'];
            $u_text = $uitem['image_text'];
            $u_tags = $uitem['tags'];

            $wanted_id = $row['wanted_item'];
            $witem = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM images WHERE id = '$wanted_id'"));
            $wanted_item = $witem['image'];
            $w_user = $witem['user_email'];
            $w_value = $witem['monetary'];
            $w_size = $witem['sizes'];
            $w_text = $witem['image_text'];
            $w_tags = $witem['tags'];
              echo "<tr>
                        <td>
                            <img src = '$unwanted_item'>
                            <p><strong>User: </strong>$u_user</p>
                            <p><strong>Value: $</strong>$u_value</p>
                            <p><strong>Size: </strong>$u_size</p>
                            <p><strong>Description: </strong>$u_text</p>
                            <p><strong>Tags: </strong>$u_tags</p>
                        </td>
                        <td>
                           <img src = doubleArrow.jpg>
                        </td>
                        <td>
                            <img src = '$wanted_item'>
                            <p><strong>User: </strong>$w_user</p>
                            <p><strong>Value: $</strong>$w_value</p>
                            <p><strong>Size: </strong>$w_size</p>
                            <p><strong>Description: </strong>$w_text</p>
                            <p><strong>Tags: </strong>$w_tags</p>
                        </td>
                    </tr>";

            }
        }
        echo "</table></center>";
    ?>

    <!-- Display incoming offers in table -->
    <?php
      require_once 'server.php';
      $all = mysqli_query($db, "SELECT * FROM offers");

      echo "<h3>Incoming Offers</h3>";
      echo "<center><table>";
      echo "<tr><th>Their Item</th><th>for...</th><th>My Item</th>";
      while($row = mysqli_fetch_array($all)) {

        if ($row['owner_wanted'] == $_SESSION['email']) {

            $unwanted_id = $row['unwanted_item'];
            $uitem = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM images WHERE id = '$unwanted_id'"));
            $unwanted_item = $uitem['image'];
            $u_user = $uitem['user_email'];
            $u_value = $uitem['monetary'];
            $u_size = $uitem['sizes'];
            $u_text = $uitem['image_text'];
            $u_tags = $uitem['tags'];

            $wanted_id = $row['wanted_item'];
            $witem = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM images WHERE id = '$wanted_id'"));
            $wanted_item = $witem['image'];
            $w_user = $witem['user_email'];
            $w_value = $witem['monetary'];
            $w_size = $witem['sizes'];
            $w_text = $witem['image_text'];
            $w_tags = $witem['tags'];
              echo "<tr>
                        <td>
                            <img src = '$unwanted_item'>
                            <p><strong>User: </strong>$u_user</p>
                            <p><strong>Value: $</strong>$u_value</p>
                            <p><strong>Size: </strong>$u_size</p>
                            <p><strong>Description: </strong>$u_text</p>
                            <p><strong>Tags: </strong>$u_tags</p>
                        </td>
                        <td>
                           <img src = doubleArrow.jpg>
                        </td>
                        <td>
                            <img src = '$wanted_item'>
                            <p><strong>User: </strong>$w_user</p>
                            <p><strong>Value: $</strong>$w_value</p>
                            <p><strong>Size: </strong>$w_size</p>
                            <p><strong>Description: </strong>$w_text</p>
                            <p><strong>Tags: </strong>$w_tags</p>
                        </td>
                    </tr>";

            }
        }
        echo "</table></center>";
     ?>
</body>
</html>
