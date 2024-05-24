<?php
    session_start();
    include('Registration.php');
    
    unset($_SESSION['officialnumber']);
    unset($_SESSION['role']);
    unset($_SESSION['gmail']);
    
?>