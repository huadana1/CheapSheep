<!DOCTYPE html>
<html>

<!-- declare links-->
  <head>
    <link rel= "stylesheet" type= "text/css" href= "tradepagedetails.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Men's Bottoms</title>
  </head>
  <body>
  <!-- pagename-->
  <h1>
    <div>
        <img id= "logo" src= "logo.png" height= "120" width= "254"/>
    </div>
    <div>
      <center>Men's Bottoms</center>
      </div>
  </h1>
    <br><br><br>

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

                        <!-- Display all images with tops tag -->
    <?php
      $db = mysqli_connect("localhost", "root", "", "registration");

      //explodes data in tags from images table
      //grab images data
      $raw = mysqli_query($db, "SELECT * from images");
      $item_count = 0;
      echo "<div class='img_div'><center><table>";
      while ($row = mysqli_fetch_array($raw)) {
        $image = $row['image'];
        $img_id = $row['id'];
        $email = $row['user_email'];
        $value = $row['monetary'];
        $size = $row['sizes'];
        $image_text = $row['image_text'];
        $tags = explode(", ", $row['tags']);
        //displays items with filter tag
        foreach ($tags as $tag) {
            if ($tag == 'mens' && $tag = 'bottoms') {

                //creates table with 3 cells per row
                if ($item_count % 3 == 0) {
                    echo "<tr>";
                }

                echo "
                <td>
                <img id = 'upload' src = '$image'>
                <p> <strong>Image ID: </strong>$img_id</p>
                <p> <strong>User: </strong>$email </p>
                <p> <strong>Value: $</strong>$value</p>
                <p> <strong>Size: </strong>$size </p>
                <p> <strong>Description: </strong>$image_text </p>
                </td>
                ";

                if (($item_count + 1) % 3 == 0) {
                    echo "</tr>";
                }
                $item_count += 1;
            }
        }
      }
        //display none if no item with tag found
        if ($item_count == 0) {
            echo "<div style = 'font-size: 50px; display: inline; width: 90%; float: right;'>
            <p>My baaaaaaad, it seems there are no items with this tag.
            The old shepherd did nothing again! <p>
            <img src = 'sadSheep.png' style = 'margin-left: 40%;'></div>";
        }
      echo "</div></table></center>";
    ?>

    <!-- search Tags -->
    <br><br>
    <div2>
    <p>Search Tags: </p>
    <a href = "tops.php"><button> Tops </button> </a>
    <br>
    <a href = "bottoms.php"><button> Bottoms</button> </a>
    <br>
    <a href = "dresses.php"><button> Dresses </button> </a>
    <br>
    <a href = "accessories.php"><button> Accessories </button> </a>
    <br>
    <a href = "shoes.php"><button> Shoes </button> </a>
    </div2>

    <br><br>
    <div3>
    <p> Filters </p>
    <a href ="wbottoms.php"><button> Women's </button><br> </a>
    <a href ="mbottoms.php"><button> Men's </button><br> </a>
    <a href ="kbottoms.php"><button> Kid's </button><br> </a>
    <br>
  </div3>
  </body>

</html>
