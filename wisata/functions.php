<?php
function getCollaborativeRecommendations($userId, $conn) {
    $userCategories = $conn->query("SELECT DISTINCT kategori FROM ulasan INNER JOIN wisata ON ulasan.id_wisata = wisata.id WHERE id_pengguna = $userId");
    
    $recommendedWisata = [];
    
    while ($category = $userCategories->fetch_assoc()) {
        $categoryName = $category['kategori'];
        
        $query = "SELECT id_wisata FROM ulasan INNER JOIN wisata ON ulasan.id_wisata = wisata.id WHERE kategori = '$categoryName' AND id_pengguna != $userId AND rating >= 4";
        $result = $conn->query($query);
        
        while ($row = $result->fetch_assoc()) {
            $recommendedWisata[] = $row['id_wisata'];
        }
    }
    
    return array_unique($recommendedWisata);
}

function dijkstra($graph, $start, $end) {
    $dist = [];
    $prev = [];
    $queue = new SplPriorityQueue();

    foreach ($graph as $vertex => $edges) {
        $dist[$vertex] = INF;
        $prev[$vertex] = null;
        $queue->insert($vertex, INF);
    }
    
    $dist[$start] = 0;
    $queue->insert($start, 0);

    while (!$queue->isEmpty()) {
        $current = $queue->extract();

        if ($current === $end) {
            break;
        }

        foreach ($graph[$current] as $neighbor => $cost) {
            $alt = $dist[$current] + $cost;
            if ($alt < $dist[$neighbor]) {
                $dist[$neighbor] = $alt;
                $prev[$neighbor] = $current;
                $queue->insert($neighbor, $alt);
            }
        }
    }

    $path = [];
    for ($at = $end; $at !== null; $at = $prev[$at]) {
        $path[] = $at;
    }
    return array_reverse($path);
}

function searchWisataByKeyword($keyword, $conn) {
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $query = "SELECT * FROM wisata WHERE deskripsi LIKE '%$keyword%'";
    $result = $conn->query($query);
    
    $wisataList = [];
    while ($row = $result->fetch_assoc()) {
        $wisataList[] = $row;
    }
    
    return $wisataList;
}
?>