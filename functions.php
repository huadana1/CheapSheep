<?php

    function UserData($email) 
    {
        $db = mysqli_connect("localhost", "root", "", "registration");
        $query = "SELECT * FROM sheepers WHERE email='$email'";
        $results = mysqli_query($db, $query);

        // Create an empty array to put logged in user info 
        $array = array();
        while ($row = mysqli_fetch_assoc($results)) {
            $array['id'] = $row['id'];
            $array['first_name'] = $row['first_name'];
            $array['last_name'] = $row['last_name'];
            $array['address'] = $row['address'];
            $array['DOB'] = $row['DOB'];
            $array['email'] = $row['email'];
            return ($array);
        }
        return $array;
    }
    
?>