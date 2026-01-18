<?php
session_start();

if (isset($_SESSION['admin_login'])) {
    header("Location: admin.php");
    exit;
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'];
    $p = $_POST['password'];

    if ($u === "admin" && $p === "fatih123") {
        $_SESSION['admin_login'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #eaf3ff, #ffffff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-card {
            width: 100%;
            max-width: 380px; /* supaya tidak terlalu lebar */
            background: #ffffff;
            padding: 30px 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .login-card h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #0d6efd;
            font-weight: 600;
        }
        .login-card h3::before {
            content: "🔐 ";
        }
        .btn-blue {
            background: #0d6efd;
            border: none;
            color: #fff;
            font-weight: 500;
        }
        .btn-blue:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="login-card">
    <h3>Login Admin</h3>

    <?php if ($error) : ?>
        <div class="alert alert-danger py-2 text-center">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text">👤</span>
                <input name="username" class="form-control" placeholder="Username" required>
            </div>
        </div>
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text">🔑</span>
                <input name="password" type="password" class="form-control" placeholder="Password" required>
            </div>
        </div>
        <button class="btn btn-blue w-100 py-2">Login</button>
    </form>
</div>

</body>
</html>
