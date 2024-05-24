<?php
    session_start();
    include("../../../Connection/connection.php");
    include("../../../Encryption/Encryption.php");

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $reTrypassword = $_POST['Retype'];
        $ID = $_POST['Official'];
        $role = $_POST['role'];
        $gmail = $_POST['gmail'];


        $_SESSION['officialnumber'] = $ID;
        $_SESSION['role'] = $role;
        $_SESSION['gmail'] = $gmail;
        $UsernameDuplicate = "SELECT * from Users WHERE username = '".$username."'";
        $resultOfQuery = $connection->query($UsernameDuplicate);

        if($resultOfQuery->num_rows > 0)
        {
            header("Location: SignUp.php?username=duplicate");
            exit();
        }
        else if(empty($username) || empty($password) || empty($ID) || empty($gmail) || empty($reTrypassword))
        {
            header("Location: SignUp.php?signup=empty&user=". urlencode(encryptData($username)));
            exit();
        }
        else if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/",$password))
        {
            
            if(!preg_match("/[A-Z]/",$password))
            {
                header("Location: SignUp.php?passwordcondition=UpperCase&user=". urlencode(encryptData($username)));
                exit();
            }
            else if(!preg_match("/[a-z]/",$password))
            {
                header("Location: SignUp.php?passwordcondition=LowerCase&user=". urlencode(encryptData($username)));
                exit();
            }
            else if(!preg_match("/\d/",$password))
            {
                header("Location: SignUp.php?passwordcondition=Number&user=". urlencode(encryptData($username)));
                exit();
            }
            else if(!preg_match("/\W/",$password))
            {
                header("Location: SignUp.php?passwordcondition=SpecialCharacter&user=". urlencode(encryptData($username)));
                exit();
            }
            else if(strlen($password) < 8)
            {
                header("Location: SignUp.php?passwordcondition=invalid&user=". urlencode(encryptData($username)));
                exit();
            }
        }
        else if($password !== $reTrypassword)
        {
            header("Location: SignUp.php?password=notmatch&user=". urlencode(encryptData($username)));
            exit();
        }
        else
        {
            $Official = "SELECT *  FROM fms.Users u left outer join fms.Barangay_Official bo on u.account_id = bo.official_id where bo.account_id = ?";
            $stmt = $connection->prepare($Official);

            $stmt->bind_param("i", $ID);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows == 1){
                header("Location: SignUp.php?id=duplicate&user=". urlencode(encryptData($username)));
                exit();
            }

            $Official = "SELECT *  FROM fms.Barangay_Official where account_id = ?";
            $stmt = $connection->prepare($Official);

            $stmt->bind_param("i", $ID);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if($result->num_rows > 0)
            {
                $userData = $result->fetch_assoc();
                $id = $userData['official_id'];

                $sqlUSER = "INSERT INTO Users (username, password, account_id , gmail, account_role, created_at, deleted_at, updated_at) 
                VALUES (?, ?, ?, ?, ?,CURRENT_TIMESTAMP(), NULL, NULL)";

                $stmt = $connection->prepare($sqlUSER);
                if ($stmt) {
                    // Bind parameters
                    $stmt->bind_param("ssiss", $username, password_hash($password,PASSWORD_BCRYPT), $id , $gmail, $role);

                    // Execute the statement
                    $stmt->execute();

                    // Check for errors
                    if ($stmt->error) {
                        echo "Error: " . $stmt->error;
                    } else {
                        header("Location:Success.php");
                    }

                    // Close statement
                    $stmt->close();
                } 
                else {
                    echo "Error in preparing statement: " . $connection->error;
                }
            }
            else
            {
                header("Location: SignUp.php?id=notexist&user=". urlencode(encryptData($username)));
                exit();
            }
        }

        $connection->close();
    }
    else
    {
        header("Location: SignUp.php");
    }

    unset($_SESSION['officialnumber']);
    unset($_SESSION['role']);
    unset($_SESSION['gmail']);

?>
