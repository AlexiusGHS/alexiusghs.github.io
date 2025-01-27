<?php
require 'db.php'; // Koneksi database
require 'functions.php';

// Query untuk mendapatkan data wisata
$queryWisata = "SELECT * FROM wisata";

// Filter berdasarkan kategori
if (isset($_GET['kategori']) && !empty($_GET['kategori'])) {
    $kategori = mysqli_real_escape_string($conn, $_GET['kategori']);
    $queryWisata = "SELECT * FROM wisata WHERE kategori LIKE '%$kategori%'";
} 

// Filter berdasarkan lokasi pengguna
if (isset($_GET['user_location']) && !empty($_GET['user_location'])) {
    $userLocation = mysqli_real_escape_string($conn, $_GET['user_location']);
    
    // Validasi format input (lat,lng)
    if (strpos($userLocation, ',') !== false) {
        list($userLat, $userLng) = explode(',', $userLocation);
        
        // Pastikan lat dan lng adalah angka valid
        if (is_numeric($userLat) && is_numeric($userLng)) {
            // Query untuk mendapatkan wisata berdasarkan kategori dan lokasi pengguna
            $queryWisata = "SELECT *, 
                            (6371 * acos(
                                cos(radians($userLat)) * cos(radians(lat)) * 
                                cos(radians(lng) - radians($userLng)) + 
                                sin(radians($userLat)) * sin(radians(lat))
                            )) AS distance 
                            FROM wisata 
                            WHERE kategori LIKE '%$kategori%' 
                            HAVING distance < 50 
                            ORDER BY distance";
        } else {
            echo "<p class='text-danger text-center'>Lokasi tidak valid. Pastikan formatnya adalah lat,lng dengan angka yang benar.</p>";
        }
    } else {
        echo "<p class='text-danger text-center'>Lokasi tidak valid. Pastikan formatnya adalah lat,lng.</p>";
    }
}

$resultWisata = $conn->query($queryWisata);

// Debugging: Cek apakah query berhasil
if (!$resultWisata) {
    echo "Error: " . $conn->error; // Menampilkan kesalahan jika ada
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wisata Jakarta Selatan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Navbar -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
          <a class="navbar-brand" href="index.php">Wisata Jakarta Selatan</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
              <li class="nav-item"><a class="nav-link" href="pencarian.php">Pencarian</a></li>
              <li class="nav-item">
                  <a href="pilih_wisata.php" class="btn btn-primary">Pilih Tempat Wisata untuk Ulasan</a>
              </li>
              <li class="nav-item"><a class="nav-link" href="route.php">Cari Rute Perjalanan</a></li>
             </ul>
          </div>
      </div>
    </nav>
  </header>

  <main class="container mt-5" id="daftar-wisata">
    <h2 class="text-center mb-4">Daftar Tempat Wisata</h2>

    <!-- Form untuk filter kategori -->
    <form action="index.php" method="get" class="mb-3">
        <select name="kategori" class="form-select" required>
            <option value="">Pilih Kategori</option>
            <option value="Alam">Alam</option>
            <option value="Belanja">Belanja</option>
            <option value="Kuliner">Kuliner</option>
            <option value="Hiburan">Hiburan</option>
        </select>
        <button type="submit" class="btn btn-primary mt-2">Tampilkan</button>
    </form>

    <!-- Form untuk input lokasi pengguna -->
    <form action="index.php" method="get" class="mb-3">
      <input type="text" name="user_location" class="form-control" placeholder="Masukkan lokasi Anda (lat,lng)" required>
      <input type="hidden" name="kategori" value="<?= htmlspecialchars($_GET['kategori'] ?? '') ?>">
      <button type="submit" class="btn btn-primary mt-2">Rencanakan Perjalanan</button>
    </form>

    <div class="row">
      <?php if ($resultWisata && $resultWisata->num_rows > 0): ?>
        <?php while ($row = $resultWisata->fetch_assoc()): ?>
          <div class="col-md-4 mb-4">
            <div class="card">
              <?php 
              $imagePath = 'uploads/' . htmlspecialchars($row['foto']);
              ?>
              <img src="<?= $imagePath ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama']) ?>" onerror="this.onerror=null; this.src='uploads/default.jpg';">
              <div class="card-body">
                <h5 class="card-title text-primary"><?= htmlspecialchars($row['nama']) ?></h5>
                <p class="card-text"><strong>Kategori:</strong> <?= htmlspecialchars($row['kategori']) ?></p>
                <p class="card-text"><strong>Rating:</strong> <?= htmlspecialchars($row['rating']) ?> ⭐</p>
                <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-primary">Lihat Detail</a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-center text-danger">Tidak ada data wisata yang tersedia untuk kategori ini.</p>
      <?php endif; ?>
    </div>
  </main>

  <!-- Footer -->
  <footer class="text-center py-4 bg-dark text-white">
    <p>&copy; <?= date('Y') ?> WisataKu. Semua Hak Dilindungi.</p>
    <a href="#contact" class="text-white">Hubungi Kami</a>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>