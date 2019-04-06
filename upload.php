<?php require 'functions.php'; require 'server.php' ?>
<?php
  // Create database connection
  $db = mysqli_connect("localhost", "root", "", "registration");

  // Check if user is logged in, redirect to login if not
    if (!isset($_SESSION['email'])) {
        echo "<script>
            alert('You must log in first');
            window.location = 'login.php';
        </script>";
    }

  // If upload button is clicked ...
  if (isset($_POST['upload'])) {
      // Get user data
      $usersData = UserData($_SESSION['email']);
      $user = $usersData['email'];
      // Get user's table name
      $table_name = preg_replace('/[^a-z\d\_]+/i', '',$usersData['email']);
      // Get image name
      $image = $_FILES['image']['name'];
      // Get text
      $image_text = mysqli_real_escape_string($db, $_POST['image_text']);
      //Get size
      $size = mysqli_real_escape_string($db, $_POST['size']);
      //Get $value
      $value = mysqli_real_escape_string($db, $_POST['monetary_value']);

      //Get tags data
      $filter = implode(", ", $_REQUEST['tags']);


      // image file directory
      $target = "images/".$_FILES['image']['name'];

      $allowed =  array('gif','png' ,'jpg', 'tiff');

      $ext = pathinfo($image, PATHINFO_EXTENSION);

      if(!in_array($ext,$allowed) ) {
          echo "That's not a  picture! Go away you blaaack sheep!";
      } else {
      // all images database
      $sql = "INSERT INTO images (user_email, image, image_text, sizes, tags, monetary) VALUES ('$user', '$image', '$image_text', '$size', '$filter', '$value')";
      // user images database
      $sql2 = "INSERT INTO $table_name (image, image_text, sizes, tags, monetary) VALUES ('$image', '$image_text', '$size', '$filter', '$value')";
      // execute queryies
      mysqli_query($db, $sql);
      mysqli_query($db, $sql2);
    }
  }

?>
<!DOCTYPE html>
<html>
<head>
<title>Image Upload</title>
<style type="text/css">
   #content{
   	width: 50%;
   	margin: 20px auto;
   	border: 1px solid #cbcbcb;
   }
   form{
   	width: 50%;
   	margin: 20px auto;
   }
   form div{
   	margin-top: 5px;
   }
   #img_div{
   	width: 80%;
   	padding: 5px;
   	margin: 15px auto;
   	border: 1px solid #cbcbcb;
   }
   #img_div:after{
   	content: "";
   	display: block;
   	clear: both;
   }
   img{
   	float: left;
   	margin: 5px;
   	width: 300px;
   	height: 140px;
   }
   #tags {
      column-count: 3;
       column-gap: 20px;
       column-fill:balance;
       margin-right: 15px;
   }
    table {
        padding: 5px;
        display: inline;
    }
    #home {
    float: right;
    }
</style>
</head>
<body>
<div id="content">
  <a href = 'index.php' id = 'home'><button>Home</button></a>
  <a href = 'tradepage.php'><button>My Stuff</button></a>
  <h1 style = "text-align: center">Upload Items:</h1>
  <form method="POST" action="upload.php" enctype="multipart/form-data">
  	<div>                                        <!--image-->
  	  <input type="file" name="image">
  	</div>
  	<div>                                        <!--description-->
      <textarea
      	id="text"
      	cols="40"
      	rows="4"
        maxlength="100"
      	name="image_text"
      	placeholder="Say something about this image... (100 chars)"></textarea>
    </div>
    <div>
        Value: $ <input name = "monetary_value" type = "number" max="99" placeholder="Monetary Value, max $99">
    </div>
     <div>                                      <!--Size-->
        Size:
         <table>
             <tr>
                 <td>
                    <input type="radio" name="size"
                      <?php if (isset($size) && $size=="Small") echo "checked";?>
                      value="X-Small">X-Small
                 </td>
                 <td>
                    <input type="radio" name="size"
                      <?php if (isset($size) && $size=="Small") echo "checked";?>
                      value="Small">Small
                 </td>
                 <td>
                    <input type="radio" name="size"
                      <?php if (isset($size) && $size=="Medium") echo "checked";?>
                      value="Medium">Medium
                 </td>
             </tr>
             <tr>
                 <td>
                    <input type="radio" name="size"
                      <?php if (isset($size) && $size=="Large") echo "checked";?>
                      value="Large">Large
                 </td>
                 <td>
                    <input type="radio" name="size"
                      <?php if (isset($size) && $size=="XX-Large") echo "checked";?>
                      value="X-Large">X-Large
                 </td>
                 <td>
                    <input type="radio" name="size"
                      <?php if (isset($size) && $size=="XX-Large") echo "checked";?>
                      value="XX-Large">XX-Large
                 </td>
             </tr>
         </table>
    </div>
    <div>                                           <!--tags-->
        <p>Tags (Select all that apply): </p>
        <input type = "checkbox" value = "mens" name = "tags[]">mens<br>
        <input type = "checkbox" value = "womens" name = "tags[]">womens<br>
        <input type = "checkbox" value = "kids" name = "tags[]">kids<br>
        <input type = "checkbox" value = "tops" name = "tags[]">tops<br>
        <input type = "checkbox" value = "bottoms" name = "tags[]">bottoms<br>
        <input type = "checkbox" value = "dresses" name = "tags[]">dresses<br>
        <input type = "checkbox" value = "accessories" name = "tags[]">accessories<br>
        <input type = "checkbox" value = "shoes" name = "tags[]">shoes<br>
    </div>
  	<div>
  		<button type="submit" name="upload">UPLOAD</button>
  	</div>
  </form>
</div>
</body>
</html>
