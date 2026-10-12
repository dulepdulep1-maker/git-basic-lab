
<?php
session_start();
require_once "koneksi.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "SELECT username, created_at FROM users WHERE id = ?"
);
$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    $_SESSION = [];
    session_destroy();
    header("Location: login.php");
    exit;
}

$username = htmlspecialchars(
    $user["username"],
    ENT_QUOTES,
    "UTF-8"
);

$tanggal = htmlspecialchars(
    $user["created_at"],
    ENT_QUOTES,
    "UTF-8"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Pengguna - WebBasic</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #101827;
            color: white;
            margin: 0;
            padding: 40px 20px;
        }

        .card {
            max-width: 500px;
            margin: 40px auto;
            padding: 28px;
            background: #1e293b;
            border-radius: 14px;
        }

        .label {
            color: #94a3b8;
            margin-bottom: 5px;
        }

        .value {
            margin-top: 0;
            margin-bottom: 24px;
        }

        a, button {
            display: inline-block;
            padding: 11px 16px;
            border: 0;
            border-radius: 7px;
            background: #3b82f6;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        button {
            background: #dc2626;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Profil Pengguna</h1>
        <p>Informasi akun dari database WebBasic.</p>

        <p class="label">Username</p>
        <h2 class="value"><?= $username ?></h2>

        <p class="label">Tanggal Registrasi</p>
        <p class="value"><?= $tanggal ?></p>

        <a href="index.php">Beranda</a>

        <form action="logout.php" method="POST"
              style="display:inline">
            <button type="submit">Logout</button>
        </form>
    </div>
</body>
</html>
