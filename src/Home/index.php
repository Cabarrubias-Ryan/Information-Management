<?php
session_start();
include("../../Connection/connection.php");

if(!isset($_SESSION['loginChecker']))
{
    header("Location: ../../login.php");
}
if($_SESSION['loginChecker'] == false)
{
    header("Location: ../../login.php");
}
    include('../Navbar/Navbar.php');
    include('Dashboard.php');
?>