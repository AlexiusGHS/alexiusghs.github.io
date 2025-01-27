<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_wisata = intval($_POST['id_wisata']);
    $nama_pengguna = mysqli_real_escape_string($conn, $_POST['nama_pengguna']);
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
    $rating = floatval($_POST['rating']);

    // Cek apakah id_wisata ada di tabel wisata
    $checkQuery = "SELECT * FROM wisata WHERE id = $id_wisata";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Jika id_wisata ada, masukkan ulasan
        $query = "INSERT INTO ulasan (id_wisata, nama_pengguna, komentar, rating) VALUES ('$id_wisata', '$nama_pengguna', '$komentar', '$rating')";
        
        if ($conn->query($query) === TRUE) {
            header("Location: detail.php?id=$id_wisata"); // Redirect ke halaman detail
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    } else {
        echo "ID wisata tidak ditemukan.";
    }
}
?>