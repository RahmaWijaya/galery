<?php
session_start();
session_destroy(); // Menghancurkan session
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - SMKN 4 BOGOR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animasi untuk Fade-In */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Efek Hover pada Tombol */
        .hover-transition {
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .hover-transition:hover {
            transform: scale(1.1); /* Zoom in sedikit saat hover */
            background-color: #2d3748; /* Ganti warna latar belakang saat hover */
        }

        /* Animasi Kontainer */
        .container {
            height: 100vh; /* Mengatur tinggi penuh viewport */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Animasi fade-in pada konten */
        .content {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .content.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center">

    <div class="container flex flex-col items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center content fade-in">
            <h1 class="text-2xl font-bold text-black mb-4 fade-in">Anda Telah Logout</h1>
            <p class="text-gray-600 mb-4 fade-in">Terima kasih telah menggunakan layanan kami.</p>
            <p class="text-gray-600 mb-4 fade-in">Silakan kembali ke halaman profil atau login kembali.</p>
            <a href="profile.php" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 hover-transition fade-in">Kembali ke Beranda</a>
        </div>
    </div>

    <script>
        // Menambahkan kelas 'visible' ke elemen dengan kelas fade-in setelah halaman dimuat
        window.addEventListener('DOMContentLoaded', () => {
            const fadeInElements = document.querySelectorAll('.fade-in');
            fadeInElements.forEach((el, index) => {
                setTimeout(() => el.classList.add('visible'), (index + 1) * 300); // Menambahkan delay pada setiap elemen
            });
        });
    </script>
</body>
</html>
