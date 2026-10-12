
<?php
session_start();

$sudahLogin = isset($_SESSION["user_id"]);
$username = $sudahLogin
    ? htmlspecialchars($_SESSION["username"], ENT_QUOTES, "UTF-8")
    : "";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WebBasic - Belajar Web</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php" class="logo">WebBasic</a>

            <div>
                <a href="index.php">Beranda</a>

                <?php if ($sudahLogin): ?>
                    <span>Halo, <?= $username ?>!</span>
                    <form action="logout.php" method="POST"
                          style="display:inline">
                        <button type="submit">Logout</button>
                    </form>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="register.php">Daftar</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <main class="hero">
        <section>
            <h1>Belajar Web. Bangun Karyamu.</h1>
            <p>
                Mulai perjalananmu membuat website dengan
                HTML, CSS, PHP, dan database MySQL.
            </p>

            <?php if ($sudahLogin): ?>
                <p>Selamat datang kembali di WebBasic!</p>
                <a href="dashboard.php">Buka Dashboard</a>
            <?php else: ?>
                <a href="register.php">Mulai Sekarang</a>
            <?php endif; ?>
        </section>

        <section class="hero-card">
            <h2>Learn. Build. Grow.</h2>
            <p>HTML · CSS · JavaScript · PHP · MySQL</p>
        </section>
    </main>

    <footer>
        <p>Praktikum Pemrograman Berbasis Web</p>
        <p>&copy; 2026 WebBasic</p>
    </footer>
</body>
</html>
