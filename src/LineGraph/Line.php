<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction</title>
    <style>
        .move-right {
            position: relative;
            right: 240px;
        }
        .close-button {
            background-color: white;
            border: 2px solid white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            color: black;
            font-weight: bold;
            font-size: 12px;
            cursor: pointer;
        }
        .close-button:hover {
            background-color: #f0f0f0;
        }
        button {
            position: relative;
            left: 900px;    
            width: 13%;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/table.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Expenses'],
                <?php
                include('../../Connection/Connection.php');
                if(isset($_GET['month'])){
                    $searchMonth = isset($_GET['month']) ? date('m', strtotime($_GET['month'])) : null;
                    $searchYear = isset($_GET['month']) ? date('Y', strtotime($_GET['month'])) : null;
                    
                    $sqlData = "SELECT DATE_FORMAT(date, '%Y-%m') AS YearMonth, SUM(amount) AS Total_Expenses FROM fms.Check";
                    if($searchMonth && $searchYear) {
                        $sqlData .= " WHERE MONTH(date) = $searchMonth AND YEAR(date) = $searchYear";
                    } elseif ($searchMonth) {
                        $sqlData .= " WHERE MONTH(date) = $searchMonth";
                    }
                    $sqlData .= " GROUP BY YearMonth";
                } else {
                    $sqlData = "SELECT DATE_FORMAT(date, '%Y-%m') AS YearMonth, SUM(amount) AS Total_Expenses FROM fms.Check GROUP BY YearMonth";
                }
                $resultData = $connection->query($sqlData);
                if ($resultData->num_rows > 0) {
                    while($row = $resultData->fetch_assoc()) {
                        echo "['".$row['YearMonth']."', ".$row['Total_Expenses']."],";
                    }
                } else {
                    echo "['No Data Available', 0],";
                }
                ?>
            ]);

            var options = {
                title: 'Barangay Performance',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
        }

        function generatePDF() {
            html2canvas(document.getElementById('curve_chart')).then(function(canvas) {
                var imgData = canvas.toDataURL('image/png');
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'save_chart.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        console.log('Chart image saved');
                        // Now request the server to generate the PDF
                        window.location.href = 'generate_pdf.php';
                    }
                };
                xhr.send('imgData=' + encodeURIComponent(imgData));
            });
        }
    </script>
</head>
<body>
<main class="main">
    <section class="topbar">
        <div class="toggle">
            <ion-icon name="menu-outline"></ion-icon>
        </div>
        <form action="LineAnalysis.php" method="get">
            <div class="search">
                <label>
                    <input type="text" name="month" placeholder="Enter month and/or year (e.g., May 2024)">
                    <ion-icon name="search-outline"></ion-icon>
                </label>
            </div>
        </form>
        <form action="LineAnalysis.php" method="get" class="move-right">
            <div class="back">
                <label>
                    <?php if(isset($_GET['month'])): ?>
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
            <button onclick="generatePDF()">Generate PDF</button>
            <div id="curve_chart" style="width: 1000px; height: 400px"></div>
        </div>
    </section>
</main>
</body>
</html>
