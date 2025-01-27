<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Tempat Wisata</title>
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
        .card {
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        h2 {
            color: #333; /* Warna teks judul */
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            margin: 3px 10px; /* Untuk memusatkan */
            display: block; /* Pastikan tombol jadi elemen blok */
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            margin-bottom: 20px; /* Memberikan jarak di bawah tombol */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Pencarian Tempat Wisata</h1>
        <a href="index.php" class="btn btn-secondary">Kembali ke Beranda</a> <!-- Tombol Kembali ke Beranda -->
        <form method="get" action="pencarian.php">
            <div class="row mb-4">
                <div class="col-md-8">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari tempat wisata..." required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                </div>
            </div>
        </form>

        <?php if (isset($_GET['keyword'])): ?>
            <h2 class="mt-5">Hasil Pencarian untuk: <strong><?php echo htmlspecialchars($_GET['keyword']); ?></strong></h2>
            <div class="row">
                <?php
                $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);
                $query = "SELECT * FROM wisata WHERE nama LIKE '%$keyword%' OR kategori LIKE '%$keyword%' OR deskripsi LIKE '%$keyword%'";
                $result = $conn->query($query);

                if ($result->num_rows > 0) :
                    while ($row = $result->fetch_assoc()) :
                ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="uploads/<?php echo $row['foto']; ?>" class="card-img-top" alt="<?php echo $row['nama']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['nama']; ?></h5>
                                    <p class="card-text"><?php echo $row['kategori']; ?></p>
                                    <a href="detail.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                <?php
                    endwhile;
                else :
                    echo "<p class='text-center'>Tidak ada hasil untuk pencarian ini.</p>";
                endif;
                ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>