<?php

function dijkstra($graph, $source, $destination) {
    $distances = array();
    $visited = array();
    $previous = array();
    $queue = new SplPriorityQueue();

    // Инициализация начальных расстояний
    foreach ($graph as $vertex => $adj) {
        $distances[$vertex] = PHP_INT_MAX;
        $visited[$vertex] = false;
    }

    // Начальное расстояние до исходной вершины равно 0
    $distances[$source] = 0;
    $queue->insert($source, 0);

    while (!$queue->isEmpty()) {
        $currentVertex = $queue->extract();

        if ($visited[$currentVertex]) {
            continue;
        }

        $visited[$currentVertex] = true;

        foreach ($graph[$currentVertex] as $neighbor => $weight) {
            $alt = $distances[$currentVertex] + $weight;
            if ($alt < $distances[$neighbor]) {
                $distances[$neighbor] = $alt;
                $previous[$neighbor] = $currentVertex;
                $queue->insert($neighbor, -$alt); // Используем отрицательное значение для сортировки по минимальному расстоянию
            }
        }
    }

    // Построение кратчайшего пути
    $path = array();
    $current = $destination;
    while (isset($previous[$current])) {
        array_unshift($path, $current);
        $current = $previous[$current];
    }
    array_unshift($path, $source);

    return array(
        'distance' => $distances[$destination],
        'path' => $path
    );
}

// Создание графа
$graph = array(
    '1' => array('2' => 7, '3' => 9, '6' => 14),
    '2' => array('1' => 7, '3' => 10, '4' => 15),
    '3' => array('1' => 9, '2' => 10, '4' => 11, '6' => 2),
    '4' => array('2' => 15, '3' => 11, '5' => 6),
    '5' => array('4' => 6, '6' => 9),
    '6' => array('1' => 14, '3' => 2, '5' => 9)
);

// Задача: найти кратчайший путь от вершины 1 к вершине 6
$source = '1';
$destination = '6';

$result = dijkstra($graph, $source, $destination);

// Запись результата в лог
$logFileName = 'dijkstra_log.txt';
$logContent = "Shortest distance from $source to $destination is {$result['distance']}\n";
$logContent .= "Shortest path: " . implode(' -> ', $result['path']) . "\n";

file_put_contents($logFileName, $logContent);

echo "Результат сохранен в файл $logFileName\n";
?>
