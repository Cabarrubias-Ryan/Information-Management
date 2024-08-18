<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <!-- the header and the navagation located-->
    <header class="container">
        <nav class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon"><ion-icon name="wallet-outline"></ion-icon></span>
                        <span class="title">Financial Management</span>
                    </a>
                </li>
                <li>
                    <a href="../Home/index.php">
                        <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="../ListOfTransaction/Transaction.php">
                        <span class="icon"><ion-icon name="document-outline"></ion-icon></span>
                        <span class="title">Transaction</span>
                    </a>
                </li>
                <li>
                    <a href="../listofOfficials/ListofOfficial.php">
                        <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                        <span class="title">User</span>
                    </a>
                </li>
                <li>
                    <a href="../LineGraph/LineAnalysis.php">
                        <span class="icon"><ion-icon name="analytics-outline"></ion-icon></span>
                        <span class="title">Analytics</span>
                    </a>
                </li>
                <li>
                    <a href="../ColumnGraph/Analysis.php">
                        <span class="icon"><ion-icon name="stats-chart-outline"></ion-icon></span>
                        <span class="title">Graph</span>
                    </a>
                </li>
                <li>
                    <a href="../Logout/logout.php">
                        <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                        <span class="title">Log out</span>
                    </a>
                </li>

            </ul>
        </nav>
    </header>
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!--JS function-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let toggle = document.querySelector('.toggle');
            let navigation = document.querySelector('.navigation');
            let main = document.querySelector('.main');

            toggle.onclick = function() {
                navigation.classList.toggle('active');
                main.classList.toggle('active');
            };
        });

        let list = document.querySelectorAll('.navigation li');
        function activeLink() {
            list.forEach((item) => 
            item.classList.remove('hovered'));
            this.classList.add('hovered');
        }

        list.forEach((item) =>
            item.addEventListener('mouseover', activeLink));
    </script>

</body>
</html>


