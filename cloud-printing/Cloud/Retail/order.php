<?php
$statusFile = "db/status.json";

if (!empty($_POST['order'])) {
    $orders = $_POST['order'];

    // Rassembler les ingrédients
    $ingredients = [];
    foreach ($orders as $order) {
        $key = "{$order}_ingredients"; // Ex: Burger_ingredients
        $ingredients[] = $_POST[$key] ?? []; // Ajouter les ingrédients s'ils existent, sinon tableau vide
    }

    $address = $_POST['address'] ?? '';
    $remarks = $_POST['remarks'] ?? '';
    $nom = $_POST['nom'] ?? '';

    // Générer un seul fichier ZPL pour toutes les commandes
    $filename = strtoupper(substr(uniqid(), -4)) . ".prn"; // Nom unique pour le fichier ZPL
    $zpl_data = generateZPL($orders, $ingredients, $address, $remarks, $nom);
    file_put_contents("order/data/{$filename}", $zpl_data);

    // Ajouter le fichier à la file d'attente
    file_put_contents("db/list.txt", $filename . "\n", FILE_APPEND);

    // Mettre à jour les états des commandes
    $statusData = file_exists($statusFile) ? json_decode(file_get_contents($statusFile), true) : [];
    foreach ($orders as $order) {
        $statusData[$order] = 'pending';
    }
    file_put_contents($statusFile, json_encode($statusData, JSON_PRETTY_PRINT));

    echo json_encode(['message' => 'Commande enregistrée avec succès.'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else {
    echo json_encode(['error' => 'Aucune commande sélectionnée.'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

function wrapText($text, $maxLength) {
    $words = explode(' ', $text); // Divise le texte en mots
    $lines = [];
    $currentLine = '';

    foreach ($words as $word) {
        // Ajoute des mots à la ligne actuelle tant que la longueur reste inférieure à maxLength
        if (strlen($currentLine . ' ' . $word) <= $maxLength) {
            $currentLine .= ($currentLine === '' ? '' : ' ') . $word;
        } else {
            // Si la ligne est trop longue, elle est ajoutée au tableau des lignes
            $lines[] = $currentLine;
            $currentLine = $word; // Nouveau mot pour une nouvelle ligne
        }
    }
    // Ajoute la dernière ligne restante
    if (!empty($currentLine)) {
        $lines[] = $currentLine;
    }

    return $lines; // Renvoie un tableau de lignes
}

function generateZPL($orders, $ingredients, $address, $remarks, $nom) {
    $shortId = strtoupper(substr(uniqid(), -4)); // Identifiant unique court
    $zpl = "^XA\n";
    $zpl .= "^PW609\n";  // Largeur de l'imprimante (76mm)
    $zpl .= "^LL10\n";  // Longueur de l'étiquette (10mm)
    // Initialisation de la position Y
    $yPosition = 30;  // Position de départ pour l'impression
    $total = 0;

    // En-tête : Carré noir avec texte "BROTHER" en blanc
    $zpl .= "^FO20,20\n"; // Décalage du carré vers la gauche
    $zpl .= "^GB600,200,200,B,0^FS\n"; // Carré noir rempli (600x200)
    $zpl .= "^FO20,50\n"; // Décalage du texte vers la gauche
    $zpl .= "^FR\n";                  // Inversion des couleurs pour le texte blanc
    $zpl .= "^A0N,100,100\n";         // Définir la taille du texte
    $zpl .= "^FB600,1,0,C\n";         // Centrer le texte dans le carré
    $zpl .= "^FD BROTHER ^FS\n";      // Texte "BROTHER"

    $yPosition += 230; // Ajuster la position après le carré

    // Informations principales
    $zpl .= "^CF0,60\n";
    $zpl .= "^FO20,{$yPosition}^FD {$shortId}^FS\n"; // ID unique
    $zpl .= "^FO220,{$yPosition}^FD{$nom}^FS\n"; // Décalage du nom vers la gauche
    $yPosition += 70;

    // Informations commande
    $zpl .= "^CF0,40\n";
    $zpl .= "^FO20,{$yPosition}^FDCommande passee le " . date("d-m-Y H:i") . "^FS\n";
    $yPosition += 40;
    $zpl .= "^FO20,{$yPosition}^FDA preparer pour le " . date("d-m-Y H:i", strtotime("+15 minutes")) . "^FS\n";
    $yPosition += 50;

    // Section LIVRAISON
    $zpl .= "^CF0,50\n";
    $zpl .= "^FO170,{$yPosition}^FDLIVRAISON^FS\n"; // Déplacement de "LIVRAISON"
    $zpl .= "^FO0," . ($yPosition + 60) . "^GB580,3,3^FS\n"; // Ligne de séparation
    $yPosition += 80;

    // Affichage de l'adresse
    if (!empty($address)) {
        $zpl .= "^CF0,40\n^FO20,{$yPosition}^FDAdresse: ^FS\n"; // Déplacement de l'adresse
        $yPosition += 50;
        $addressLines = wrapText($address, 38);
        foreach ($addressLines as $line) {
            $zpl .= "^CF0,40\n^FO20,{$yPosition}^FD{$line}^FS\n";
            $yPosition += 50;
        }
    }

    // Découper les remarques en lignes
    if (!empty($remarks)) {
        $remarksLines = wrapText($remarks, 38);
        $zpl .= "^CF0,30\n^FO20,{$yPosition}^FDRemarque:^FS\n"; // Décalage de "Remarque:"
        $yPosition += 50;
        foreach ($remarksLines as $line) {
            $zpl .= "^FO20,{$yPosition}^FD{$line}^FS\n"; // Décalage des lignes de remarques
            $yPosition += 40;
        }
    }

    $zpl .= "^FO0,{$yPosition}^GB580,3,3^FS\n";
    $yPosition += 30;

    // Détails de la commande
    foreach ($orders as $index => $order) {
        $price = 15 + $index * 5; // Exemple de prix
        $total += $price;
        $zpl .= "^CF0,40\n^FO20,{$yPosition}^FD{$order} - {$price}Euro^FS\n"; // Décalage des commandes
        $yPosition += 50;

        if (!empty($ingredients[$index])) {
            foreach ($ingredients[$index] as $ingredient) {
                $zpl .= "^CF0,30\n^FO40,{$yPosition}^FD- {$ingredient}^FS\n"; // Décalage des ingrédients
                $yPosition += 40;
            }
        }
    }

    $zpl .= "^FO0,{$yPosition}^GB580,3,3^FS\n";
    $yPosition += 30;

    // Total final
    $zpl .= "^CF0,50\n^FO20,{$yPosition}^FDTotal: {$total}Euro^FS\n"; // Décalage du total

    // Fin du fichier ZPL
    $zpl .= "^XZ";

    // Calculer la hauteur totale en fonction de la position finale
    $height = $yPosition + 100;
    $zpl = str_replace("^LL10", "^LL{$height}", $zpl);

    return $zpl;
}



?>
