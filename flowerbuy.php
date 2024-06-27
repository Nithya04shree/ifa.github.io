<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flowers | Buyers | IFA</title>
    <link rel="stylesheet" href="flowerbuy.css?v=1.0">
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
        <!-- query 1 -->
         <!-- most popular flower variety -->
        <h2>Most Popular Flower Variety</h2>
    <canvas id="popularFlowerChart" width="150" height="75"></canvas>
    
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
    <!-- end query 1 -->
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
