<?php
// Vérifier si des commandes ont été envoyées
if (!empty($_POST['order'])) {
    $orders = $_POST['order'];

    // Enregistrer les commandes dans le fichier
    $fp = fopen("db/list.txt", "a");
    foreach ($orders as $order) {
        fwrite($fp, $order . "\n");
    }
    fclose($fp);

    echo "Commandes confirmées : " . implode(", ", $orders);
} else {
    echo "Aucune commande sélectionnée.";
}
?>
