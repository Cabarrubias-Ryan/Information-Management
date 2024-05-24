<?php
    session_start();
    include("../../../Connection/connection.php");
    include("../../../Encryption/Encryption.php");

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $role = $_POST['role'];


    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $lastname;
    $_SESSION['role'] = $role;
    
    if(empty($firstname) || empty($lastname) || empty($role)){
        header('Location: Addofficial.php?signup=empty');
    }
    $stmt = $connection->prepare('Select account_id from fms.Barangay_Official order by account_id desc limit 1');
    $stmt->execute();
    $result = $stmt->get_result();

    $Data = $result->fetch_assoc();
    $AccountID =  $Data['account_id'] + 1;

    $stmt2 = $connection->prepare('Select official_id from fms.Barangay_Official order by official_id desc limit 1');
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    $Data2 = $result2->fetch_assoc();
    $Official_ID =  $Data2['official_id'] + 1;
    $Status = "Active";

    $sql = $connection->prepare('INSERT INTO fms.Barangay_Official(official_id, account_id, name, lastname, position, elected_at,status)
    VALUES(?,?,?,?,?,CURRENT_TIMESTAMP(),?)');

    $sql->bind_param('iissss',$Official_ID,$AccountID,$firstname,$lastname,$role,$Status);
    $sql->execute();

    // Check for errors
    if ($sql->error) {
        echo "Error: " . $sql->error;
    } else {
        header("Location:Success.php");
        unset($_SESSION['firstname']);
        unset($_SESSION['lastname']);
        unset($_SESSION['role']);
        exit();
    }


?>