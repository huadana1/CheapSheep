<?php
    require 'functions.php';

    $userData = UserData ('a@a.com');
    
    echo $userData['id'];
    echo $userData['address'];
?>