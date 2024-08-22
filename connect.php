<?php
$HOSTNAME = "localhost";
$USERNAME = "root";
$PASSWORD = "";
$DATABASE = "tech_trove";

$con = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

if(!$con){
    die("". mysqli_connect_error());
}

?>