<?php
        include('../../../Encryption/Encryption.php');
        include('../../../Connection/Connection.php');
    
        $ID = $_POST['HiddenId'];
        $payee = $_POST['Payee'];
        $amount = $_POST['Amount'];
        $purpose = $_POST['Purpose'];
        $PB = $_POST['PB'];
        $DV = $_POST['DV'];
        $checkdate = $_POST['checkdate'];
        $dvdate = $_POST['dvdate'];
        $pbdate = $_POST['pbdate'];
    
        if(empty($payee) || empty($amount) || empty($PB) || empty($DV) || empty($purpose)){
            header('Location: UpdateTransaction.php?Data=Empty&Check='.urlencode(encryptData($ID)));
            exit();
        }
        else if (!is_numeric($amount)) {
            header('Location: UpdateTransaction.php?signup=invalidamount&Check='.urlencode(encryptData($ID)));
            exit();
        }
        else{

            $stmtSqlDvId = $connection->prepare("SELECT * FROM fms.Disbursement_Voucher where disbursement_no = ?");
            $stmtSqlPbId = $connection->prepare("SELECT * FROM fms.PB_Certification where pb_number = ?");

            $stmtSqlDvId->bind_param("s", $DV);
            $stmtSqlDvId->execute();
            $Query = $stmtSqlDvId->get_result();
        
            $stmtSqlPbId->bind_param("s", $PB);
            $stmtSqlPbId->execute();
            $Queryresult = $stmtSqlPbId->get_result(); 

            $stmtSql = $connection->prepare("Select dv.disbursement_no, PB.pb_number, c.check_number, c.pb_certification, c.dv, c.barangayofficial_id, dv.dv_id, PB.id  from fms.Check c left join fms.Disbursement_Voucher dv on c.dv = dv.dv_id left join PB_Certification PB on PB.id = c.pb_certification Where c.check_number = ?");
            
            $stmtSql->bind_param("i", $ID);
            $stmtSql->execute();
            $Query = $stmtSql->get_result();
            $Data = $Query->fetch_assoc();

            if($Query->num_rows > 0 && $Data['disbursement_no'] != $DV ){
                //DV
                header("Location: UpdateTransaction.php?_DV=Duplicate&Check=".urlencode(encryptData($ID)));
                exit();
            }
            if($Queryresult->num_rows > 0 && $Data['pb_number']  != $PB ){
                // PB
                header("Location: UpdateTransaction.php?_PB=Duplicate&Check=".urlencode(encryptData($ID)));
                exit();
            }

            $CheckUpdate = $connection->prepare("UPDATE fms.Check
                                                SET
                                                payee = ?,
                                                amount = ?,
                                                purpose = ?,    
                                                date = ?
                                                WHERE check_number = ? AND pb_certification = ? AND dv = ? AND barangayofficial_id = ?");

            $PBUpdate = $connection->prepare("UPDATE fms.PB_Certification
                                                SET
                                                pb_number = ?,
                                                date = ? 
                                                WHERE id = ?");

            $DVUpdate = $connection->prepare("UPDATE fms.Disbursement_Voucher
                                                SET
                                                disbursement_no = ?,
                                                date = ?
                                                WHERE dv_id = ?");

            $CheckUpdate->bind_param('sissiiii',$payee,$amount,$purpose,$checkdate, $Data['check_number'], $Data['pb_certification'], $Data['dv'], $Data['barangayofficial_id']);
            $PBUpdate->bind_param('ssi',$PB,$pbdate, $Data['id'] );
            $DVUpdate->bind_param('ssi',$DV,$dvdate, $Data['dv_id']);

            $CheckUpdate->execute();
            $PBUpdate->execute();
            $DVUpdate->execute();

            header("Location: Success.php");
            exit();


        }

?>