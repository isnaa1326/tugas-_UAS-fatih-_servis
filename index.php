<?php
include 'db.php';
$admin_number = "085876865046";

// Ambil data testimoni dari database
$testi_res = mysqli_query($koneksi, "SELECT * FROM testimonial ORDER BY id DESC LIMIT 6");

// --- LOGIKA API INFO ELEKTRONIK ---
// Menggunakan kategori teknologi agar berita lebih relevan dan mudah diakses
$api_key = "602d3855073045239535738870104928"; 
$api_url = "https://newsapi.org/v2/top-headlines?country=id&category=technology&apiKey=" . $api_key;

$news_articles = [];
$api_data = @file_get_contents($api_url);

if ($api_data) {
    $decoded_data = json_decode($api_data, true);
    if (isset($decoded_data['status']) && $decoded_data['status'] == 'ok' && !empty($decoded_data['articles'])) {
        // Ambil 3 berita teratas saja
        $news_articles = array_slice($decoded_data['articles'], 0, 3);
    }
}

// DATA CADANGAN: Jika API sedang limit/error, link ini PASTI bisa diklik dan dibaca
if (empty($news_articles)) {
    $news_articles = [
        [
            'title' => 'Cara Merawat Kulkas Agar Hemat Listrik & Awet',
            'description' => 'Panduan lengkap merawat kompresor dan kebersihan kulkas rumah tangga Anda agar tidak cepat rusak.',
            'url' => 'https://www.kompas.com/tag/alat-elektronik',
            'urlToImage' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=500'
        ],
        [
            'title' => 'Tanda-Tanda Mesin Cuci Anda Perlu Diservice',
            'description' => 'Jangan tunggu sampai mati total. Kenali suara berisik dan getaran aneh pada mesin cuci Anda.',
            'url' => 'https://www.detik.com/tag/elektronik',
            'urlToImage' => 'https://images.unsplash.com/photo-1582735689369-4fe89db7114c?w=500'
        ],
        [
            'title' => 'Tips Melindungi TV LED dari Kerusakan Listrik',
            'description' => 'Gunakan stabilizer untuk menjaga tegangan listrik tetap stabil agar modul TV tidak terbakar.',
            'url' => 'https://www.liputan6.com/tag/elektronik',
            'urlToImage' => 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=500'
        ]
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fatih Elektronik Service</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root { --primary-color: #2d6ae3; }
        body { font-family: 'Segoe UI', sans-serif; }

        /* Wallpaper Utama */
        .hero-wallpaper {
            min-height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('background.jpeg') center/cover no-repeat fixed;
            display: flex; align-items: center; color: white;
        }

        /* Section Global Style */
        .section-wallpaper {
            position: relative; padding: 80px 0; margin: 30px 0; border-radius: 30px;
            background: linear-gradient(135deg, #f8f9ff 0%, #eef2ff 100%);
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            z-index: 1;
        }
        
        .section-wallpaper::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: url('bg belakang.jpeg') center/cover no-repeat fixed; opacity: 0.05; z-index: -1;
        }

        .card { border: none; border-radius: 20px; transition: 0.3s; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
        
        .navbar { background: rgba(255,255,255,0.95) !important; backdrop-filter: blur(10px); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="logo.png" alt="Logo" height="40" class="me-2">
                <span class="fw-bold text-primary">Fatih Elektronik</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto fw-medium">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#info-api">Berita & Tips</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimoni">Testimoni</a></li>
                    <li class="nav-item ms-lg-3"><a href="#form" class="btn btn-primary text-white">Pesan Service</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="home" class="hero-wallpaper">
        <div class="container text-center">
            <h1 class="display-3 fw-bold mb-3">Service Elektronik Terpercaya</h1>
            <p class="lead mb-5">Solusi cepat dan tepat untuk kerusakan alat rumah tangga Anda.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="#form" class="btn btn-primary btn-lg px-4">Buat Service</a>
                <a href="#cek" class="btn btn-outline-light btn-lg px-4">Cek Status</a>
            </div>
        </div>
    </section>

    <section id="layanan" class="section-wallpaper">
        <div class="container text-center">
            <h2 class="fw-bold mb-5 text-primary">Layanan Kami</h2>
            <div class="row g-4">
                <?php 
                $items = [
                    ['tit' => 'Kulkas', 'img' => 'kulkas-service.jpg'],
                    ['tit' => 'Mesin Cuci', 'img' => 'mesin cuci.jpeg'],
                    ['tit' => 'TV LED/LCD', 'img' => 'tv.jpeg'],
                    ['tit' => 'Magic Com', 'img' => 'magiccom.jpeg']
                ];
                foreach($items as $i): ?>
                <div class="col-md-3 col-6">
                    <div class="card h-100 p-2">
                        <img src="<?= $i['img'] ?>" class="card-img-top rounded-3" style="height: 150px; object-fit: cover;">
                        <div class="card-body px-0">
                            <h6 class="fw-bold mb-0"><?= $i['tit'] ?></h6>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="info-api" class="section-wallpaper" style="background: white !important;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">Info & Tips Terkini</h2>
                <p class="text-muted">Update berita teknologi dan tips harian untuk Anda</p>
            </div>
            <div class="row g-4">
                <?php foreach($news_articles as $post): ?>
                <div class="col-md-4">
                    <div class="card h-100 overflow-hidden border-0 shadow-sm">
                        <a href="<?= $post['url'] ?>" target="_blank">
                            <img src="<?= $post['urlToImage'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                        </a>
                        <div class="card-body p-4">
                            <h6 class="fw-bold">
                                <a href="<?= $post['url'] ?>" target="_blank" class="text-decoration-none text-dark">
                                    <?= substr($post['title'], 0, 70) ?>...
                                </a>
                            </h6>
                            <p class="text-muted small"><?= substr($post['description'] ?? 'Klik baca selengkapnya untuk detail tips.', 0, 90) ?>...</p>
                            <a href="<?= $post['url'] ?>" target="_blank" class="btn btn-primary btn-sm w-100 mt-2">
                                Baca Selengkapnya <i class="fas fa-external-link-alt ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="cek" class="py-5">
        <div class="container text-center">
            <div class="card bg-primary text-white p-5">
                <h3 class="fw-bold mb-4">Lacak Status Service</h3>
                <form action="status.php" method="get" class="d-flex justify-content-center">
                    <div class="input-group" style="max-width: 500px;">
                        <input type="text" name="kode" class="form-control" placeholder="Masukkan Kode (Contoh: SVC-001)" required>
                        <button class="btn btn-dark" type="submit">Cek Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section id="form" class="section-wallpaper">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Form Pengajuan Service</h2>
            <div class="col-lg-8 mx-auto card p-4 p-md-5">
                <form action="service_simpan.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6"><input type="text" name="nama" class="form-control" placeholder="Nama" required></div>
                        <div class="col-md-6"><input type="text" name="telepon" class="form-control" placeholder="No WhatsApp" required></div>
                        <div class="col-12"><input type="text" name="alamat" class="form-control" placeholder="Alamat" required></div>
                        <div class="col-md-6">
                            <select name="jenis" class="form-select" required>
                                <option value="Kulkas">Kulkas</option>
                                <option value="Mesin Cuci">Mesin Cuci</option>
                                <option value="TV">TV</option>
                                <option value="Magiccom">Magiccom</option>
                            </select>
                        </div>
                        <div class="col-md-6"><input type="text" name="merk" class="form-control" placeholder="Merk/Tipe"></div>
                        <div class="col-12"><textarea name="keluhan" class="form-control" rows="4" placeholder="Keluhan" required></textarea></div>
                        <div class="col-12 text-center"><button type="submit" class="btn btn-primary px-5">Kirim Permintaan</button></div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section id="testimoni" class="py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Testimoni</h2>
            <div class="row g-4">
                <?php while($t = mysqli_fetch_assoc($testi_res)): ?>
                <div class="col-md-4">
                    <div class="card p-4 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="<?= (!empty($t['foto']) ? 'uploads/'.$t['foto'] : 'default-user.jpg') ?>" class="rounded-circle me-3" width="50" height="50">
                            <h6 class="fw-bold m-0"><?= $t['nama'] ?></h6>
                        </div>
                        <p class="text-muted small">"<?= $t['komentar'] ?>"</p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white py-5">
        <div class="container text-center">
            <p class="mb-0">&copy; 2026 Fatih Elektronik Service. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>