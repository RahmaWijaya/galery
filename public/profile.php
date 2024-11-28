<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: beranda.php'); // Redirect ke halaman beranda jika belum login
    exit();
}

$username = $_SESSION['username'];

// Variabel notifikasi login
$notification = isset($_SESSION['login_success']) ? $_SESSION['login_success'] : '';

// Menghapus session login_success setelah digunakan
unset($_SESSION['login_success']);

// File untuk menyimpan data gambar
$imagesFile = 'images.json';
$images = [];

// Ambil gambar dari file jika ada
if (file_exists($imagesFile)) {
    $images = json_decode(file_get_contents($imagesFile), true);
}

// Proses penambahan gambar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_image']) && isset($_FILES['image_file'])) {
        $description = $_POST['description'];
        $category = $_POST['category'];

        // Proses upload gambar
        if ($_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $imageName = time() . '-' . basename($_FILES['image_file']['name']);
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . $imageName;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $uploadFile)) {
                $images[] = ['url' => $uploadFile, 'description' => $description, 'category' => $category];
                file_put_contents($imagesFile, json_encode($images));
                $notification = 'Gambar berhasil ditambahkan!';
            }
        }
    } elseif (isset($_POST['delete_image'])) {
        $imageToDelete = $_POST['image_url'];
        $images = array_filter($images, function($img) use ($imageToDelete) {
            return $img['url'] !== $imageToDelete;
        });
        file_put_contents($imagesFile, json_encode(array_values($images)));
        $notification = 'Gambar berhasil dihapus!';
    } elseif (isset($_POST['edit_image'])) {
        $imageToEdit = $_POST['image_url'];
        $description = $_POST['description'];
        $category = $_POST['category'];

        if (isset($_FILES['edit_image_file']) && $_FILES['edit_image_file']['error'] === UPLOAD_ERR_OK) {
            $imageName = time() . '-' . basename($_FILES['edit_image_file']['name']);
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . $imageName;

            if (move_uploaded_file($_FILES['edit_image_file']['tmp_name'], $uploadFile)) {
                foreach ($images as &$img) {
                    if ($img['url'] === $imageToEdit) {
                        $img['url'] = $uploadFile;
                        $img['description'] = $description;
                        $img['category'] = $category;
                    }
                }
                file_put_contents($imagesFile, json_encode($images));
                $notification = 'Gambar berhasil diperbarui!';
            }
        } else {
            foreach ($images as &$img) {
                if ($img['url'] === $imageToEdit) {
                    $img['description'] = $description;
                    $img['category'] = $category;
                }
            }
            file_put_contents($imagesFile, json_encode($images));
            $notification = 'Deskripsi gambar berhasil diperbarui!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - SMKN 4 BOGOR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Efek Zoom pada gambar */
        .image-hover:hover {
            transform: scale(1.1);
            transition: transform 0.3s ease-in-out;
        }

        /* Modal untuk menampilkan gambar besar */
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
        }

        #image-modal img {
            max-width: 90%;
            max-height: 90%;
        }

        /* Animasi fade-in pada tombol */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Transisi halus pada tombol */
        .transition-button {
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .transition-button:hover {
            background-color: #555;
            transform: scale(1.05);
        }

        /* Form dan elemen input dengan transisi */
        .input-field {
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .input-field:focus {
            background-color: #f7fafc;
            border-color: #2d3748;
        }

        /* Toast notification */
        .toast {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #000000; /* Latar belakang hitam */
            color: white; /* Teks putih */
            padding: 15px;
            border-radius: 5px;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .toast.show {
            display: block;
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-100">

    <header class="bg-black shadow-lg">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-white">Profil Admin</h1>
            <nav class="flex space-x-4">
                <a class="text-white hover:underline" href="logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <div class="bg-white p-6 rounded-lg shadow-lg fade-in">
            <h2 class="text-2xl font-bold mb-4 fade-in">Selamat Datang, <?php echo htmlspecialchars($username); ?>!</h2>
            
            <h3 class="text-xl font-bold mb-4 fade-in">Tambah Gambar:</h3>
            <form method="POST" enctype="multipart/form-data" class="mb-6 space-y-4">
                <input type="file" name="image_file" required class="border border-gray-300 p-2 w-full rounded input-field" />
                <input type="text" name="description" placeholder="Deskripsi" required class="border border-gray-300 p-2 w-full rounded input-field" />
                <select name="category" class="border border-gray-300 p-2 w-full rounded input-field" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Logo">Logo</option>
                    <option value="Halaman">Halaman</option>
                    <option value="Kegiatan">Kegiatan</option>
                </select>
                <button type="submit" name="add_image" class="bg-black text-white p-2 rounded transition-button hover:bg-gray-800">Tambah Gambar</button>
            </form>

            <h3 class="text-xl font-bold mt-6 mb-4">Gambar yang Diupload:</h3>
            <?php if (!empty($images)): ?>
                <ul class="list-disc list-inside fade-in">
                    <?php foreach ($images as $image): ?>
                        <li class="flex items-center justify-between mb-4 p-4 border rounded-lg shadow-sm bg-gray-50 hover:bg-gray-100 transition duration-150 fade-in">
                            <div class="flex items-center">
                                <!-- Gambar dengan efek hover zoom -->
                                <img src="<?php echo htmlspecialchars($image['url']); ?>" alt="Gambar" class="w-24 h-24 object-cover mr-4 rounded shadow image-hover" />
                                <div>
                                    <strong class="block text-lg"><?php echo htmlspecialchars($image['description']); ?></strong>
                                    <span class="text-gray-500">(<?php echo htmlspecialchars($image['category']); ?>)</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <form method="POST" class="flex items-center" enctype="multipart/form-data">
                                    <input type="hidden" name="image_url" value="<?php echo htmlspecialchars($image['url']); ?>" />
                                    <input type="file" name="edit_image_file" class="border border-gray-300 p-1 rounded input-field" />
                                    <input type="text" name="description" value="<?php echo htmlspecialchars($image['description']); ?>" class="border border-gray-300 p-1 rounded w-64 input-field" required />
                                    <select name="category" class="border border-gray-300 p-1 rounded input-field" required>
                                        <option value="Logo" <?php echo $image['category'] === 'Logo' ? 'selected' : ''; ?>>Logo</option>
                                        <option value="Halaman" <?php echo $image['category'] === 'Halaman' ? 'selected' : ''; ?>>Halaman</option>
                                        <option value="Kegiatan" <?php echo $image['category'] === 'Kegiatan' ? 'selected' : ''; ?>>Kegiatan</option>
                                    </select>
                                    <button type="submit" name="edit_image" class="bg-green-600 text-white p-1 rounded hover:bg-green-500 transition duration-150">Edit</button>
                                </form>
                                <form method="POST">
                                    <input type="hidden" name="image_url" value="<?php echo htmlspecialchars($image['url']); ?>" />
                                    <button type="submit" name="delete_image" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-gray-500">Tidak ada gambar yang diupload.</p>
            <?php endif; ?>
        </div>
    </main>

    <!-- Toast Notification -->
    <?php if ($notification): ?>
        <div id="toast" class="toast show">
            <?php echo htmlspecialchars($notification); ?>
        </div>
    <?php endif; ?>

    <!-- Modal Gambar -->
    <div id="image-modal" class="fixed inset-0 flex">
        <img id="modal-image" alt="Gambar Besar" class="rounded-lg" />
        <button onclick="closeImageModal()" class="absolute top-5 right-5 text-white text-3xl">✖</button>
    </div>

    <script>
        // Fungsi untuk membuka modal gambar
        function openImageModal(src) {
            document.getElementById('modal-image').src = src;
            document.getElementById('image-modal').style.display = 'flex';
        }

        // Fungsi untuk menutup modal gambar
        function closeImageModal() {
            document.getElementById('image-modal').style.display = 'none';
        }

        // Menambahkan kelas 'visible' untuk elemen fade-in
        window.addEventListener('DOMContentLoaded', () => {
            const fadeInElements = document.querySelectorAll('.fade-in');
            fadeInElements.forEach((el, index) => {
                setTimeout(() => el.classList.add('visible'), (index + 1) * 300); // Delay animasi
            });

            // Menutup toast notification setelah beberapa detik
            const toast = document.getElementById('toast');
            if (toast) {
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000); // Toast akan hilang setelah 3 detik
            }
        });
    </script>

</body>
</html>
