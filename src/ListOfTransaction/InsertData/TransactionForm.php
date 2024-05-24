<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/style.css">
    <title>Transaction Form</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #FFF;
        }
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
        .containerPad {
            width: 80%;
            margin: 50px 100px;
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
<main class="main">
    <section class="topbar">
        <div class="btn_back">
            <a href="../Transaction.php">Back</a>
        </div>
            <!--- This is just for the tables  -->
            <div class="user">
                <img src="../../../img/logo.jfif" alt="profile">
            </div>
        </section>
        <div class="containerPad">
        <h2>Transaction Form</h2>
            <form action="insertpro.php" method="POST">
            <label for="Payee">Payee:</label>
            <input type="text" name="Payee" value="<?php echo isset($_SESSION['payee']) ? $_SESSION['payee'] : ''; ?>" >

            <label for="Amount">Amount:</label>
            <input type="text" name="Amount" value="<?php echo isset($_SESSION['amount']) ? $_SESSION['amount'] : ''; ?>" >
            <div class="error">
                <?php if(isset($_GET['signup'])): ?>
                    <?php if($_GET['signup'] == "invalidamount") : ?>
                        <strong>Please enter a valid amount (numbers and decimal point only).</strong>
                    <?php endif ?>
                <?php endif ?>
            </div>

            <label for="CheckDate">Date:</label>
            <input type="date" name="CheckDate" value="<?php echo isset($_SESSION['checkdate']) ? $_SESSION['checkdate'] : ''; ?>" >

            <label for="Purpose">Purpose:</label>
            <input type="text" name="Purpose" value="<?php echo isset($_SESSION['purpose']) ? $_SESSION['purpose'] : ''; ?>" >

            <label for="AccountNumber">Account Number:</label>
            <input type="text" name="AccountNumber" value="<?php echo isset($_SESSION['accountnum']) ? $_SESSION['accountnum'] : ''; ?>" >
            
            <label for="PB">PB Certification Number:</label>
            <input type="text" name="PB" value="<?php echo isset($_SESSION['pb']) ? $_SESSION['pb'] : ''; ?>" >
                <div class="error">
                        <?php if(isset($_GET['_PB'])): ?>
                        <?php if($_GET['_PB'] == "Duplicate") : ?>
                            <strong>Punong Barangay Certifiction number already use</strong>
                        <?php endif ?>
                    <?php endif ?>
                </div>

            <label for="PBDate">Date:</label>
            <input type="date" name="PBDate" value="<?php echo isset($_SESSION['pbdate']) ? $_SESSION['pbdate'] : ''; ?>" >
                

            <label for="DV">Disbursement Voucher Number:</label>
            <input type="text" name="DV" value="<?php echo isset($_SESSION['dv']) ? $_SESSION['dv'] : ''; ?>" >
                <div class="error">
                        <?php if(isset($_GET['_DV'])): ?>
                        <?php if($_GET['_DV'] == "Duplicate") : ?>
                            <strong>Disbursement Voucher Number already use</strong>
                        <?php endif ?>
                    <?php endif ?>
                </div>

            <label for="DVDate">Date:</label>
            <input type="date" name="DVDate" value="<?php echo isset($_SESSION['dvdate']) ? $_SESSION['dvdate'] : ''; ?>" >
                <div class="error">
                    <?php if(isset($_GET['signup'])): ?>
                        <?php if($_GET['signup'] == "empty") : ?>
                            <strong>You should not enter a empty data</strong>
                        <?php endif ?>
                    <?php endif ?>
                </div>
                
                <input type="submit" value="Sumbit">
            </form>
        </div>
    </main>
</body>
</html>
