<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
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
        .imageIcon img{
            margin-top: 40px;
        }
        .title{
            font-weight: 500;
            font-size: 24px;
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
            width: 50%;
            display: block;
            margin: 20px auto;
            border-radius: 25px;
            padding: 12px;
            text-decoration: none;
            color: white;
            text-align: center;
            letter-spacing: 0.05px;
            background: rgb(81, 188, 81);
        }
    </style>
</head>
<body>
    <div class="successMessage">
        <div class="Box">
            <div class="imageIcon">
                <img src="../../../img/iconCheck.jpeg">
            </div>
            <div class="title">
                <h1>Success</h1>
            </div>
            <div class="message">
                <p>You successfully added a Barangay Officials</p>
            </div>
            <div class="Btn">
                <a href="../ListofOfficial.php">Okay</a>
            </div>
        </div>
    </div>
</body>
</html>