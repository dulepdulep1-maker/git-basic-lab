<?php
session_start();
require_once "koneksi.php";

$pesan = "";

if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare(
        "SELECT id, username, password FROM users WHERE username = ?"
    );
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $hasil = $stmt->get_result();
    $user = $hasil->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];

        header("Location: dashboard.php");
        exit;
    } else {
        $pesan = "Username atau password salah.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login WebBasic</title>
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
        .pesan { color: #fca5a5; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Login WebBasic</h1>

        <?php if ($pesan !== ""): ?>
            <p class="pesan">
                <?= htmlspecialchars($pesan, ENT_QUOTES, "UTF-8") ?>
            </p>
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
                placeholder="Password"
                required
            >

            <button type="submit">Login</button>
        </form>

        <p>Belum punya akun? <a href="register.php">Daftar</a></p>
        <p><a href="index.html">Kembali ke beranda</a></p>
    </div>
</body>
</html>