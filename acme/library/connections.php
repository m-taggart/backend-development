<?php

/*
 * Database Connections
 */

function acmeConnect() {
    $server = "localhost";
    $database = "acme";
    $user = "iClient";
    $password = "i7tHTgZd90BpCZc9";
    $dsn = "mysql:host=$server;dbname=$database";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try {
        $acmeLink = new PDO($dsn, $user, $password, $options);
        return $acmeLink;
    } catch (PDOException $ex) {
        header('location: ../view/500.php');
    }
}
//acmeConnect();
//require 'view/500.php';
