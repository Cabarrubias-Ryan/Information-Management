<?php
    session_start();
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
        <h2>Add Barangay Officials</h2>
        <form action="Official_Insert.php" method="POST">
            <label for="firstname">Firstname:</label>
            <input type="text" id="firstname" name="firstname"  value = "<?php echo isset($_SESSION['firstname']) ? $_SESSION['firstname'] : '';  ?>">

            <label for="lastname">Lastname:</label>
            <input type="text" id="lastname" name="lastname" value = "<?php echo isset($_SESSION['lastname']) ? $_SESSION['lastname'] : '';  ?>">
            
            <label for="Official">Position:</label>
            <div>
                <select name="role">
                    <option hidden></option>
                    <option value="Punong Barangay" <?php echo isset($_SESSION['role']) && $_SESSION['role'] === 'Punong Barangay' ? 'selected' : ''; ?>>Punong Barangay</option>
                    <option value="Sangguniang Barangay Member" <?php echo isset($_SESSION['role']) && $_SESSION['role'] === 'Sangguniang Barangay Member' ? 'selected' : ''; ?>>Sangguniang Barangay Member</option>
                    <option value="SK Chairperson" <?php echo isset($_SESSION['role']) && $_SESSION['role'] === 'SK Chairperson' ? 'selected' : ''; ?>>SK Chairperson</option>
                    <option value="Barangay Secretary" <?php echo isset($_SESSION['role']) && $_SESSION['role'] === 'Barangay Secretary' ? 'selected' : ''; ?>>Barangay Secretary</option>
                    <option value="Barangay Tresurer" <?php echo isset($_SESSION['role']) && $_SESSION['role'] === 'Barangay Tresurer' ? 'selected' : ''; ?>>Barangay Tresurer</option>
                </select>
            </div>
            <div class="error">
                <?php if(isset($_GET['signup'])): ?>
                    <?php if($_GET['signup'] == "empty") : ?>
                        <strong>You should not enter a empty data</strong>
                    <?php endif ?>
                <?php endif ?>
            </div>

            <input type="submit" value="Register">
        </form>
        <?php
             unset($_SESSION['firstname']);
             unset($_SESSION['lastname']);
             unset($_SESSION['role']);
        ?>
    </div>
    </main>
</body>
</html>
