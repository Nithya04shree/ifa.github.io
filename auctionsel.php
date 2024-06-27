<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction | Suppliers | IFA</title>
    <link rel="stylesheet" href="auctionsel.css?v=1.0">
    <link rel="stylesheet" href="sellernav.css?v=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body style="background-color: #fbe8ec;">
<div class="box">
        <div class="leftbox">
            <a href="sellerfile.html" class="heading">SUPPLIERS</a>
            <div class="box1">
            <a href="http://localhost/dbms/flowersel.php" id="l1">Flowers</a><br><br><br>
            <a href="http://localhost/dbms/auctionsel.php" id="l2">Auctions</a><br><br><br>
            <a href="http://localhost/dbms/salessel.php" id="l3">Sales</a><br><br><br>
            </div>
            <a href="http://localhost/dbms/home.html" id="logout">LOGOUT</a>
        </div>
        <div class="rightbox">
            <!-- query 1 -->
            <!-- find most popular flower variety -->
            <h1>Most Popular Flower Variety</h1>
            <canvas id="popularFlowerChart" width="800" height="400"></canvas>
            
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
        
            $query = "SELECT v.varietyName, f.name AS flowerName, COUNT(a.auctionId) AS auctioncount
                      FROM varieties v, flowers f, auctions a
                      WHERE v.flowerId=f.flowerId AND v.varietyId=a.varietyId
                      GROUP BY v.varietyId, f.name
                      ORDER BY auctioncount DESC";
            $result = $conn->query($query);
        
            $varietyNames = [];
            $auctionCounts = [];
        
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $varietyNames[] = $row["varietyName"] . " (" . $row["flowerName"] . ")";
                    $auctionCounts[] = $row["auctioncount"];
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
            <!-- end of query 1 -->
             
            <br><br>

            <!-- query 4 -->
            <!-- find average starting price of varieties by flower -->
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
            <!-- end of query 4 -->
        </div>
    </div>
    <script>
        const ctx = document.getElementById('popularFlowerChart').getContext('2d');
        const popularFlowerChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($varietyNames); ?>,
                datasets: [{
                    label: 'Auction Count',
                    data: <?php echo json_encode($auctionCounts); ?>,
                    backgroundColor: 'rgb(255, 179, 193, 0.6)',
                    borderColor: '#800f2f',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
