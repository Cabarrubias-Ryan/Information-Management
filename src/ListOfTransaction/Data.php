<?php
    include("../../Encryption/Encryption.php");
    include("../../Connection/Connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/table.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
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
        .DownloadButton {
            display: inline-block;
            background-color:  #07601c; /* Red color */
            color: #ffffff; /* White text color */
            text-decoration: none; /* Remove underline */
            padding: 8px 16px; /* Padding around text */
            border-radius: 4px; /* Rounded corners */
            transition: background-color 0.3s ease; /* Smooth color transition */
        }

        /* Hover effect for the delete button */
        .DownloadButton:hover {
            background-color: #054c16; /* Darker red on hover */
        }
    </style>
</head>
<body>
    <main class="main">
        <section class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>
            <!--- This is just for the tables  -->
            <form method="POST">
                <div class="search">
                    <label>
                        <input type="text" name="search" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>
            </form>
            <form method="get" class="move-right">
                <div class="back">
                    <label>
                        <?php if(isset($_POST['search'])): ?>
                            <input type="submit" value="&#10006" class="close-button">
                        <?php endif; ?>
                    </label>
                </div>
            </form>
            
            <div class="user">
                <img src="../../img/logo.jfif" alt="profile">
            </div>
        </section>
        <section class="detail">
            
            <div class="Transaction">
                <div class="card">
                    <h2>Transaction</h2>
                    
                    <?php
                        if(isset($_POST['search']) && !empty($_POST['search'])) {
                            ?>
                                <div class="Download">
                                    <a  href="Download.php?search=<?= isset($_POST['search']) ? $_POST['search'] : " " ?>" target="_blank" class="DownloadButton">Download PDF</a>
                                </div>
                            <?php
                        }
                        else  
                        {
                            
                            ?>
                            
                                <div class="add">
                                    <a href="InsertData/Insert.php" class="AddButton">
                                        <h5>Add Transaction</h5>
                                    </a>
                                    <a href="Download.php" target="_blank" class="AddButton">
                                        <h5>Download PDF</h5>
                                    </a>
                                </div>
                                
                                <?php
                                    if($_SESSION['Data']['role'] == "Administrator"){
                                        ?>
                                            <div class="Delete">
                                                <a href="DeleteAll/DeleteChecking.php" class="DeleteButton">
                                                    <h5>Delete all</h5>
                                                </a>
                                            </div>
                                        <?php
                                    }
                                    
                                ?>
                            <?php
                        } 
                    ?>
                </div>
                <table>
                    <thead>
                        <tr>
                            <td>Date</td>
                            <td>Check Number</td>
                            <td>DV No</td>
                            <td>PB Certification</td>
                            <td style="text-align: left">Payee</td>
                            <td style="text-align: left">Purpose</td>
                            <td style="text-align: left">Amount</td>
                            <?php
                                if($_SESSION['Data']['role'] == "Administrator"){
                                    ?>
                                        <td>Action</td>
                                    <?php
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        

                        if(isset($_POST['search']) && !empty($_POST['search'])) {
                            $search = $_POST['search'];
                            $sql = "SELECT c.date, c.check_number, dv.disbursement_no, PB.pb_number, c.payee, c.purpose, c.amount FROM fms.Check c LEFT JOIN disbursement_voucher dv ON c.dv = dv.dv_id LEFT JOIN PB_Certification PB ON PB.Id = PB_Certification WHERE c.check_number LIKE '%$search%' OR c.payee LIKE '%$search%' OR c.purpose LIKE '%$search%' OR c.date LIKE '%$search%'";
                        } else {
                            $sql = "SELECT c.date, c.check_number, dv.disbursement_no, PB.pb_number, c.payee, c.purpose, c.amount FROM fms.Check c LEFT JOIN disbursement_voucher dv ON c.dv = dv.dv_id LEFT JOIN PB_Certification PB ON PB.Id = PB_Certification";
                        }

                        $result = $connection->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?=date('F j, Y', strtotime($row['date']))?></td>
                                    <td><?=$row['check_number']?></td>
                                    <td><?=$row['disbursement_no']?></td>
                                    <td><?=$row['pb_number']?></td>
                                    <td style="text-align: left"><?=$row['payee']?></td>
                                    <td style="text-align: left"><?=$row['purpose']?></td>
                                    <td style="text-align: left"><?=number_format($row['amount'], 2, '.', ',')?></td>
                                    <?php
                                        if($_SESSION['Data']['role'] == "Administrator"){
                                            ?>
                                                <td><a href="Update/UpdateTransaction.php?Check=<?= encryptData($row['check_number']) ?>" class="icon"><i class='bx bxs-edit'></i></a>&nbsp;&nbsp;<a href="Delete/DeleteChecking.php?Check=<?= encryptData($row['check_number']) ?>" class="icon"><i class='bx bx-trash'></i></a></td>
                                            <?php
                                        }
                                    ?>
                                </tr>
                                <?php
                            }
                        } else {
                            // Display a message if no data is found
                            echo "<tr><td colspan='8' style='text-align: center; font-size: 1.1em;'>No data found</td></tr>";
                        }

                        $connection->close();
                    ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
