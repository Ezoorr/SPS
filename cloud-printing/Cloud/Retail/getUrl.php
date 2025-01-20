<?php
$file = "db/list.txt"; // Chemin du fichier des commandes
$lines = file($file); // Lire toutes les commandes du fichier

// Fichier pour suivre l'état des commandes
$statusFile = "db/status.json";

if (!empty($lines)) {
    // Associer commandes aux imprimantes
    $printerMapping = [
        'pizza' => 'Printer1',
        'pasta' => 'Printer1',
        'burger' => 'Printer2',
        'salad' => 'Printer2',
    ];  

    // Récupérer l'imprimante demandée via un paramètre GET
    $requestedPrinter = $_GET['printer'] ?? null;

    if ($requestedPrinter) {
        $filteredCommands = [];

        foreach ($lines as $index => $line) {
            $command = str_replace("\n", '', $line);
            // Extraire la catégorie de la commande (ex: burger_order => burger)
            $category = strtolower(explode('_', $command)[0]);
            $printer = $printerMapping[$category] ?? null;

            // Ajouter les commandes associées à l'imprimante demandée
            if ($printer === $requestedPrinter) {
                $filteredCommands[] = $command;
                unset($lines[$index]); // Supprimer la commande de la liste
            }
        }

        // Vérifier les commandes filtrées
        echo "<pre>";
        var_dump($filteredCommands);
        echo "</pre>";

        // Si des commandes existent pour cette imprimante
        if (!empty($filteredCommands)) {
            // Créer un tableau d'URLs distinctes pour chaque commande
            $urls = [];
            foreach ($filteredCommands as $command) {
                // URL pour chaque commande (par exemple burger_order.prn)
                $urls[] = "http://10.0.20.238/Cloud-printing/Cloud/Retail/order/data/{$command}.prn";
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
            file_put_contents($file, implode("\n", $lines)); // Réécrire la liste sans les commandes traitées

            header('Content-Type: application/json');
            echo json_encode(['urls' => $urls], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
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
