<?php
session_start();

// Data pengguna (username => password)
$users = [
    'admin' => 'password123',
    'user' => 'userpass',
];

// Ambil data dari form login
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$errorMessage = '';

// Cek kredensial
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION['username'] = $username;
        header('Location: profile.php'); // Redirect ke halaman profil
        exit;
    } else {
        $errorMessage = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMKN 4 BOGOR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animasi fade-in pada kontainer */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Efek hover pada tombol */
        .transition-button {
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .transition-button:hover {
            background-color: #444;
            transform: scale(1.05);
        }

        /* Efek untuk input form */
        .input-field {
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        .input-field:focus {
            background-color: #f7fafc;
            border-color: #2d3748;
        }

        /* Efek untuk pesan error */
        .error-message {
            transition: opacity 0.5s ease;
            opacity: 0;
        }

        .error-message.visible {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg w-96 fade-in">
        <h2 class="text-2xl font-bold mb-4 text-center text-black">Login</h2>

        <!-- Pesan error dengan animasi fade-in -->
        <?php if ($errorMessage): ?>
            <div class="bg-red-100 text-red-600 border border-red-400 p-2 rounded mb-4 text-center error-message visible">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required class="border border-gray-300 p-2 mb-4 w-full rounded input-field" />
            <input type="password" name="password" placeholder="Password" required class="border border-gray-300 p-2 mb-4 w-full rounded input-field" />
            <button type="submit" class="bg-black text-white p-2 rounded w-full hover:bg-gray-800 transition-button">Masuk</button>
        </form>
        <div class="mt-4 text-center">
            <a href="logout.php" class="text-red-600 hover:underline">Keluar</a>
        </div>
    </div>

    <script>
        // Menambahkan kelas 'visible' untuk elemen fade-in
        window.addEventListener('DOMContentLoaded', () => {
            const fadeInElements = document.querySelectorAll('.fade-in');
            fadeInElements.forEach((el, index) => {
                setTimeout(() => el.classList.add('visible'), (index + 1) * 300); // Delay animasi
            });

            const errorMessage = document.querySelector('.error-message');
            if (errorMessage) {
                errorMessage.classList.add('visible');
            }
        });
    </script>
</body>
</html>
