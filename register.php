<?php
require_once "koneksi.php";

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "") {
        $pesan = "Username dan password wajib diisi.";
    } elseif (strlen($username) > 50) {
        $pesan = "Username maksimal 50 karakter.";
    } elseif (strlen($password) < 8) {
        $pesan = "Password minimal 8 karakter.";
    } else {
        $cek = $conn->prepare(
            "SELECT id FROM users WHERE username = ?"
        );
        $cek->bind_param("s", $username);
        $cek->execute();
        $hasil = $cek->get_result();

        if ($hasil->num_rows > 0) {
            $pesan = "Username sudah digunakan.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "INSERT INTO users (username, password) VALUES (?, ?)"
            );
            $stmt->bind_param("ss", $username, $hash);

            if ($stmt->execute()) {
                $pesan = "Registrasi berhasil! Silakan login.";
            } else {
                $pesan = "Registrasi gagal. Coba lagi.";
            }

            $stmt->close();
        }

        $cek->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi WebBasic</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #101827;
            color: white;
            display: grid;
            place-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .card {
            background: #1e293b;
            padding: 30px;
            border-radius: 12px;
            width: min(320px, calc(100% - 60px));
        }

        input, button {
            box-sizing: border-box;
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            border-radius: 6px;
        }

        input {
            border: 1px solid #475569;
        }

        button {
            background: #3b82f6;
            color: white;
            border: 0;
            cursor: pointer;
        }

        a { color: #93c5fd; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Buat Akun</h1>

        <?php if ($pesan !== ""): ?>
            <p><?= htmlspecialchars($pesan, ENT_QUOTES, "UTF-8") ?></p>
        <?php endif; ?>

        <form method="POST">
            <input
                type="text"
                name="username"
                placeholder="Username"
                maxlength="50"
                required
            >

            <input
                type="password"
                name="password"
                placeholder="Password (minimal 8 karakter)"
                minlength="8"
                required
            >

            <button type="submit">Daftar</button>
        </form>

        <p>Sudah punya akun? <a href="login.php">Login</a></p>
        <p><a href="index.php">Kembali ke beranda</a></p>
    </div>
</body>
</html>