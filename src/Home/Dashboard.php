<?php
        include("../../Connection/Connection.php");

        // SQL query to fetch total amount
        $sqlTotal = "SELECT SUM(amount) AS Amount FROM fms.Check";
        $resultTotal = $connection->query($sqlTotal);
        $rowTotal = $resultTotal->fetch_assoc();
        $_SESSION['Total_Expenditures'] = ($rowTotal['Amount'] !== null) ? $rowTotal['Amount'] : 0;

        // SQL query to fetch data grouped by purpose
        $sqlData = "SELECT 
            DATE_FORMAT(date, '%Y-%m') AS YearMonth, 
            SUM(CASE WHEN purpose IN ('LDRRMF', 'Electricity Bill') THEN amount ELSE 0 END) AS Maintenance,
            SUM(CASE WHEN purpose = 'Honorarium' THEN amount ELSE 0 END) AS Administration_Expenses,
            SUM(CASE WHEN purpose IN ('Cash Gift', 'BNEO') THEN amount ELSE 0 END) AS Social_Service
        FROM fms.Check 
        WHERE DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m')
        GROUP BY YearMonth";
        $resultData = $connection->query($sqlData);
        $data = $resultData->fetch_assoc();

        // Initialize session variables with default values
        $_SESSION['Maintenance'] = 0;
        $_SESSION['Administration_Expenses'] = 0;
        $_SESSION['Social_Service'] = 0;

        // If data is available, assign values to session variables
        if ($data !== null) {
            $_SESSION['Maintenance'] = $data['Maintenance'];
            $_SESSION['Administration_Expenses'] = $data['Administration_Expenses'];
            $_SESSION['Social_Service'] = $data['Social_Service'];
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['YearMonth', 'Expenses'],
                <?php
                include('../../Connection/Connection.php');

                // Check if a specific month and year are provided in the URL
                    $sqlData = "SELECT DATE_FORMAT(Date, '%Y-%m') AS YearMonth, SUM(Amount) AS Total_Expenses
                    FROM fms.check WHERE Date >= DATE_SUB(CURDATE(), INTERVAL 4 MONTH) GROUP BY YearMonth";

                $resultData = $connection->query($sqlData);

                if ($resultData->num_rows > 0) {
                    while($row = $resultData->fetch_assoc()) {
                        echo "['".$row['YearMonth']."', ".$row['Total_Expenses']."],";
                    }
                } else {
                    // Display a message if there is no data available
                    echo "['No Data Available', 0],";
                }
                ?>
        ]);

        var options = {
          title: 'Barangay Performance',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
</head>
<body>
        <!--  --Main--   -->
        <main class="main">
        <section class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>
            <div class="user">
                <img src="../../img/logo.jfif" alt="profile">
            </div>
        </section>

        <!-- Card -->
        <section class="cardBox">
            <div class="card">
                <div>
                    <div class="numbers"><?= number_format($_SESSION['Maintenance'],2, ".",",") ?></div>
                    <div class="cardName">Maintenance Expenses</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="receipt-outline"></ion-icon>
                </div>
            </div>
            <div class="card">
                <div>
                    <div class="numbers"><?= number_format($_SESSION['Administration_Expenses'],2,".", ",") ?></div>
                    <div class="cardName">Administration Expenses</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="reader-outline"></ion-icon>
                </div>
            </div>
            <div class="card">
                <div>
                    <div class="numbers"><?= number_format($_SESSION['Social_Service'],2,".",",") ?></div>
                    <div class="cardName">Social Service Expenses</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="people-outline"></ion-icon>
                </div>
            </div>
            <div class="card">
                <div>
                    <div class="numbers"><?= number_format($_SESSION['Total_Expenditures'],2,".",",") ?></div>
                    <div class="cardName">Total Expenditures</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="cash-outline"></ion-icon>
                </div>
            </div>
        </section>
        <!-- Details List -->
        <section class="details">
            <div class="recentTransaction">
                <div class="cardHeader">
                    <h2>Recent Transaction</h2>
                    <a href="../ListOfTransaction/Transaction.php" class="btn">View All</a>
                </div>
                <table>
                    <thead>
                       <tr>
                        <td>Check Number</td>
                        <td>Payee</td>
                        <td>Purpose</td>
                        <td>Status</td>
                       </tr>
                    </thead>
                    <tbody>
                    <?php
                            $sql = "Select  c.check_number, c.payee, c.purpose, c.date from fms.Check c order by c.check_number desc limit 3 ";
                            $result =  $connection->query($sql);

                            if ($result->num_rows > 0) 
                            {
                                    // output data of each row
                                    while($row = $result->fetch_assoc()) 
                                    {
                                        ?>
                                                <tr>
                                                    <td><?=$row['check_number']?></td>
                                                    <td><?=$row['payee']?></td>
                                                    <td><?=$row['purpose']?></td>
                                                    <td><?=date('F j, Y', strtotime($row['date']))?></td>
                                                </tr>
                                        <?php
                                    }

                            }
                            else {
                                // Display "Empty Data" message
                                ?>
                                    <tr>
                                        <td colspan="4" style='text-align: center; font-size: 0.9em;'>Empty Data</td>
                                    </tr>
                                <?php
                             }

                            ?>
                    </tbody>
                </table>
            </div>
             <section class="officials">
                <div class="cardHeader">
                    <h2>Recent Spendings</h2>
                </div>
                <div id="chart_div" style="min-width: 100%; min-height: 230px;"></div>
             </section>
        </section>
    </main>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>



