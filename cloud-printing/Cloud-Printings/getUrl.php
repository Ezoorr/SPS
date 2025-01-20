<?php
$file = "db/list.txt"; // Chemin du fichier des commandes
$lines = file($file); // Lire toutes les commandes du fichier

if (!empty($lines)) {
    // Associer commandes aux imprimantes
    $printerMapping = [
        'A' => 'Printer1',
        'C' => 'Printer1',
        'B' => 'Printer2',
        'D' => 'Printer2',
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
                $filteredCommands[] = $command;
                unset($lines[$index]); // Supprimer la commande de la liste
            }
        }

        // Si des commandes existent pour cette imprimante
        if (!empty($filteredCommands)) {
            // Créer un tableau d'URLs distinctes pour chaque commande
            $urls = [];
            foreach ($filteredCommands as $command) {
                $urls[] = "http://10.0.20.243/Server-Example/order/data/{$command}.prn";
            }

            $urlInfo = [
                'urls' => $urls,  // L'URL devient un tableau avec plusieurs fichiers .prn
                'printer' => $requestedPrinter,
            ];

            file_put_contents($file, $lines); // Mettre à jour le fichier après traitement
            header('Content-Type: application/json');
            echo json_encode($urlInfo, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
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
