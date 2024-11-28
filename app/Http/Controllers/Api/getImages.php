<?php
session_start(); // Memulai session

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    http_response_code(403);
    echo json_encode(['message' => 'Unauthorized']);
    exit;
}

$imagesFile = 'images.json';

// Cek apakah file gambar ada dan kembalikan isinya
if (file_exists($imagesFile)) {
    $images = json_decode(file_get_contents($imagesFile), true);
    http_response_code(200);
    echo json_encode($images);
} else {
    http_response_code(404);
    echo json_encode(['message' => 'No images found']);
}
?>
