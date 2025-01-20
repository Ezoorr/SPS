<?php
$statusFile = "db/status.json";

if (file_exists($statusFile)) {
    $statusData = json_decode(file_get_contents($statusFile), true);
    header('Content-Type: application/json');
    echo json_encode($statusData, JSON_PRETTY_PRINT);
} else {
    echo json_encode(['error' => 'Aucun état disponible']);
}
?>
