<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales | Buyers | IFA</title>
    <link rel="stylesheet" href="salesbuy.css?v=1.0">
    <link rel="stylesheet" href="buyernav.css?v=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body style="background-color: #fbe8ec;">
    <div class="box">
        <div class="leftbox">
            <a href="buyerfile.html" class="heading">BUYERS</a>
            <div class="box1">
            <a href="http://localhost/dbms/flowerbuy.php" id="l1">Flowers</a><br><br><br>
            <a href="http://localhost/dbms/auctionbuy.php" id="l2">Auctions</a><br><br><br>
            <a href="http://localhost/dbms/salesbuy.php" id="l3">Sales</a><br><br><br>
            </div>
            <a href="http://localhost/dbms/home.html" id="logout">LOGOUT</a>
        </div>
        <div class="rightbox">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ifa";
    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $query = "SELECT f.name AS floweName, AVG(v.startingPrice) AS AverageStartingPrice
        FROM varieties v, flowers f
        WHERE v.flowerId=f.flowerId
        GROUP BY f.flowerId
        ORDER BY AverageStartingPrice DESC";
        
        $result = $conn->query($query);
        echo "<h2 id='head'>Average Starting Price of Varieties by Flower</h2>";
        if ($result->num_rows > 0) {
            echo "<table><tr><th>Flower Name</th><th>Average Starting Price</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["floweName"]. "</td><td>" . $row["AverageStartingPrice"]. "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
        ?>
        </div>
    </div>
</body>
</html>
