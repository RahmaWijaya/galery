<?php
session_start(); // Memulai session

// Cek apakah pengguna sudah login
$isLoggedIn = isset($_SESSION['username']);

// File untuk menyimpan data gambar
$imagesFile = 'images.json';
$images = [];

// Ambil gambar dari file jika ada
if (file_exists($imagesFile)) {
    $images = json_decode(file_get_contents($imagesFile), true);
}

// Menangani filter kategori yang dipilih
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';  // Menambahkan pencarian
$filteredImages = [];

if ($selectedCategory || $searchKeyword) {
    // Filter gambar berdasarkan kategori dan pencarian
    foreach ($images as $image) {
        $matchesCategory = $selectedCategory ? $image['category'] === $selectedCategory : true;
        $matchesSearch = $searchKeyword ? stripos($image['description'], $searchKeyword) !== false : true;
        
        if ($matchesCategory && $matchesSearch) {
            $filteredImages[] = $image;
        }
    }
} else {
    // Jika tidak ada kategori atau pencarian, tampilkan semua gambar
    $filteredImages = $images;
}

// Proses unggah gambar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $targetDir = "uploads/"; // Pastikan folder ini ada dan dapat ditulis
    $targetFile = $targetDir . basename($_FILES['image']['name']);
    $description = $_POST['description'];
    $category = $_POST['category']; // Mengambil kategori dari form

    // Cek apakah file adalah gambar
    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check !== false) {
        // Pindahkan file ke folder tujuan
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Simpan data gambar ke dalam array
            $images[] = [
                'url' => $targetFile,
                'description' => $description,
                'category' => $category // Menyimpan kategori gambar
            ];
            // Simpan kembali ke file JSON
            file_put_contents($imagesFile, json_encode($images));
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri - SMKN 4 BOGOR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        .separator {
            border-top: 3px solid rgba(0, 0, 0, 0.3);
            margin: 0.5rem 0;
        }

        /* Efek shadow dan zoom pada gambar */
        .image-shadow {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .image-shadow:hover {
            transform: scale(1.05);
        }

        /* Gambar thumbnail dengan efek transisi */
        .thumbnail {
            max-width: 100%;
            max-height: 200px;
            height: auto;
            transition: transform 0.3s ease;
        }

        /* Kontainer gambar dengan efek hover */
        .image-container {
            padding: 1rem;
            border-radius: 0.5rem;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .image-container:hover {
            transform: translateY(-5px);
        }

        /* Modal gambar */
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
            transform: scale(1.2);
        }

        /* Efek transisi pada kategori dan pencarian */
        .transition-category {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .transition-category:hover {
            background-color: #444;
            color: white;
        }

        /* Input pencarian dengan transisi */
        .search-input {
            transition: background-color 0.3s ease;
        }

        .search-input:focus {
            background-color: #f1f1f1;
        }

        /* Efek delay pada elemen fade-in */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gray-100">
    <header class="bg-black shadow-lg">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center">
                <img alt="SMKN 4 BOGOR Logo" class="h-10 w-10 fade-in" src="logo1.png" />
                <h1 class="ml-3 text-2xl font-bold text-white fade-in">SMKN 4 BOGOR</h1>
            </div>
            <nav class="flex items-center space-x-4">
                <a class="text-gray-300 hover:text-white fade-in" href="beranda.php">Beranda</a>
                <a class="text-white border-b-2 border-white fade-in" href="berita.php">Galeri</a>
                <a class="text-gray-300 hover:text-white fade-in" href="tentangkami.php">Tentang Kami</a>
                <?php if ($isLoggedIn): ?>
                    <a href="logout.php" class="text-red-400 hover:underline fade-in">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="text-white hover:underline fade-in">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Form Unggah Gambar -->
    <?php if ($isLoggedIn): ?>
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-xl font-bold mb-4 fade-in">Unggah Gambar</h2>
        <form action="" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow fade-in">
            <input type="file" name="image" required class="border border-gray-300 p-2 mb-4 w-full rounded" />
            <textarea name="description" placeholder="Deskripsi gambar" required class="border border-gray-300 p-2 mb-4 w-full rounded" rows="4"></textarea>
            
            <!-- Input untuk kategori -->
            <select name="category" required class="border border-gray-300 p-2 mb-4 w-full rounded">
                <option value="" disabled selected>Pilih Kategori</option>
                <option value="Logo">Logo</option>
                <option value="Halaman">Halaman</option>
                <option value="Kegiatan">Kegiatan</option>
            </select>
            
            <button type="submit" class="bg-black text-white p-2 rounded hover:bg-gray-800 transition">Unggah</button>
        </form>
    </div>
    <?php endif; ?>

    <!-- Form Pencarian -->
    <div class="container mx-auto px-4 py-6">
        <form action="" method="GET" class="bg-white p-4 rounded shadow fade-in">
            <div class="flex gap-4">
                <input id="searchInput" type="text" name="search" value="<?php echo htmlspecialchars($searchKeyword); ?>" placeholder="Cari Gambar..." class="search-input border border-gray-300 p-2 w-full rounded" />
                <button type="submit" class="bg-black text-white p-2 rounded hover:bg-gray-800 transition">Cari</button>
            </div>
            <select name="category" onchange="this.form.submit()" class="transition-category border border-gray-300 p-2 mt-4 w-full rounded">
                <option value="" <?php echo $selectedCategory == '' ? 'selected' : ''; ?>>Tampilkan Semua</option>
                <option value="Logo" <?php echo $selectedCategory == 'Logo' ? 'selected' : ''; ?>>Logo</option>
                <option value="Halaman" <?php echo $selectedCategory == 'Halaman' ? 'selected' : ''; ?>>Halaman</option>
                <option value="Kegiatan" <?php echo $selectedCategory == 'Kegiatan' ? 'selected' : ''; ?>>Kegiatan</option>
            </select>
        </form>
    </div>

    <!-- Galeri Gambar -->
    <main class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-bold mb-6 fade-in">Galeri Sekolah</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php if (!empty($filteredImages)): ?>
                <?php foreach ($filteredImages as $image): ?>
                    <div class="image-container fade-in">
                        <img alt="Uploaded Image" class="thumbnail rounded-t-lg cursor-pointer image-shadow" src="<?php echo htmlspecialchars($image['url']); ?>" onclick="openImageModal('<?php echo htmlspecialchars($image['url']); ?>')" />
                        <div class="separator"></div>
                        <div class="p-4">
                            <p class="text-gray-700 text-center"><?php echo htmlspecialchars($image['description']); ?></p>
                            <p class="text-sm text-gray-500 text-center mt-2">Kategori: <?php echo htmlspecialchars($image['category']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-600">Tidak ada gambar untuk ditampilkan.</p>
            <?php endif; ?>
        </div>
    </main>

    <script>
        // Menambahkan kelas 'visible' setelah konten dimuat
        window.addEventListener('load', function() {
            const fadeElements = document.querySelectorAll('.fade-in');
            fadeElements.forEach((el, index) => {
                setTimeout(() => {
                    el.classList.add('visible');
                }, index * 200); // Delay bertahap
            });
        });

        // Debounce untuk pencarian
        let searchTimeout;
        document.getElementById('searchInput').addEventListener('input', function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function () {
                document.querySelector('form').submit();
            }, 500); // Menunggu 500ms setelah user selesai mengetik
        });

        function openImageModal(imageUrl) {
            const modal = document.createElement('div');
            modal.id = 'image-modal';
            modal.className = 'fixed inset-0 flex justify-center items-center bg-black bg-opacity-80';
            const modalImage = document.createElement('img');
            modalImage.src = imageUrl;
            modalImage.className = 'modal-image';
            modal.appendChild(modalImage);

            const closeButton = document.createElement('button');
            closeButton.innerHTML = '✖';
            closeButton.className = 'image-modal-close';
            closeButton.onclick = () => document.body.removeChild(modal);
            modal.appendChild(closeButton);

            document.body.appendChild(modal);
        }
    </script>
</body>
</html>
