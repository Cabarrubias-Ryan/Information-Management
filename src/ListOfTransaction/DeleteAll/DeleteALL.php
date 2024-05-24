<?php
    include('../../../Connection/Connection.php');

    $sql3 = "SELECT check_number FROM fms.Check";
    $stmt3 = $connection->prepare($sql3);
    $stmt3->execute();
    $Query3 = $stmt3->get_result();

    $sql1 = "SELECT dv_id FROM fms.Disbursement_Voucher";
    $stmt1 = $connection->prepare($sql1);
    $stmt1->execute();
    $Query1 = $stmt1->get_result();

    $sql2 = "SELECT id FROM fms.PB_Certification";
    $stmt2 = $connection->prepare($sql2);
    $stmt2->execute();
    $Query2 = $stmt2->get_result();

    while ($row3 = $Query3->fetch_assoc()) {
        $Check_Number = $row3['check_number']; // Get the Check_Number from the current row
    
        $DeleteQuery = $connection->prepare('DELETE FROM fms.Check WHERE check_number = ?');
        $DeleteQuery->bind_param('s', $Check_Number);
        $DeleteQuery->execute();
    }

    while ($row1 = $Query1->fetch_assoc()) {
        $DV_Id = $row1['dv_id']; // Get the Check_Number from the current row
    
        $DeleteQuery = $connection->prepare('DELETE FROM fms.Disbursement_Voucher WHERE dv_id = ?');
        $DeleteQuery->bind_param('s', $DV_Id);
        $DeleteQuery->execute();
    }
    while ($row2 = $Query2->fetch_assoc()){
        $Id = $row2['id']; // Get the Check_Number from the current row
    
        $DeleteQuery = $connection->prepare('DELETE FROM fms.PB_Certification WHERE id = ?');
        $DeleteQuery->bind_param('s', $Id);
        $DeleteQuery->execute();
    }
    
    // Close the database connection
    $connection->close();

    header('Location: ../Transaction.php');
    exit();
?>
