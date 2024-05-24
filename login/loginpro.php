<?php
    session_start();
    include("../Connection/connection.php");
    include("../Encryption/Encryption.php");

    $username = $_POST['username'];
    $password = $_POST['password'];

    // i already have a code to prevent the sqli injection 
    //first is prepare the sql query
    $queryUser = $connection->prepare("SELECT u.password, u.account_id, u.id, u.account_role, bo.status FROM fms.Users u left join fms.Barangay_Official bo on bo.official_id = u.account_id WHERE u.username = ?");
    // second use the bind_param and the 's' represent as a String which is the username
    $queryUser->bind_param("s", $username);
    // then execute the query
    $queryUser->execute();
    // last is get the result 
    $result = $queryUser->get_result();
    $_SESSION['loginChecker'] = false;

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
        if($userData['status'] != "Active"){
            header("Location: ../login.php?login=Invalid&username=" . urlencode(encryptData($username)));
            exit();
        }
        // Use password_verify to check if the entered password matches the hashed password
        if (password_verify($password, $userData['password'])) {

            $_SESSION['loginChecker'] = true;
            $_SESSION['AccountID'] = $userData['account_id'];
            
            $userInfo = [
                'role' => $userData['account_role']
            ];

            $_SESSION['Data'] = $userInfo;
            header("Location: ../src/Home/index.php");
        } else {
            // Incorrect password
            header("Location: ../login.php?login=error&username=" . urlencode(encryptData($username)));
        }
    } 
    else {
        // User not found
        header("Location: ../login.php?login=error&username=" . urlencode(encryptData($username)));
    }

    $queryUser->close();
    $connection->close();
?>
