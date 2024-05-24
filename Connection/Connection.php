<?php


$connection = mysqli_connect('localhost','root','root','fms',3306);

if(!$connection)
{
    die('Connection failed'. mysqli_connect_error());
}

?>