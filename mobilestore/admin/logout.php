<?php
    require_once('config.php');
    session_start();
        echo  "<script>window.open('../login.php','_self');</script>";

        session_destroy();
?>