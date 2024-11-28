<?php
session_start(); // Memulai session

// Cek apakah pengguna sudah login
$isLoggedIn = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SMKN 4 BOGOR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        /* Efek transisi dan delay pada elemen navigasi */
        nav a {
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        nav a:nth-child(1) {
            transition-delay: 0.2s;
        }

        nav a:nth-child(2) {
            transition-delay: 0.4s;
        }

        nav a:nth-child(3) {
            transition-delay: 0.6s;
        }

        nav a:nth-child(4) {
            transition-delay: 0.8s;
        }

        nav a.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Efek Fade-In untuk konten utama */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Gambar dengan efek hover */
        .image-shadow {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .image-shadow:hover {
            transform: scale(1.05); /* Zoom in sedikit saat hover */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Efek bayangan */
        }

        /* Efek modal gambar */
        .modal-image {
            max-width: 90%;
            max-height: 80%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .image-modal-close {
            position: absolute;
            top: 5px;
            right: 5px;
            font-size: 30px;
            color: white;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 50%;
            padding: 5px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .image-modal-close:hover {
            transform: scale(1.2); /* Memperbesar tombol close saat hover */
        }
    </style>
</head>
<body class="bg-gray-100">
    <header class="bg-black shadow-lg">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center">
                <img alt="School Logo" class="h-10 w-10 mr-3 fade-in" src="logo1.png" />
                <h1 class="text-2xl font-bold text-white fade-in">SMKN 4 BOGOR</h1>
            </div>
            <nav class="flex items-center space-x-4">
                <a class="text-gray-300 hover:text-white fade-in" href="beranda.php">Beranda</a>
                <a class="text-gray-300 hover:text-white fade-in" href="berita.php">Galeri</a>
                <a class="text-white font-semibold fade-in" href="tentangkami.php">Tentang Kami</a>
                <?php if ($isLoggedIn): ?>
                    <a href="logout.php" class="text-red-400 hover:underline fade-in">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="text-white hover:underline fade-in">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6 fade-in">
            <h2 class="text-2xl font-bold mb-4">SMKN 4 Bogor</h2>
            <p class="mb-4">
                Merupakan sekolah kejuruan berbasis Teknologi Informasi dan Komunikasi. Sekolah ini didirikan dan dirintis pada tahun 2008 kemudian dibuka pada tahun 2009 yang saat ini terakreditasi A. Terletak di Jalan Raya Tajur Kp. Buntar, Muarasari, Bogor, sekolah ini berdiri di atas lahan seluas 12.724 m2 dengan berbagai fasilitas pendukung di dalamnya. Terdapat 54 staff pengajar dan 22 orang staff tata usaha, dikepalai oleh Drs. Mulya Mulpirhartono, M. Si, sekolah ini merupakan investasi pendidikan yang tepat untuk putra/putri anda.
            </p>
            <h3 class="text-xl font-bold mb-2">Visi :</h3>
            <p class="mb-4">
                Terwujudnya SMK Pusat Keunggulan melalui terciptanya pelajar pancasila yang berbasis teknologi, berwawasan lingkungan dan berkewirausahaan.
            </p>
            <h3 class="text-xl font-bold mb-2">Misi :</h3>
            <ol class="list-decimal list-inside space-y-2 mb-4">
                <li>Mewujudkan karakter pelajar pancasila beriman dan bertaqwa kepada Tuhan Yang Maha Esa dan berakhlak mulia, berkebhinekaan global, gotong royong, mandiri, kreatif dan bernalar kritis.</li>
                <li>Mengembangkan pembelajaran dan pengelolaan sekolah berbasis Teknologi Informasi dan Komunikasi.</li>
                <li>Mengembangkan sekolah unggul yang adaptif dengan berbagai perubahan dan kemajuan.</li>
            </ol>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md fade-in">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-3/4 md:pr-6 mb-4 md:mb-0">
                    <h2 class="text-xl font-bold mb-2">Kepala Sekolah</h2>
                    <p class="text-gray-800 leading-relaxed">
                        Sejak satu tahun lalu SMKN 4 Kota Bogor dipimpin oleh seseorang yang membawa warna baru. Tahun pertama sejak dilantik, tepatnya pada tanggal 10 Juli 2020, inovasi dan kebijakan-kebijakan baru pun mulai dirancang. Bukan tanpa kesulitan, penuh tantangan tapi beliau meyakinkan untuk selalu optimis pada harapan dengan bersinergi mewujudkan visi misi SMKN 4 Bogor ditengah kesulitan pandemi ini. Strategi baru pun dimunculkan, beberapa program sudah terealisasikan diantaranya mengembangkan aplikasi LMS (Learning Management System) sebagai solusi dalam pelaksanaan program BDR (Belajar dari Rumah), untuk mengoptimalkan hubungan kerjasama antara sekolah dengan Industri dan Dunia Kerja (IDUKA), dan juga untuk pengalaman praktek belajar jarak jauh agar tetap berjalan dengan optimal.
                    </p>
                </div>
                <div class="md:w-1/4">
                    <img alt="Drs. Mulya Murprihartono, M.Si." class="rounded-md mb-2 w-full h-auto image-shadow" src="kepsek.jpg" />
                    <p class="text-center text-gray-800">Drs. Mulya Murprihartono, M.Si.</p>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Menambahkan kelas 'visible' ke elemen navigasi setelah waktu tertentu
        window.addEventListener('DOMContentLoaded', () => {
            const navLinks = document.querySelectorAll('nav a');
            setTimeout(() => navLinks[0].classList.add('visible'), 200); // Beranda
            setTimeout(() => navLinks[1].classList.add('visible'), 400); // Galeri
            setTimeout(() => navLinks[2].classList.add('visible'), 600); // Tentang Kami
            setTimeout(() => navLinks[3].classList.add('visible'), 800); // Login/Logout

            // Menambahkan kelas 'visible' ke elemen dengan kelas fade-in
            const fadeInElements = document.querySelectorAll('.fade-in');
            fadeInElements.forEach((el, index) => {
                setTimeout(() => el.classList.add('visible'), (index + 1) * 200);
            });
        });
    </script>
</body>
</html>
