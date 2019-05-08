<?php
    //require 'config.php';

    // LOCAL
    $db_name = 'event_manager';
    $db_username = 'app_user';
    $db_passwd = 'pa55word';
    $port = 3306;

    // // PROD
    // $db_name = '';
    // $db_username = '';
    // $db_passwd = '';
    // $port = 3306;

    $mysqli = new mysqli('localhost', "$db_username", "$db_passwd", "$db_name");

    // Oh no! A connect_errno exists so the connection attempt failed!
    if ($mysqli->connect_errno) {
        echo "Sorry, this website is experiencing problems1.";
        exit;
    }
?>