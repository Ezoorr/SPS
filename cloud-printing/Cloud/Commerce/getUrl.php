<?php
$file = "db/list.txt"; // Chemin du fichier des commandes
$lines = file($file); // Lire toutes les commandes du fichier

// Fichier pour suivre l'état des commandes
$statusFile = "db/status.json";

if (!empty($lines)) {
    // Associer commandes aux imprimantes
    $printerMapping = [
        'A' => 'Printer1',
        'C' => 'Printer1',
        'B' => 'Printer2',
        'D' => 'Printer2',
        'Burger' => 'Printer2',
        'PP'=> 'Printer1',
    ];  

    // Récupérer l'imprimante demandée via un paramètre GET
    $requestedPrinter = $_GET['printer'] ?? null;

    if ($requestedPrinter) {
        $filteredCommands = [];

        foreach ($lines as $index => $line) {
            $command = str_replace("\n", '', $line);
            $printer = $printerMapping[$command] ?? null;

            // Ajouter les commandes associées à l'imprimante demandée
            if ($printer === $requestedPrinter) {
                $filteredCommands [] = $command;
                unset($lines[$index]); // Supprimer la commande de la liste
            }
        }

        // Si des commandes existent pour cette imprimante
        if (!empty($filteredCommands)) {
            // Créer un tableau d'URLs distinctes pour chaque commande
            $url = "";
            foreach ($filteredCommands as $command) {
                $url = "http://172.20.10.3/Cloud-printing/Cloud/Commerce/order/data/{$command}.prn";
            }

            // Initialiser les états dans le fichier de suivi
            $statusData = file_exists($statusFile) ? json_decode(file_get_contents($statusFile), true) : [];
            foreach ($filteredCommands as $command) {
                if (!isset($statusData[$command])) {
                    $statusData[$command] = 'pending'; // Ajouter un état "pending" pour chaque commande
                }
            }

            file_put_contents($statusFile, json_encode($statusData, JSON_PRETTY_PRINT)); // Sauvegarder les états

            // Mettre à jour le fichier de commandes après traitement
            file_put_contents($file, $lines);
            header('Content-Type: application/json');
            echo json_encode(['url' => $url], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            // Aucune commande pour cette imprimante
            header("HTTP/1.1 404 Not Found");
            echo json_encode(['error' => 'Aucune commande pour cette imprimante']);
        }
    } else {
        // Paramètre `printer` manquant
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(['error' => 'Paramètre printer manquant']);
    }
} else {
    // Pas de commandes disponibles
    header("HTTP/1.1 404 Not Found");
    echo json_encode(['error' => 'Aucune commande disponible']);
}
?>
