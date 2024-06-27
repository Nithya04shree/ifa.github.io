<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction | Buyers | IFA</title>
    <link rel="stylesheet" href="auctionbuy.css?v=1.0">
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

        <!-- query 5 -->
        <!-- Query to get total number of auctions held in last month -->
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
        $query = "SELECT COUNT(a.auctionId) AS AuctionCount
        FROM auctions a
        WHERE a.startTime >= Date_Sub(CURRENT_DATE(), INTERVAL 30 day)";
        
        $result = $conn->query($query);
        echo "<h2 id='head'>Total Number of Auctions Held in Last Month</h2>";
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<p id='res'>Total Auctions: " . $row["AuctionCount"]. "</p>";
        } else {
            echo "0 results";
        }
        ?>
        <!-- end query 5 -->


        <br>

        <!-- query 6 -->
        <!-- Query to get the most recent auctions for each variety -->
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
        $query = "SELECT v.varietyName, f.name AS FlowerName, MAX(a.startTime) AS MostRecentAuction
        FROM auctions a
        JOIN varieties v ON a.varietyId=v.varietyId
        JOIN flowers f ON v.flowerId=f.flowerId
        GROUP BY v.varietyId
        ORDER BY MostRecentAuction DESC";
        
        $result = $conn->query($query);
        echo "<h2 id='head'>Most Recent Auction for Each Variety</h2>";
        if ($result->num_rows > 0) {
            echo "<table><tr><th>Variety Name</th><th>Flower Name</th><th>Most Recent Auction</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["varietyName"]. "</td><td>" . $row["FlowerName"]. "</td><td>" . $row["MostRecentAuction"]. "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
        ?>
        <!-- end query 6 -->

        </div>
    </div>
</body>
</body>
</html>
