<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Add styles for h3 elements */
        .officials h3 {
            color: grey;
        }
        .officials table tr:hover h3,
        .officials table tr:hover a{
            color: #fff;
        }

        /* Add margin to the .officials section */
        .officials {
            margin: 15px; /* Adjust the value as needed */
        }
        .officials table tr td:nth-child(n+2){
            text-align: center;
        }
        .officials .cardHeader .Reassign {
            background-color: #6a0080;
            padding: 8px 16px;
            border-radius: 5px;
            margin-right: 32px; 
        }

        .officials .cardHeader .Reassign a {
            text-decoration: none;
            color: white;
        }

        .officials .cardHeader .Reassign a:hover {
            text-decoration: underline;
        }
        .officials .cardHeader .add {
            background-color: #6a0080;
            padding: 8px 16px;
            border-radius: 5px;
            margin-left: 580px;
        }

        .officials .cardHeader .add a {
            text-decoration: none;
            color: white;
        }

        .officials .cardHeader .add a:hover {
            text-decoration: underline;
        }
        .move-right {
            position: relative;
            right: 240px; /* Move the form to the right by 300px */
        }
        .close-button {
            background-color: white;
            border: 2px solid white;
            border-radius: 50%; /* Make the button circular */
            width: 20px;
            height: 20px;
            color: black;
            font-weight: bold;
            font-size: 12px;
            cursor: pointer;
        }

        .close-button:hover {
            background-color: #f0f0f0; /* Change background color on hover */
        }
    </style>
</head>
<body>
        <!--  --Main--   -->
    <main class="main">
        <section class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>
            <!--- This is just for the tables  -->
            <form method="get">
                <div class="search">
                    <label>
                        <input type="text" name="submit" placeholder="Search here"> 
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>
            </form>
            <form method="get" class="move-right">
                <div class="back">
                    <label>
                        <?php if(isset($_GET['submit'])): ?>
                            <input type="submit" value="&#10006" class="close-button">
                        <?php endif; ?>
                    </label>
                </div>
            </form>
            <div class="user">
                <img src="../../img/logo.jfif" alt="profile">
            </div>
        </section>
             <section class="officials">
                <div class="cardHeader">
                    <h2>Barangay Officials</h2>
                    <?php
                        if($_SESSION['Data']['role'] == "Administrator"){
                            ?>
                                <div class="add">
                                    <a href="AddAccount/SignUp.php" class="AddButton">
                                        <h5>Register</h5>
                                    </a>
                                </div>
                            <?php
                        }
                    ?>
                    <?php
                        if($_SESSION['Data']['role'] == "Administrator"){
                            ?>
                                <div class="Reassign">
                                    <a href="Reassign/Addofficial.php" class="ManageOfficials">
                                        <h5>Reassign</h5>
                                    </a>
                                </div>
                            <?php
                        }
                    ?>
                </div>
                <table>
                    <tr>
                        <td><h3>Profile</h3></td>
                        <td><h3>Firstname</h3></td>
                        <td><h3>Lastname</h3></td>
                        <td><h3>Position</h3></td>
                        <?php
                            if($_SESSION['Data']['role'] == "Administrator"){
                                ?>
                                    <td><h3>Profile</h3></td>
                                    <td><h3>Account</h3></td>
                                <?php
                            }
                        ?>
                    </tr>
                    <?php
                        include('../../Encryption/Encryption.php');
                        include("../../Connection/Connection.php");

                        if(isset($_GET['submit']) && !empty($_GET['submit'])) {
                            $search = $_GET['submit'];
                            $sql = "SELECT * FROM fms.Barangay_Official WHERE concat(name,' ',lastname) Like '%$search%' OR  position LIKE '%$search%'";
                        } else {
                            $sql = "SELECT * FROM fms.Barangay_Official";
                        }

                            $result =  $connection->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    if($row['position'] != "System Administrator"){
                                    ?>
                                        <tr>
                                            <td width="60px"><div class="imgBx"><img src="../../img/person.jpg" alt="Profile"></div></td>
                                            <td><?=$row['name']?></td>
                                            <td><?=$row['lastname']?></td>
                                            <td><?=$row['position']?></td>
                                            <?php
                                                if($_SESSION['Data']['role'] == "Administrator"){
                                                    ?>
                                                        <td><a href="Update/Update.php?Userid=<?= encryptData($row['official_id']) ?>" class="icon"> <i class='bx bxs-edit'></i> </a> </td>
                                                        <td><a href="AccountDetails/Account.php?Userid=<?= encryptData($row['official_id']) ?>" class="icon"><i class='bx bxs-user-rectangle'></i></a></td>
                                                    <?php
                                                }
                                            ?>
                                        </tr>
                                    <?php
                                    }
                                }
                            }
                            else {
                                // Display a message if no data is found
                                echo "<tr><td colspan='4' style='text-align: center; font-size: 1.1em;'>No data found</td></tr>";
                            }

                            $connection->close();
                    ?>
                </table>
             </section>
        </section>
    </main>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>



