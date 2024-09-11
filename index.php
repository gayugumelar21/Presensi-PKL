<?php
// Connect to the database
$mysqli = new mysqli("localhost", "absenpkl_db", "t_p:X5NTz#w_]/dH", "absenpkl_db");

// Check connection
if ($mysqli->connect_error) {
    die("Koneksi database gagal: " . $mysqli->connect_error);
}

// Fetch users and order by name ascending
$result = $mysqli->query("SELECT * FROM users ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        h1 {
            margin-top: 20px;
            color: #333;
        }

        .container {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .card {
            width: 200px;
            padding: 20px;
            border-radius: 10px;
            margin: 10px;
            text-align: center;
            color: #fff;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .card.green {
            background-color: #4CAF50;
        }

        .card.red {
            background-color: #f44336;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .time-display {
            margin-top: 10px;
            font-size: 18px;
        }

        .select-container {
            margin-top: 20px;
        }

        select {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .video-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        video, canvas {
            display: block;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        /* Alert Styles */
        .alert {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 15px;
            border-radius: 10px;
            color: #fff;
            font-size: 16px;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeInOut 5s forwards;
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

        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translate(-50%, -60%);
            }
            10%, 90% {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
            100% {
                opacity: 0;
                transform: translate(-50%, -40%);
            }
        }
    </style>
</head>
<body>
    <h1>Presensi PKL Teknokrat</h1>

    <div class="video-container">
        <video id="video" width="320" height="240" autoplay></video>
        <canvas id="canvas" width="320" height="240"></canvas>
    </div>

    <div class="select-container">
        <form id="attendanceForm" method="post" action="save_attendance.php" enctype="multipart/form-data">
            <label for="user">Pilih Nama:</label>
            <select name="user_id" id="user">
                <?php while($row = $result->fetch_assoc()) { ?>
                    <option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
                <?php } ?>
            </select>

            <!-- Hidden fields to store attendance data -->
            <input type="hidden" name="type" id="type">
            <input type="hidden" name="time" id="time">
            <input type="hidden" name="image_data" id="image_data">
        </form>
    </div>

    <div class="container">
        <div class="card green" onclick="markAttendance('Datang')">
            <h2>Datang</h2>
            <div class="time-display" id="datangTime">Pukul - WIB</div>
        </div>
        <div class="card red" onclick="markAttendance('Pulang')">
            <h2>Pulang</h2>
            <div class="time-display" id="pulangTime">Pukul - WIB</div>
        </div>
    </div>

    <!-- Alert Box -->
    <div id="alertBox" class="alert">
        <span class="closebtn" onclick="closeAlert()">&times;</span>
        <span id="alertMessage">Alert message goes here</span>
    </div>

    <script>
        function markAttendance(type) {
            const timeDisplay = type === 'Datang' ? 'datangTime' : 'pulangTime';
            const currentTime = new Date().toLocaleTimeString();
            
            document.getElementById(timeDisplay).textContent = 'Pukul ' + currentTime + ' WIB';
            document.getElementById('type').value = type;
            document.getElementById('time').value = currentTime;

            // Start the camera
            const video = document.getElementById('video');
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(stream) {
                    video.srcObject = stream;
                    video.style.display = 'block';

                    // Capture image after a short delay to give time for the camera to focus
                    setTimeout(function() {
                        captureImage();
                    }, 1000);
                })
                .catch(function(error) {
                    console.error("Error accessing camera: ", error);
                    showAlert('error', 'Gagal mengakses kamera. Pastikan izin kamera diizinkan.');
                });
        }

        function captureImage() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');

            // Draw the video frame to the canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Get the data URL of the image
            const imageData = canvas.toDataURL('image/png');
            document.getElementById('image_data').value = imageData;

            // Stop all video streams
            video.srcObject.getTracks().forEach(track => track.stop());

            // Submit the form
            document.getElementById('attendanceForm').submit();
        }

        function showAlert(type, message) {
            const alertBox = document.getElementById('alertBox');
            const alertMessage = document.getElementById('alertMessage');
            alertBox.className = `alert ${type}`;
            alertMessage.textContent = message;
            alertBox.style.display = 'block';

            // Automatically hide the alert after the animation completes
            setTimeout(function() {
                alertBox.style.display = 'none';
            }, 5000);
        }

        function closeAlert() {
            document.getElementById('alertBox').style.display = 'none';
        }

        <?php if (isset($_GET['status']) && $_GET['status'] == 'success') { ?>
            showAlert('success', 'Berhasil Presensi');
        <?php } ?>
    </script>
</body>
</html>

