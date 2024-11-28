<?php
session_start(); // Memulai session

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    http_response_code(403);
    echo json_encode(['message' => 'Unauthorized']);
    exit;
}

// Tentukan direktori target untuk unggahan
$targetDir = "uploads/";
$imagesFile = 'images.json';
$images = [];

// Ambil gambar yang ada jika file ada
if (file_exists($imagesFile)) {
    $images = json_decode(file_get_contents($imagesFile), true);
}

// Proses unggah gambar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $targetFile = $targetDir . basename($_FILES['image']['name']);
    $description = $_POST['description'];

    // Cek apakah file adalah gambar
    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check !== false) {
        // Pindahkan file ke direktori tujuan
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Simpan data gambar
            $images[] = [
                'url' => $targetFile,
                'description' => $description
            ];
            // Simpan kembali ke file JSON
            file_put_contents($imagesFile, json_encode($images));

            // Kirim respons sukses
            http_response_code(200);
            echo json_encode(['message' => 'Image uploaded successfully']);
            exit;
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'File is not an image']);
    }
} else {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid request']);
}
?>
