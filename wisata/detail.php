<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tempat Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f0f8ff; /* Warna latar belakang yang lebih cerah */
        }
        .container {
            margin-top: 50px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .img-fluid {
            border-radius: 10px;
            transition: transform 0.3s;
        }
        .img-fluid:hover {
            transform: scale(1.05);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .rating {
            color: gold;
        }
        h1, h2 {
            color: black; /* Warna teks judul */
            font-weight: bold;
        }
        p {
            color: black; /* Warna teks deskripsi */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <a href="index.php" class="btn btn-secondary mb-3">Kembali ke Beranda</a>
        <hr>
        <?php
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $query = "SELECT * FROM wisata WHERE id = $id";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<h1 class='text-center'>{$row['nama']}</h1>";
            echo "<div class='text-center'><img src='uploads/{$row['foto']}' alt='{$row['nama']}' class='img-fluid' style='max-width: 600px;'></div>";
            echo "<p class='mt-3'><strong>Kategori:</strong> {$row['kategori']}</p>";
            echo "<p><strong>Lokasi:</strong> {$row['lokasi']}</p>";
            echo "<p><strong>Rating:</strong> <span class='rating'>{$row['rating']} ⭐</span></p>";

            // Menghitung rata-rata rating
            $queryRating = "SELECT AVG(rating) as avg_rating FROM ulasan WHERE id_wisata = $id";
            $resultRating = $conn->query($queryRating);
            $avgRating = $resultRating->fetch_assoc()['avg_rating'];
            echo "<p><strong>Rating Rata-Rata:</strong> <span class='rating'>" . round($avgRating, 1) . " ⭐</span></p>";

            echo "<p><strong>Deskripsi:</strong> {$row['deskripsi']}</p>";
            echo '<div class="text-center"><a href="https://www.google.com/maps/search/?api=1&query=' . $row['lat'] . ',' . $row['lng'] . '" target="_blank" class="btn btn-primary">Lihat Rute di Google Maps</a></div>';

            // Menampilkan ulasan
            $queryUlasan = "SELECT * FROM ulasan WHERE id_wisata = $id ORDER BY tanggal DESC";
            $resultUlasan = $conn->query($queryUlasan);

            if ($resultUlasan->num_rows > 0) {
                echo "<h3>Ulasan Pengguna:</h3>";
                while ($ulasan = $resultUlasan->fetch_assoc()) {
                    echo "<p><strong>{$ulasan['nama_pengguna']}:</strong> {$ulasan['komentar']} <em>({$ulasan['rating']} ⭐)</em></p>";
                }
            } else {
                echo "<p>Tidak ada ulasan untuk tempat ini.</p>";
            }
        } else {
            echo "<p>Data tidak ditemukan.</p>";
        }
        ?>
        <hr>
    </div>
    <script src ="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>