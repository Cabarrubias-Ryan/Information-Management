<?php
    session_start();
    include("../../../Connection/connection.php");
    include("../../../Encryption/Encryption.php");

    $Payee = $_POST['Payee'];
    $Amount = $_POST['Amount'];
    $CheckDate = $_POST['CheckDate'];
    $Purpose = $_POST['Purpose'];
    $AccountNumber = $_POST['AccountNumber'];
    $PB = $_POST['PB'];
    $PBDate = $_POST['PBDate'];
    $DV = $_POST['DV'];
    $DVDate = $_POST['DVDate'];
    $AccountID = $_SESSION['AccountID'];

    $_SESSION['payee'] = $Payee;
    $_SESSION['amount'] = $Amount;
    $_SESSION['checkdate'] = $CheckDate;
    $_SESSION['purpose'] = $Purpose;
    $_SESSION['accountnum'] = $AccountNumber;
    $_SESSION['pb'] = $PB;
    $_SESSION['pbdate'] = $PBDate;
    $_SESSION['dv'] = $DV;
    $_SESSION['dvdate'] = $DVDate;

    $stmtSqlDvId = $connection->prepare("SELECT * FROM fms.Disbursement_Voucher where disbursement_no = ?");
    $stmtSqlPbId = $connection->prepare("SELECT * FROM fms.PB_Certification where pb_number = ?");

    
    $stmtSqlDvId->bind_param("s", $DV);
    $stmtSqlDvId->execute();
    $Query = $stmtSqlDvId->get_result();

    $stmtSqlPbId->bind_param("s", $PB);
    $stmtSqlPbId->execute();
    $Queryresult = $stmtSqlPbId->get_result();

    if($Query->num_rows > 0){
        header("Location: Insert.php?_DV=Duplicate");
        exit();
    }
    if($Queryresult->num_rows > 0){
        header("Location: Insert.php?_PB=Duplicate");
        exit();
    }
    

    if(empty($Payee) || empty($Amount) || empty($CheckDate) || empty($Purpose) || empty($AccountNumber ) || empty($PB) || empty($PBDate) || empty($DV) || empty($DVDate) ){
        header("Location: Insert.php?signup=empty");
        exit();
    }
    else if (!is_numeric($Amount)) {
        header("Location: Insert.php?signup=invalidamount");
        exit();
    }
    else{

        $SqlDV = "INSERT INTO fms.PB_Certification (pb_number , date)
                    VALUES( ?, ?)";

        $SqlPB = "INSERT INTO fms.Disbursement_Voucher(disbursement_no, date)
                    VALUES(?,?)";

        $stmtSqlDV = $connection->prepare($SqlDV);
        $stmtSqlPB = $connection->prepare($SqlPB);

        // Bind parameters and execute SQL for PB Certification
        $stmtSqlDV->bind_param("ss", $DV, $DVDate );
        $stmtSqlDV->execute();

        $DVID = $stmtSqlDV->insert_id;

        // Bind parameters and execute SQL for Disbursement Voucher
        $stmtSqlPB->bind_param("ss", $PB, $PBDate);
        $stmtSqlPB->execute();

        $PBID = $stmtSqlPB->insert_id;
        

        
        $SqlChek = "INSERT INTO fms.Check
            (payee, amount, date, purpose, account_number, pb_certification, dv, barangayofficial_id)
            VALUES(?,?,?,?,?,?,?,?)";

        $stmt = $connection->prepare($SqlChek);
        $stmt->bind_param('sisssiii', $Payee, $Amount, $CheckDate, $Purpose, $AccountNumber, $PBID, $DVID, $AccountID);
        $stmt->execute();

        if ($stmt->error) {
            echo "Error: " . $stmt->error;
        } else {
            header("Location:Success.php");
            unset($_SESSION['payee']);
            unset($_SESSION['amount']);
            unset($_SESSION['checkdate']);
            unset($_SESSION['purpose']);
            unset($_SESSION['accountnum']);
            unset($_SESSION['pb']);
            unset($_SESSION['pbdate']);
            unset($_SESSION['dv']);
            unset($_SESSION['dvdate']);
            exit();
        }


    }


    



    
?>