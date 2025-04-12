<?php

//  connect to database
    $coon = mysqli_connect('localhost','omi','test1234','omi_pizza');

    // check connection if not connected to database
    if (!$coon ) {
       echo 'connection error: ' . mysqli_connect_error();
    }

