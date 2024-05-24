<?php
    session_start();
    include('../../../Encryption/Encryption.php');
    include('../../../Connection/Connection.php');
    
    if(decryptData($_GET['Check']) == null)
    {
        header("Location: ../Transaction.php");
    }
    $Checknumber = decryptData($_GET['Check']);

    // Prepare the SQL statement with placeholders
    $sql = "SELECT c.date as checkdate, dv.date as dvdate, PB.date as pbdate, c.check_number, dv.disbursement_no, PB.pb_number, c.payee, c.purpose, c.amount FROM fms.Check c 
    LEFT JOIN fms.Disbursement_Voucher dv ON c.dv = dv.dv_id 
    LEFT JOIN PB_Certification PB ON PB.id = c.pb_certification 
    WHERE c.check_number = ?";

    // Prepare the statement
    $stmt = $connection->prepare($sql);

    $stmt->bind_param("i", $Checknumber); // Bind the parameter
    $stmt->execute(); // Execute the statement
    $result = $stmt->get_result(); // Get the result
    $Data = $result->fetch_assoc(); // Fetch the data



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Transaction</title>
    <style>
        a {
            background: #fff;
            box-shadow: 0 2px 5px black;
            color: black;
            padding: 0.2em 1.2em;
            position: relative;
            text-decoration: none;
            text-transform: uppercase;
            border-radius: 30px;
        }
        .btn_back{
            padding-top: 14px;
        }
        body {
            font-family: Arial, sans-serif;
            background: #F0F8FF;
        }
        .containerPad {
            width: 80%;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .containerPad h2{
            display: flex;
            text-align: center;
            justify-content: center;
            padding-bottom: 30px;
        }
        input[type="text"], input[type="password"],input[type="email"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 15px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #6495ED;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #00008B;
        }
        strong{
            color: red;
            font-size: 12px;
        }
        .container .error{
            padding: 0 10px 10px 0;
        }
    </style>
</head>
<body>
    <div class="btn_back">
        <a href="../Transaction.php">Back</a>
    </div>
    <div class="containerPad">
        <h2>Transaction Data</h2>
            <form action="UpdateTransactionPro.php" method="POST">

                <input type="hidden" name="HiddenId" value ="<?= $Data['check_number']?>" require>

                <label for="Payee">Payee:</label>
                <input type="text" name="Payee" value ="<?= $Data['payee'] ?>" require>

                <label for="Purpose">Purpose:</label>
                <input type="text" name="Purpose" value ="<?= $Data['purpose'] ?>" require>

                <label for="Amount">Amount:</label>
                <input type="text" name="Amount" value ="<?= $Data['amount'] ?>" require>
                <div class="error">
                    <?php if(isset($_GET['signup'])): ?>
                        <?php if($_GET['signup'] == "invalidamount") : ?>
                            <strong>Please enter a valid amount (numbers and decimal point only).</strong>
                        <?php endif ?>
                    <?php endif ?>
                </div>

                <label for="checkdate">Check Date:</label>
                <input type="date" name="checkdate" value ="<?= $Data['checkdate'] ?>" require>

                <label for="DV">Disbursement Voucher:</label>
                <input type="text" name="DV" value ="<?= $Data['disbursement_no'] ?>" require>
                <div class="error">
                    <?php if(isset($_GET['_DV'])): ?>
                        <?php if($_GET['_DV'] == "Duplicate") : ?>
                            <strong>Disbursement Voucher Number already use</strong>
                        <?php endif ?>
                    <?php endif ?>
                </div>

                <label for="dvdate">Disbusement Voucher Date:</label>
                <input type="date" name="dvdate" value ="<?= $Data['dvdate'] ?>" require>

                <label for="PB">PB Number:</label>
                <input type="text" name="PB" value ="<?= $Data['pb_number'] ?>" require>

                <label for="pbdate">PB Number Date:</label>
                <input type="date" name="pbdate" value ="<?= $Data['pbdate'] ?>" require>
                <div class="error">
                    <?php if(isset($_GET['_PB'])): ?>
                        <?php if($_GET['_PB'] == "Duplicate") : ?>
                            <strong>Punong Barangay Certifiction number already use</strong>
                        <?php endif ?>
                    <?php endif ?>
                    <?php if(isset($_GET['Data'])): ?>
                        <?php if($_GET['Data'] == "Empty") : ?>
                            <strong>Invalid Data, Empty Data is not accepted.</strong>
                        <?php endif ?>
                    <?php endif ?>
                </div>
                <input type="submit" value="Sumbit">
            </form>
        </div>
</body>
</html>