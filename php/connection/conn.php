<?php 
$servername = "localhost";
$username = "root";
$password = "ewerton";
$db_name = "papeducare";

$connect = mysqli_connect($servername, $username, $password, $db_name);

if(mysqli_connect_error()):
    echo "Falha na conexão: ".mysqli_connect_error();
endif;

?> 