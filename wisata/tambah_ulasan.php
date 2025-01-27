<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Ulasan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Tambah Ulasan</h1>

        <?php
        // Cek apakah ID wisata ada di URL
        if (!isset($_GET['id'])) {
            echo "<p class='text-danger'>ID wisata tidak ditemukan.</p>";
            exit; // Hentikan eksekusi jika ID tidak ada
        }

        $id_wisata = intval($_GET['id']);
        $query = "SELECT * FROM wisata WHERE id = $id_wisata";
        $result = $conn->query($query);

        // Cek apakah ID wisata valid
        if ($result->num_rows == 0) {
            echo "<p class='text-danger'>ID wisata tidak ditemukan.</p>";
            exit; // Hentikan eksekusi jika ID tidak valid
        }

        // Ambil data wisata untuk ditampilkan
        $row = $result->fetch_assoc();
        echo "<h2 class='text-center'>{$row['nama']}</h2>";
        ?>

        <form action="proses_ulasan.php" method="post">
            <input type="hidden" name="id_wisata" value="<?php echo htmlspecialchars($id_wisata); ?>">
            <div class="mb-3">
                <label for="nama_pengguna" class="form-label">Nama Pengguna</label>
                <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" required>
            </div>
            <div class="mb-3">
                <label for="komentar" class="form-label">Komentar</label>
                <textarea class="form-control" id="komentar" name="komentar" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Rating (1-5)</label>
                <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>