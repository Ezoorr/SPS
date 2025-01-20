<?php
include 'db.php'; // Inclusion de la base de données

if (isset($_POST['article_id'])) {
    $articleIds = $_POST['article_id']; // Récupérer les articles sélectionnés

    foreach ($articleIds as $articleId) {
        // Récupérer les informations de l'article depuis la base de données
        $stmt = $pdo->prepare("SELECT * FROM stock WHERE article_id = ?");
        $stmt->execute([$articleId]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($article) {
            // Vérifier l'entrepôt (Paris ou Lyon)
            if ($article['warehouse'] == 'Paris') {
                // URL pour l'imprimante de Paris
                $urlImprimanteParis = "http://localhost/cloud-printing/Cloud-Printings/imprimer.php?article_id=" . $articleId;
                echo "Bon de livraison pour Paris généré : <a href='$urlImprimanteParis'>Imprimer</a><br>";
            } elseif ($article['warehouse'] == 'Lyon') {
                // URL pour l'imprimante de Lyon
                $urlImprimanteLyon = "http://localhost/cloud-printing/Cloud-Printings/imprimer.php?article_id=" . $articleId;
                echo "Bon de livraison pour Lyon généré : <a href='$urlImprimanteLyon'>Imprimer</a><br>";
            }
        } else {
            echo "Article non trouvé.<br>";
        }
    }
} else {
    echo "Aucun article sélectionné.";
}
?>
