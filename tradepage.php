<?php require'functions.php'; require'server.php'; ?>
<?php
        if (!isset($_SESSION['email'])) {
            echo"
                <script>
                    alert('You must log in first');
                    window.location = 'login.php';
                </script>
            ";
        }
?>
<!DOCTYPE html>
<html>
<head>
  <link rel= "stylesheet" type= "text/css" href= "tradepagedetails.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>My Stuff</title>
</head>
<body>
    <img id= "cheapSheep" src="logo.png" height= "120" width= "254">

    <!--heading for My Stuff (aka stuff they upload to trade)-->
    <div>
    <h1><center>My Stuff</center></h1>
    <br><br><br>
    </div>

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

    <!-- images -->
    <div class = "uploads" style = 'width: 80%; margin-right: 0px; float: right;'>
      <?php
        $db = mysqli_connect("localhost", "root", "", "registration");

        $usersData = UserData($_SESSION['email']);
        $table_name = preg_replace('/[^a-z\d\_]+/i', '', $usersData['email']);
        $result = mysqli_query($db, "SELECT * FROM $table_name");

        // Diplay every image in own database
        echo "<div class='img_div'>";
        $item_count = 0;
        echo "<center>";
        echo "<table>";
        while ($row = mysqli_fetch_array($result)) {
          if ($item_count % 3 == 0) {
            echo "<tr>";
          }

          echo "<td>";
          //image
          $image = $row['image'];
          echo "<img id = 'upload' src = '$image'>";

          //image id
          $img_id = $row['id'];
          echo "<p><strong>Image ID: </strong>$img_id<p>";

          //tags
          $tags = $row['tags'];
          echo "<p style = 'color: black;'> <strong>Tags: </strong>$tags </p>";

          //size
          $size = $row['sizes'];
          echo "<p style = 'color: black;'> <strong>Size: </strong>$size </p>";

          //image text
          $image_text = $row['image_text'];
          echo "<p style = 'color: black;'> <strong>Description: </strong>$image_text </p>";

          echo "</td>";
          if (($item_count + 1) % 3 == 0) {
            echo "</tr>";
          }
          $item_count += 1;
        }

          echo "</table>";
          echo "</center>";
          echo "</div>";
      ?>
    </div>

    <!-- filterTags -->
    <br><br><br>
    <div>
    <p>Search Tags: </p>
        <a href = "tops.php"><button> Tops </button></a>
      <br>
          <a href = "bottoms.php"><button> Bottoms</button></a>
      <br>
          <a href = "dresses.php"><button> Dresses </button></a>
      <br>
          <a href = "accessories.php"><button> Accessories </button></a>
      <br>
          <a href = "shoes.php"><button> Shoes </button></a>
    </div>
</body>
</html>
