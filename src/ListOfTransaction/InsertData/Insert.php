<?php
    session_start();
    include('TransactionForm.php');
    
    unset($_SESSION['check']);
    unset($_SESSION['payee']);
    unset($_SESSION['amount']);
    unset($_SESSION['checkdate']);
    unset($_SESSION['purpose']);
    unset($_SESSION['accountnum']);
    unset($_SESSION['pb']);
    unset($_SESSION['pbdate']);
    unset($_SESSION['dv']);
    unset($_SESSION['dvdate']);
?>