<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Tempat Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eef2f7;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 1200px;
            padding-top: 50px;
        }
        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 40px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #ffffff;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        .card-img-top {
            height: 220px;
            object-fit: cover;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #495057;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            border-radius: 25px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #084298;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .back-btn {
            display: flex;
            justify-content: start;
        }
        .row {
            row-gap: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Tombol Kembali ke Beranda -->
        <div class="back-btn mb-3">
            <a href="index.php" class="btn btn-secondary">&larr; Kembali ke Beranda</a>
        </div>

        <!-- Header -->
        <div class="header">
            <h1>Pilih Tempat Wisata untuk Ulasan</h1>
        </div>

        <!-- Grid untuk kartu wisata -->
        <div class="row">
            <?php
            // Query untuk mendapatkan semua tempat wisata
            $query = "SELECT * FROM wisata";
            $result = $conn->query($query);

            // Menampilkan setiap tempat wisata
            while ($row = $result->fetch_assoc()): ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card">
                        <img src="uploads/<?php echo $row['foto']; ?>" class="card-img-top" alt="<?php echo $row['nama']; ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $row['nama']; ?></h5>
                            <a href="tambah_ulasan.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Ulas Tempat Ini</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>