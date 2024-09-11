<?php
$mysqli = new mysqli("localhost", "absenpkl_db", "t_p:X5NTz#w_]/dH", "absenpkl_db");

// Periksa koneksi
if ($mysqli->connect_error) {
    die("Koneksi database gagal: " . $mysqli->connect_error);
}

$date_filter = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$type_filter = isset($_GET['type']) ? $_GET['type'] : '';

// Persiapkan SQL dengan filter dan urutkan berdasarkan waktu (ascending)
$sql = "SELECT u.name, a.type, a.date, a.time, a.image_path, 
               CASE 
                   WHEN a.type = 'datang' AND TIME(a.time) > '08:15:00' THEN 'Telat'
                   ELSE 'Tepat Waktu'
               END AS status 
        FROM attendance a 
        JOIN users u ON a.user_id = u.id 
        WHERE a.date = ?";

if ($type_filter) {
    $sql .= " AND a.type = ?";
}

$sql .= " ORDER BY a.time ASC"; // Tambahkan ORDER BY untuk mengurutkan berdasarkan waktu

$stmt = $mysqli->prepare($sql);

if ($type_filter) {
    $stmt->bind_param("ss", $date_filter, $type_filter);
} else {
    $stmt->bind_param("s", $date_filter);
}

$stmt->execute();
$result = $stmt->get_result();

// Periksa apakah pengguna meminta unduhan dalam format Excel
if (isset($_GET['download']) && $_GET['download'] == 'excel') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="laporan_presensi_' . $date_filter . '.xls"');

    // Output header tabel
    echo "Nama\tJenis Presensi\tTanggal\tWaktu\tStatus\tFoto\n";

    // Output data baris
    while ($row = $result->fetch_assoc()) {
        // Format tanggal ke format "d F Y" (misalnya, "31 Agustus 2024")
        $formatted_date = strftime('%d %B %Y', strtotime($row['date']));
        
        echo htmlspecialchars($row['name']) . "\t" .
             htmlspecialchars($row['type']) . "\t" .
             htmlspecialchars($formatted_date) . "\t" .
             htmlspecialchars($row['time']) . "\t" .
             htmlspecialchars($row['status']) . "\t" .
             htmlspecialchars($row['image_path']) . "\n";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Presensi</title>
    <style>
        /* Style CSS */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            text-align: center;
        }

        h1 {
            margin-top: 20px;
            color: #333;
        }

        form {
            margin: 20px;
        }

        input[type="date"], select {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
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

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }

        /* Style untuk status Telat */
        td.telat {
            background-color: #ffeb3b; /* Warna kuning untuk 'Telat' */
        }

        /* Style untuk pesan alert */
        .alert {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .alert.success {
            background-color: #4CAF50;
        }

        .alert.error {
            background-color: #f44336;
        }

        .alert.info {
            background-color: #2196F3;
        }

        .alert .closebtn {
            margin-left: 15px;
            font-size: 20px;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
        }

        .alert .closebtn:hover {
            color: #ddd;
        }
    </style>
</head>
<body>
    <h1>Laporan PKL Teknokrat</h1>

    <form method="get" action="laporanpresensi.php">
        <label for="date">Pilih Tanggal:</label>
        <input type="date" name="date" value="<?= htmlspecialchars($date_filter); ?>">
        
        <label for="type">Jenis Presensi:</label>
        <select name="type">
            <option value="">Semua</option>
            <option value="datang" <?= $type_filter == 'datang' ? 'selected' : '' ?>>Datang</option>
            <option value="pulang" <?= $type_filter == 'pulang' ? 'selected' : '' ?>>Pulang</option>
        </select>

        <button type="submit">Filter</button>
        <button type="submit" name="download" value="excel">Unduh Laporan</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jenis Presensi</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { 
                // Format tanggal ke format "d F Y" (misalnya, "31 Agustus 2024")
                $formatted_date = strftime('%d %B %Y', strtotime($row['date']));
                $status_class = $row['status'] === 'Telat' ? 'telat' : '';
            ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['type']); ?></td>
                    <td><?= htmlspecialchars($formatted_date); ?></td>
                    <td><?= htmlspecialchars($row['time']); ?></td>
                    <td class="<?= htmlspecialchars($status_class); ?>">
                        <?= htmlspecialchars($row['status']); ?>
                    </td>
                    <td>
                        <?php if ($row['image_path']) { ?>
                            <img src="<?= htmlspecialchars($row['image_path']); ?>" alt="Foto Presensi">
                        <?php } else { ?>
                            Tidak ada foto
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Pesan Alert -->
    <div id="alert" class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <span id="alert-message"></span>
    </div>

    <script>
        // Fungsi untuk menampilkan pesan alert
        function showAlert(message, type) {
            var alertBox = document.getElementById('alert');
            alertBox.className = 'alert ' + type;
            document.getElementById('alert-message').textContent = message;
            alertBox.style.display = 'block';
        }

        // Contoh penggunaan fungsi showAlert
        // showAlert('Data berhasil disimpan!', 'success');
        // showAlert('Terjadi kesalahan saat menyimpan data.', 'error');
    </script>
</body>
</html>

<?php
$stmt->close();
$mysqli->close();
?>

