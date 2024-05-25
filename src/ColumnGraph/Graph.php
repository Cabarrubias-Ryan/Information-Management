<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction</title>
    <style>
        .move-right {
            position: relative;
            right: 240px; /* Move the form to the right by 240px */
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
        google.charts.setOnLoadCallback(drawVisualization);

        function drawVisualization() {
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Maintenance and Operations', 'Administration Expenses', 'Social Services'],
                <?php
                include('../../Connection/Connection.php');

                // Check if the button to display all data is clicked
                if(isset($_POST['search'])) {
                    // Check if a specific month and year are provided in the URL
                    $searchMonth = isset($_POST['search']) ? date('m', strtotime($_POST['search'])) : null;
                    $searchYear = isset($_POST['search']) ? date('Y', strtotime($_POST['search'])) : null;

                    // SQL query to fetch data grouped by month and purpose based on search parameters
                    $sqlData = "SELECT DATE_FORMAT(date, '%Y-%m') AS YearMonth, 
                                    SUM(CASE WHEN purpose in ('LDRRMF','Electricity Bill') THEN amount ELSE 0 END) AS Maintenance,
                                    SUM(CASE WHEN purpose = 'Honorarium' THEN amount ELSE 0 END) AS Administration_Expenses,
                                    SUM(CASE WHEN purpose in ('Cash Gift','BNEO') THEN amount ELSE 0 END) AS Social_Service
                            FROM fms.Check";

                    // If specific month and year are provided, filter the results
                    if($searchMonth && $searchYear) {
                        $sqlData .= " WHERE MONTH(date) = $searchMonth AND YEAR(date) = $searchYear";
                    } elseif ($searchMonth) {
                        $sqlData .= " WHERE MONTH(date) = $searchMonth";
                    } elseif ($searchYear) {
                        $sqlData .= " WHERE YEAR(date) = $searchYear";
                    }

                    $sqlData .= " GROUP BY YearMonth";

                    $resultData = $connection->query($sqlData);

                    if ($resultData->num_rows > 0) {
                        while($row = $resultData->fetch_assoc()) {
                            echo "['".$row['YearMonth']."', ".$row['Maintenance'].", ".$row['Administration_Expenses'].", ".$row['Social_Service']."],";
                        }
                    } else {
                        // Display a default row if there is no data available
                        echo "['No Data', 0, 0, 0],";
                    }
                }
                else{
                    $sqlData = "SELECT DATE_FORMAT(date, '%Y-%m') AS YearMonth, 
                                    SUM(CASE WHEN purpose in ('LDRRMF','Electricity Bill') THEN amount ELSE 0 END) AS Maintenance,
                                    SUM(CASE WHEN purpose = 'Honorarium' THEN amount ELSE 0 END) AS Administration_Expenses,
                                    SUM(CASE WHEN purpose in ('Cash Gift','BNEO') THEN amount ELSE 0 END) AS Social_Service
                            FROM fms.Check
                            GROUP BY YearMonth";

                    $resultData = $connection->query($sqlData);

                    if ($resultData->num_rows > 0) {
                        while($row = $resultData->fetch_assoc()) {
                            echo "['".$row['YearMonth']."', ".$row['Maintenance'].", ".$row['Administration_Expenses'].", ".$row['Social_Service']."],";
                        }
                    } else {
                        // Display a default row if there is no data available
                        echo "['No Data', 0, 0, 0],";
                    }
                }
                ?>
            ]);

            var options = {
                title : 'Monthly Transaction in Barangay',
                vAxis: {title: 'Money'},
                hAxis: {title: 'Month'},
                seriesType: 'bars',
                series: {3: {type: 'line'}}
            };

            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }

        function generatePDF() {
            html2canvas(document.getElementById('chart_div')).then(function(canvas) {
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
            <!--- This is just for the tables  -->
            <form method="POST">
               <div class="search">
                    <label>
                        <input type="text" name="search" placeholder="Enter month and/or year (e.g., May 2024)">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>
            </form>
            <form action="Analysis.php" method="get" class="move-right">
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
        <section class="detail button-like">
            <div class="Transaction">
                <button onclick="generatePDF()">Generate PDF</button>
                <div id="chart_div" style="width: 1000px; height: 400px;"></div>
            </div>
        </section>
    </main>
</body>
</html>
