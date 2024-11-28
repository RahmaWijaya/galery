<?php
session_start(); // Memulai session

// Cek apakah pengguna sudah login
$isLoggedIn = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMKN 4 BOGOR - Berita Terbaru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        /* CSS untuk modal gambar */
        #image-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        #image-modal img {
            max-width: 90%;
            max-height: 90%;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        /* Animasi untuk ikon like */
        .like-icon {
            transition: transform 0.3s ease, color 0.3s ease;
        }
        .like-icon:hover {
            transform: scale(1.2);
            color: red;
        }

        /* Efek klik pada gambar berita */
        .news-image {
            transition: transform 0.3s ease;
        }

        .news-image:active {
            transform: scale(0.98);
        }

        /* Efek transisi dan delay pada navigasi */
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

        /* Menambahkan efek delay pada elemen gambar, teks dan konten lainnya */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Delay untuk gambar */
        .img-delay {
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .img-delay.visible {
            opacity: 1;
            transform: scale(1);
        }

        /* Delay untuk setiap elemen dalam berita */
        .news-item {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .news-item.visible {
            opacity: 1;
            transform: translateY(0);
        }

    </style>
</head>
<body class="bg-gray-100">
    <header class="bg-black shadow-lg">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center">
                <img alt="SMKN 4 Bogor Logo" class="h-10 w-10 img-delay" src="logo1.png" />
                <h1 class="ml-2 text-2xl font-bold text-white fade-in">SMKN 4 BOGOR</h1>
            </div>
            
            <nav class="flex space-x-6">
                <a class="text-white hover:underline fade-in" href="beranda.php">Beranda</a>
                <a class="text-white hover:underline fade-in" href="berita.php">Galeri</a>
                <a class="text-white hover:underline fade-in" href="tentangkami.php">Tentang Kami</a>
                <?php if ($isLoggedIn): ?>
                    <a href="logout.php" class="text-red-400 hover:underline fade-in">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="text-white hover:underline fade-in">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Modal Gambar -->
    <div id="image-modal" class="fixed inset-0 flex">
        <img id="modal-image" alt="Gambar Besar" class="rounded-lg img-delay" />
        <button onclick="closeImageModal()" class="absolute top-5 right-5 text-white text-3xl">✖</button>
    </div>

    <main class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="col-span-1">
                <div class="bg-white shadow-lg rounded-lg p-6 fade-in">
                    <img alt="School Image" class="w-full rounded-lg mb-4 img-delay" src="images.jpg" />
                    <div class="text-center fade-in">
                        <img alt="School Logo" class="mx-auto mb-4 img-delay" src="images2.jpg" />
                        <h2 class="text-2xl font-bold">SMKN 4 Bogor</h2>
                        <p class="text-gray-600">KR4BAT (Kejuruan Empat Hebat)</p>
                        <p class="text-gray-600">Akhlak Terpuji Ilmu Terlaji Terampil dan Teruji</p>
                    </div>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-4 mt-8 fade-in">
                    <h3 class="text-lg font-bold mb-4">Lokasi</h3>
                    <img alt="Map Image" class="w-full rounded-lg img-delay" src="lokasi.png" />
                    <p class="text-gray-800 mt-2">SMK Negeri 4 Bogor (Nebraska)</p>
                    <a class="text-blue-600 hover:underline" href="https://www.google.com/maps" target="_blank">Lihat peta lebih besar</a>
                </div>
            </div>

            <div class="col-span-2">
                <div class="bg-white shadow-lg rounded-lg p-6 fade-in">
                    <h3 class="text-lg font-bold mb-4">Berita Terbaru</h3>
                    <div class="border rounded-lg p-4 news-item">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <img alt="Instagram Profile Image" class="h-10 w-10 rounded-full img-delay" src="logo1.png" />
                                <div class="ml-2">
                                    <p class="font-bold">Admin</p>
                                    <p class="text-gray-600">Bogor, Indonesia</p>
                                </div>
                            </div>
                        </div>
                        <!-- Gambar berita dengan efek klik -->
                        <img id="news-image" alt="News Image" class="w-full rounded-lg mb-4 cursor-pointer news-image img-delay" src="ig.png" onclick="openImageModal(this.src)" />
                        <p class="text-gray-600 mb-4">RANTANG PRAMUKA SMKN 4 BOGOR DALAM KEGIATAN SMARTTREN 2023</p>
                        <div class="flex items-center justify-between mt-4">
                            <div class="flex items-center space-x-2">
                                <!-- Ikon like dengan efek hover -->
                                <i id="like-icon" class="far fa-heart cursor-pointer like-icon" onclick="toggleLike()"></i>
                                <p id="like-count">332 likes</p>
                            </div>
                            <p class="text-gray-600">Admin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Fungsi untuk membuka modal gambar dengan animasi
        function openImageModal(src) {
            const modal = document.getElementById('image-modal');
            const modalImage = document.getElementById('modal-image');
            
            modal.style.display = 'flex';
            setTimeout(() => {
                modal.style.opacity = 1; // Fade-in modal
                modalImage.style.transform = 'scale(1)'; // Animasi zoom-in gambar
            }, 10);
            
            modalImage.src = src;
        }

        // Fungsi untuk menutup modal gambar dengan animasi
        function closeImageModal() {
            const modal = document.getElementById('image-modal');
            const modalImage = document.getElementById('modal-image');
            
            modal.style.opacity = 0; // Fade-out modal
            modalImage.style.transform = 'scale(0.9)'; // Animasi zoom-out gambar
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        // Fungsi untuk toggle like dengan efek
        function toggleLike() {
            const likeIcon = document.getElementById('like-icon');
            const likeCount = document.getElementById('like-count');

            if (likeIcon.classList.contains('far')) {
                likeIcon.classList.remove('far');
                likeIcon.classList.add('fas');
                likeCount.textContent = "333 likes"; // Update jumlah like
            } else {
                likeIcon.classList.remove('fas');
                likeIcon.classList.add('far');
                likeCount.textContent = "332 likes"; // Update kembali jumlah like
            }
        }

        // Menambahkan kelas 'visible' ke elemen navigasi setelah waktu tertentu
        window.addEventListener('DOMContentLoaded', () => {
            const navLinks = document.querySelectorAll('nav a');
            setTimeout(() => navLinks[0].classList.add('visible'), 200); // Beranda
            setTimeout(() => navLinks[1].classList.add('visible'), 400); // Galeri
            setTimeout(() => navLinks[2].classList.add('visible'), 600); // Tentang Kami
            setTimeout(() => navLinks[3].classList.add('visible'), 800); // Login/Logout

            // Menambahkan 'visible' pada gambar dan berita
            const imgElements = document.querySelectorAll('.img-delay');
            imgElements.forEach((img, index) => {
                setTimeout(() => img.classList.add('visible'), index * 200);
            });

            const newsItems = document.querySelectorAll('.news-item');
            newsItems.forEach((item, index) => {
                setTimeout(() => item.classList.add('visible'), (index + 1) * 200);
            });

            const fadeInElements = document.querySelectorAll('.fade-in');
            fadeInElements.forEach((el, index) => {
                setTimeout(() => el.classList.add('visible'), (index + 1) * 200);
            });
        });
    </script>
    
    <footer class="bg-black text-white py-6 mt-8">
        <div class="container mx-auto px-4 text-center">
            <p class="mt-4">&copy; 2024 SMKN 4 Bogor. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
