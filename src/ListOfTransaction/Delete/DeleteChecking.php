<?php
    session_start();
    include('../../../Encryption/Encryption.php');

    if(decryptData($_GET['Check']) == null){
        header('Location: ../Transaction.php');
    }
    
    $_SESSION['CheckNumber'] = decryptData($_GET['Check']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        html{
            scroll-behavior: smooth;
        }
        *{
            margin: 0;
            padding: 0;
        }
        body{
            font-family: Poppins;
            min-width: 100vh;
            background:  #F0F8FF;
        }
        .Box {
            position: relative;
            display:block;
            align-items: center;
            width: 350px;
            height: 400px;
            background: white;
            border-radius: 25px;
        }
        .successMessage {
            margin: 60px 70px 70px;
            display:flex;
            align-items: center;
            justify-content: center;
        }
        .imageIcon{
            text-align: center;
        }
        .imageIcon i{
            margin-top: 40px;
            font-size:100px;
            color: #ED4337;
        }
        .title{
            font-weight: 400;
            font-size: 13px;
            letter-spacing: 0.05px;
            text-align: center;
            margin: auto;
        }
        .message p{
            font-weight: 500;
            width: 80%;
            font-size: 16px;
            line-height: 50px;
            letter-spacing: 0.05px;
            text-align: center;
            margin: auto;
        }
        .Btn a{
            width: 100px;
            display: block;
            margin: 35px auto;
            border-radius: 15px;
            padding: 12px;
            text-decoration: none;
            color: white;
            text-align: center;
            letter-spacing: 0.05px;
            background: rgb(81, 188, 81);
        }
        .btncard{
            display:flex;
            justify-content: space-around;
            text-align: center;
        }
        .Btn.Cancel a{
            background: #ED4337;
        }
    </style>
</head>
<body>
    <div class="successMessage">
        <div class="Box">
            <div class="imageIcon">
                <i class='bx bxs-trash'></i>
            </div>
            <div class="title">
                <h1>Do you want to delete this transaction?</h1>
            </div>
            <div class="message">
                <p>You cannot undo this action</p>
            </div>
            <div class="btncard">
                <div class="Btn">
                    <a href="DeletePro.php">Yes</a>
                </div> 
                <div class="Btn Cancel">
                    <a href="../Transaction.php">No</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>