<?php
$file = "db/list.txt"; // File containing the queue of ZPL files
$lines = file($file); // Read all queued commands

if (!empty($lines)) {
    $filename = trim(array_shift($lines)); // Get the first file in the queue
    file_put_contents($file, implode("", $lines)); // Update the queue

    // Build the URL for the file
    $url = "http://192.168.1.118/cloud-printing/Cloud/tl/order/data/{$filename}";

    // Respond with the URL
    header('Content-Type: application/json');
    echo json_encode(['url' => $url], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else {
    // No files in the queue
    header("HTTP/1.1 404 Not Found");
    echo json_encode(['error' => 'Aucune commande disponible']);
}
?>
