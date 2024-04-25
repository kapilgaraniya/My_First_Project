<?php
    require_once('connection.php');
    session_start();
        echo  "<script>window.open('login.php','_self');</script>";

        session_destroy();
?>