<?php
$mysqli = new mysqli("localhost", "absenpkl_db", "t_p:X5NTz#w_]/dH", "absenpkl_db");

// Check connection
if ($mysqli->connect_error) {
    die("Koneksi database gagal: " . $mysqli->connect_error);
}

// Retrieve and sanitize input data
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
$type = isset($_POST['type']) ? $_POST['type'] : null;
$time = isset($_POST['time']) ? $_POST['time'] : null;
$image_data = isset($_POST['image_data']) ? $_POST['image_data'] : null;
$date = date('Y-m-d');

// Validate required input data
if (!$user_id || !$type || !$time || !$image_data) {
    die("Input data tidak lengkap: user_id, type, time, dan image_data harus ada.");
}

// Convert time to 24-hour format
$time = date("H:i:s", strtotime($time));

// Decode the base64 image data and save it as a file
$image_name = 'uploads/' . uniqid() . '.png';
$image_data = str_replace('data:image/png;base64,', '', $image_data);
$image_data = str_replace(' ', '+', $image_data);
$image_content = base64_decode($image_data);

// Check if image decoding was successful
if ($image_content === false) {
    die("Gagal mendekode data gambar.");
}

if (file_put_contents($image_name, $image_content) === false) {
    die("Gagal menyimpan gambar ke server.");
}

// Prepare SQL statement to save the attendance record
$stmt = $mysqli->prepare("INSERT INTO attendance (user_id, type, date, time, image_path) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Gagal mempersiapkan statement SQL: " . $mysqli->error);
}

$stmt->bind_param("issss", $user_id, $type, $date, $time, $image_name);

// Execute the SQL statement
if ($stmt->execute()) {
    // Check if the insert operation was successful
    if ($stmt->affected_rows > 0) {
        header("Location: index.php?status=success");
    } else {
        die("Data tidak berhasil disimpan: " . $stmt->error);
    }
} else {
    die("Gagal mengeksekusi statement SQL: " . $stmt->error);
}

// Close the statement and database connection
$stmt->close();
$mysqli->close();
?>

