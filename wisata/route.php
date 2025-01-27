<?php
// Data graf tempat wisata Anda
$graph = [
    'Tebet Eco Park' => [
        'Kebun Binatang Ragunan' => 5,
        'Setu Babakan' => 10,
        'Kota Kasablanka' => 15
    ],
    'Kebun Binatang Ragunan' => [
        'Tebet Eco Park' => 5,
        'Skywalk Senayan' => 8,
        'M Bloc Space' => 12
    ],
    'Setu Babakan' => [
        'Tebet Eco Park' => 10,
        'Pasar Santa' => 20,
        'Kampung Main Cipulir' => 15
    ],
    'Skywalk Senayan' => [
        'Kebun Binatang Ragunan' => 8,
        'M Bloc Space' => 6,
        'Chillax Sudirman' => 10
    ],
    'M Bloc Space' => [
        'Kebun Binatang Ragunan' => 12,
        'Skywalk Senayan' => 6,
        'Kemang Area' => 8
    ],
    'Kemang Area' => [
        'M Bloc Space' => 8,
        'Kota Kasablanka' => 7,
        'Chillax Sudirman' => 12
    ],
    'Kota Kasablanka' => [
        'Kemang Area' => 7,
        'Chillax Sudirman' => 5,
        'Pondok Indah Waterpark' => 10
    ],
    'Chillax Sudirman' => [
        'Kota Kasablanka' => 5,
        'Skywalk Senayan' => 10,
        'Kampung Main Cipulir' => 8
    ],
    'Kampung Main Cipulir' => [
        'Chillax Sudirman' => 8,
        'Pondok Indah Waterpark' => 12,
        'Setu Babakan' => 15
    ],
    'Pondok Indah Waterpark' => [
        'Kota Kasablanka' => 10,
        'Kampung Main Cipulir' => 12,
        'Pasar Santa' => 15
    ],
    'Pasar Santa' => [
        'Setu Babakan' => 20,
        'Pondok Indah Waterpark' => 15
    ]
];

// Fungsi Dijkstra untuk mencari rute terpendek
function findShortestPath($graph, $start, $end) {
    $distances = [];
    $previous = [];
    $nodes = [];

    foreach ($graph as $vertex => $neighbors) {
        if ($vertex === $start) {
            $distances[$vertex] = 0;
        } else {
            $distances[$vertex] = INF;
        }
        $previous[$vertex] = null;
        $nodes[$vertex] = $distances[$vertex];
    }

    while (!empty($nodes)) {
        asort($nodes);
        $closest = key($nodes);
        unset($nodes[$closest]);

        if ($closest === $end) {
            $path = [];
            while ($previous[$closest]) {
                $path[] = $closest;
                $closest = $previous[$closest];
            }
            $path[] = $start;
            return array_reverse($path);
        }

        if ($distances[$closest] === INF) {
            break;
        }

        foreach ($graph[$closest] as $neighbor => $cost) {
            $alt = $distances[$closest] + $cost;
            if ($alt < $distances[$neighbor]) {
                $distances[$neighbor] = $alt;
                $previous[$neighbor] = $closest;
                $nodes[$neighbor] = $alt;
            }
        }
    }

    return null;
}

// Menangani form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start = $_POST['start'];
    $end = $_POST['end'];

    if ($start === $end) {
        $message = "Tempat wisata awal dan akhir tidak boleh sama.";
    } else {
        $path = findShortestPath($graph, $start, $end);
        if ($path) {
            $message = "Rute terpendek dari <strong>$start</strong> ke <strong>$end</strong>: " . implode(' ➝ ', $path);
        } else {
            $message = "Tidak ada rute yang tersedia antara <strong>$start</strong> dan <strong>$end</strong>.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rute Tempat Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Tombol Kembali ke Beranda -->
        <div class="mb-3">
            <a href="index.php" class="btn btn-secondary">&larr; Kembali ke Beranda</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-4">
                    <h1 class="text-center mb-4">Cari Rute Tempat Wisata</h1>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="start" class="form-label">Tempat Wisata Awal:</label>
                            <select id="start" name="start" class="form-select" required>
                                <?php foreach ($graph as $place => $neighbors): ?>
                                    <option value="<?= $place ?>" <?= isset($_POST['start']) && $_POST['start'] === $place ? 'selected' : '' ?>>
                                        <?= $place ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="end" class="form-label">Tempat Wisata Akhir:</label>
                            <select id="end" name="end" class="form-select" required>
                                <?php foreach ($graph as $place => $neighbors): ?>
                                    <option value="<?= $place ?>" <?= isset($_POST['end']) && $_POST['end'] === $place ? 'selected' : '' ?>>
                                        <?= $place ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-custom">Cari Rute</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-info mt-4" role="alert">
                            <?= $message ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>