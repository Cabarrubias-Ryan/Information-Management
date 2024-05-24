<?php
    session_start();
    include('../../../Encryption/Encryption.php');
    include('../../../Connection/Connection.php');
    
    $check = $_SESSION['CheckNumber'];

    $stmt = $connection->prepare('Select c.check_number, dv.dv_id, PB.id  from fms.Check c left join fms.Disbursement_Voucher dv on c.dv = dv.dv_id left join PB_Certification PB on PB.id = c.pb_certification where c.check_number = ?');

    $stmt->bind_param("i", $check);
    $stmt->execute();
    $Query = $stmt->get_result();
    $Data = $Query->fetch_assoc();

    $sqlCheck = $connection->prepare('DELETE FROM fms.Check WHERE check_Number = ?');
    $sqlPB = $connection->prepare('DELETE FROM fms.PB_Certification WHERE id = ?');
    $sqlDV =  $connection->prepare('DELETE FROM fms.Disbursement_Voucher WHERE dv_id = ?');

    $sqlCheck->bind_param("i", $check);
    $sqlPB->bind_param("i",$Data['id']);
    $sqlDV->bind_param("i",$Data['dv_id']);

    $sqlCheck->execute();
    $sqlPB->execute();
    $sqlDV->execute();
    
    header("Location: ../Transaction.php");
    $sqlCheck->close();
    $sqlPB->close();
    $sqlDV->close();
    exit();

?>