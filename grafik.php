<?php
$mysqli = new mysqli("localhost", "absenpkl_db", "t_p:X5NTz#w_]/dH", "absenpkl_db");

// Periksa koneksi
if ($mysqli->connect_error) {
    die("Koneksi database gagal: " . $mysqli->connect_error);
}

$month_filter = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
$sql = "SELECT u.name, 
               SUM(CASE WHEN a.type = 'datang' THEN 1 ELSE 0 END) AS datang_count, 
               SUM(CASE WHEN a.type = 'pulang' THEN 1 ELSE 0 END) AS pulang_count 
        FROM attendance a 
        JOIN users u ON a.user_id = u.id 
        WHERE DATE_FORMAT(a.date, '%Y-%m') = ? 
        GROUP BY u.name";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $month_filter);
$stmt->execute();
$result = $stmt->get_result();

$names = [];
$datang_counts = [];
$pulang_counts = [];

while ($row = $result->fetch_assoc()) {
    $names[] = $row['name'];
    $datang_counts[] = $row['datang_count'];
    $pulang_counts[] = $row['pulang_count'];
}

$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Laporan Bulanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
        }

        form {
            margin-bottom: 30px;
        }

        input[type="month"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
            margin-right: 10px;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .chart-container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Grafik Laporan Bulanan</h1>

    <form method="get" action="grafik.php">
        <label for="month">Pilih Bulan:</label>
        <input type="month" name="month" value="<?= htmlspecialchars($month_filter); ?>">
        <button type="submit">Tampilkan Grafik</button>
    </form>

    <div class="chart-container">
        <canvas id="barChart"></canvas>
    </div>

    <script>
        var ctxBar = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: <?= json_encode($names); ?>,
                datasets: [
                    {
                        label: 'Datang',
                        data: <?= json_encode($datang_counts); ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Pulang',
                        data: <?= json_encode($pulang_counts); ?>,
                        backgroundColor: 'rgba(153, 102, 255, 0.6)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
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
