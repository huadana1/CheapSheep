<?php
session_start();

// initializing variables
$first_name = "";
$last_name = "";
$address = "";
$DOB = "";
$email = "";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'registration');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
  $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
  $address = mysqli_real_escape_string($db, $_POST['address']);
  $DOB = mysqli_real_escape_string($db, $_POST['DOB']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($first_name)) { array_push($errors, "First Name is required"); }
  if (empty($last_name)) { array_push($errors, "Last Name is required"); }
  if (empty($address)) { array_push($errors, "Address is required"); }
  if (empty($DOB)) { array_push($errors, "DOB is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM sheepers WHERE email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

    if ($user['email'] === $email) {
      array_push($errors, "Email already exists");
    }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO sheepers (first_name, last_name, address, DOB, email, password) VALUES('$first_name', '$last_name', '$address', '$DOB', '$email', '$password')";
  	mysqli_query($db, $query);
    
    $table_name = preg_replace('/[^a-z\d\_]+/i', '',$_POST['email']); 

    //Create a new table for the user to upload items
    $sql = "CREATE TABLE $table_name (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    image VARCHAR(255) NOT NULL,
    image_text VARCHAR(255) NOT NULL,
    sizes TEXT(50),
    tags VARCHAR(255),
    monetary INT
    )";
      
    //execute creation
    mysqli_query($db, $sql);
      
  	$_SESSION['email'] = $email;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

// ...

// LOGIN USER
if (isset($_POST['login_user'])) {
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($email)) {
  	array_push($errors, "Email is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
    $query = "SELECT * FROM sheepers WHERE email='$email' AND password='$password'";
  	$results = mysqli_query($db, $query);
      
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['email'] = $email;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php');
  	}else {
  		array_push($errors, "Wrong email/password combination");
  	}
  }
}

// MAKE AN OFFER

//if (isset($_POST['offer'])) {
//    trade($img_id);
//}

/*if (isset($_POST['offer'])) {
    
    if (!isset($_SESSION['email'])) {
        echo "<script>
            alert('You must log in first');
            window.location = 'login.php';
        </script>";
    }else {
        
        $query = "SELECT * FROM images WHERE id = '$id'";
        $results = mysqli_query($db, $query);
        
        while ($row = mysqli_fetch_assoc($results)) {
            $offered_by = $usersData['id'];
            
            $item_owner = $row['user_email'];
            $offered_to = mysqli_query($db, "SELECT 'id' FROM sheepers WHERE email = '$item_owner'");
            
            $offered_to_item = $row['id'];
                
            $sql = "INSERT INTO offers (offered_by, offered_to, offered_to_item) VALUES ('$offered_by', '$offered_to', '$offered_to_item')";
        }
    }
}*/
        
?>
