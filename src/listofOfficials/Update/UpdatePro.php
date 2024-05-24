<?php
    include('../../../Encryption/Encryption.php');
    include('../../../Connection/Connection.php');

    $ID = $_POST['HiddenId'];
    $lastname = $_POST['lastname'];
    $Name = $_POST['name'];
    $Position = $_POST['position'];
    $status = $_POST['status'];

    if(empty($Name) || empty($Position) || empty($lastname))
    {
        header('Location: Update.php?Data=Empty&Userid='.urlencode(encryptData($ID)));
        exit();
    }
    else{

        // Prepare the SQL statement with placeholders
        $sql = "UPDATE fms.Barangay_Official 
        SET name = ?,lastname = ? , position = ?, status = ? 
        WHERE official_id = ?";

        // Prepare the statement
        $stmt = $connection->prepare($sql);

        // Bind parameters
        $stmt->bind_param("ssssi", $Name, $lastname,$Position,$status, $ID);
        

        // Execute the statement
        if ($stmt->execute()) {
            header('Location: Success.php');
            exit();
        } 
        else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();

    }




?>