<?php
    include('../../../Connection/Connection.php');
    include('../../../Encryption/Encryption.php');

    // Retrieving data from POST request
    $nameId = $_POST['UsernameId'];
    $id = $_POST['id'];
    $username = $_POST['name'];
    $password = $_POST['password'];
    $password1 = $_POST['password1'];
    $gmail = $_POST['gmail'];
    $role = $_POST['AccountRole'];


    $queryUsername = $connection->prepare('SELECT id FROM fms.Users Where username = ?');
    $queryUsername->bind_param('s',$username);
    $queryUsername->execute();
    $result = $queryUsername->get_result();
    $data = $result->fetch_assoc();

    if($result->num_rows > 0 && $nameId != $data['id']){
        header('Location: Account.php?user=Duplicate&Userid='. urlencode(encryptData($id)));
        exit();
    }

    // Validation checks
    if(empty($username) || empty($password) || empty($password1) || empty($gmail)){
        header('Location: Account.php?signup=empty&Userid='. urlencode(encryptData($id)));
        exit();
    }
    else if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/",$password))
    {
        if(!preg_match("/[A-Z]/",$password))
        {
            header("Location: Account.php?passwordcondition=UpperCase&Userid=". urlencode(encryptData($id)));
            exit();
        }
        else if(!preg_match("/[a-z]/",$password))
        {
            header("Location: Account.php?passwordcondition=LowerCase&Userid=". urlencode(encryptData($id)));
            exit();
        }
        else if(!preg_match("/\d/",$password))
        {
            header("Location: Account.php?passwordcondition=Number&Userid=". urlencode(encryptData($id)));
            exit();
        }
        else if(!preg_match("/\W/",$password))
        {
            header("Location: Account.php?passwordcondition=SpecialCharacter&Userid=". urlencode(encryptData($id)));
            exit();
        }
        else if(strlen($password) < 8)
        {
            header("Location: Account.php?passwordcondition=invalid&Userid=". urlencode(encryptData($id)));
            exit();
        }
    }
    else if($password !== $password1)
    {
        header("Location: Account.php?password=notmatch&Userid=". urlencode(encryptData($id)));
        exit();
    }
    else{
        
        // Prepared statement to update user information
        $sql = "UPDATE fms.Users SET password = ?, gmail = ?, account_role = ?, username = ?, updated_at = CURRENT_TIMESTAMP(), deleted_at = ? WHERE id = ?";
        $stmt = $connection->prepare($sql);

        
            // Bind parameters
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $deleted_at = NULL; // Assuming the account is not deleted

        $stmt->bind_param("sssssi", $hashed_password, $gmail, $role, $username, $deleted_at, $nameId);

            // Execute the statement
        $stmt->execute();
        
            // Check for errors
        if ($stmt->error) {
            echo "Error: " . $stmt->error;
        } else {
            header("Location: Success.php");
        }

            // Close statement
        $stmt->close();
    }
?>
