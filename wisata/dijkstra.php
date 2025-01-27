<?php
// dijkstra.php

function dijkstra($graph, $start) {
    $distances = [];
    $previous = [];
    $queue = new SplPriorityQueue();

    // Inisialisasi jarak awal
    foreach ($graph as $vertex => $edges) {
        $distances[$vertex] = INF;
        $previous[$vertex] = null;
    }
    $distances[$start] = 0;
    $queue->setExtractFlags(SplPriorityQueue::EXTR_DATA); // Prioritas kecil ke besar
    $queue->insert($start, 0);

    while (!$queue->isEmpty()) {
        $current = $queue->extract();

        foreach ($graph[$current] as $neighbor => $weight) {
            $alt = $distances[$current] + $weight;

            if ($alt < $distances[$neighbor]) {
                $distances[$neighbor] = $alt;
                $previous[$neighbor] = $current;
                $queue->insert($neighbor, $alt);
            }
        }
    }

    return [$distances, $previous];
}

function findShortestPath($graph, $start, $end) {
    list($distances, $previous) = dijkstra($graph, $start);
    $path = [];
    $current = $end;

    while ($current !== null) {
        array_unshift($path, $current);
        $current = $previous[$current];
    }

    if ($distances[$end] === INF) {
        return null; // Tidak ada jalur
    }

    return ['path' => $path, 'distance' => $distances[$end]];
}
?>
