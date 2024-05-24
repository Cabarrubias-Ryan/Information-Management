<?php
    include("../../../Connection/Connection.php");
    include("../../../Encryption/Encryption.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="../../../css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
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
        input[type="text"], input[type="password"],input[type="email"], select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
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
        .back-link {
            color: #fff;
            text-decoration: none;
            margin-top: 20px;
            margin-left: 20px;
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>
</head>
<body>
<main class="main">
    <section class="topbar">
    <div class="btn_back">
            <a href="../ListofOfficial.php">Back</a>
        </div>
            <!--- This is just for the tables  -->
            <div class="user">
                <img src="../../../img/logo.jfif" alt="profile">
            </div>
        </section>
    <div class="containerPad">
        <h2>Add Account</h2>
        <form action="RegistrationPro.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"  value = "<?php echo isset($_GET['user']) ? htmlspecialchars(decryptData($_GET['user'])) : '';  ?>">
            <div class="error">
                <?php if(isset($_GET['username'])): ?>
                    <?php if($_GET['username'] == "duplicate") : ?>
                        <strong>Username already been use.</strong>
                    <?php endif ?>
                <?php endif ?>
            </div>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" >
            <div class="error">
                <?php if(isset($_GET['passwordcondition'])): ?>
                    <?php $invalidpasswordChecker = $_GET['passwordcondition'] ?>
                        <?php if($invalidpasswordChecker == "invalid") : ?>
                            <strong>Password must have at least 8 characters.</strong>
                        <?php elseif($invalidpasswordChecker == "UpperCase") : ?>
                            <strong>Password must have at least one Upper Case.</strong>
                        <?php elseif($invalidpasswordChecker == "LowerCase") : ?>
                            <strong>Password must have at least one Lower Case.</strong>
                        <?php elseif($invalidpasswordChecker == "Number") : ?>
                            <strong>Password must have at least one number.</strong>
                        <?php elseif($invalidpasswordChecker == "SpecialCharacter") : ?>
                            <strong>Password must have at least one special Character.</strong>
                    <?php endif ?>
                <?php endif ?>     
            </div>

            <label for="Retype">Retype Password:</label>
            <input type="password" id="Retype" name="Retype">
            <div class="error">
                <?php if(isset($_GET['password'])): ?>
                    <?php if($_GET['password'] == "notmatch") : ?>
                        <strong>Password not match.</strong>
                    <?php endif ?>
                <?php endif ?>
            </div>

            <label for="Official">Account Holder:</label>
            <div>
                <select name="Official">
                    <option value="<?php echo isset($_SESSION['officialnumber']) ? $_SESSION['officialnumber'] : ''; ?>" hidden><?php echo isset($_SESSION['officialnumber']) ? $_SESSION['officialnumber'] : ''; ?></option>

                        <?php
                            $sql = "SELECT b.* FROM fms.Barangay_Official b
                            left join fms.Users u on  u.account_id = b.account_id Where b.official_id not in (select account_id from fms.Users)";

                            $result =  $connection->query($sql);

                            if ($result->num_rows > 0) 
                            {
                                    // output data of each row
                                    while($row = $result->fetch_assoc()) 
                                    {
                                        ?>
                                            <option value = "<?=$row['account_id']?>" >
                                                <?= $row['name']." ".$row['lastname']?>
                                            </option>
                                        <?php
                                    }
                            }
                        ?>
                </select>
            </div>

            <label for="Official">Account Role:</label>
            <div>
                <select name="role">
                    <option hidden></option>
                    <option value="Administrator" <?php echo isset($_SESSION['role']) && $_SESSION['role'] === 'Administrator' ? 'selected' : ''; ?>>Administrator</option>
                    <option value="User" <?php echo isset($_SESSION['role']) && $_SESSION['role'] === 'User' ? 'selected' : ''; ?>>User</option>
                </select>
            </div>

            <label for="gmail">Gmail:</label>
            <input type="email" name="gmail" value="<?php echo isset($_SESSION['gmail']) ? $_SESSION['gmail'] : ''; ?>" >
            <div class="error">
                <?php if(isset($_GET['signup'])): ?>
                    <?php if($_GET['signup'] == "empty") : ?>
                        <strong>You should not enter a empty data</strong>
                    <?php endif ?>
                <?php endif ?>
            </div>

            <input type="submit" value="Register">
        </form>
    </div>
    </main>
</body>
</html>
