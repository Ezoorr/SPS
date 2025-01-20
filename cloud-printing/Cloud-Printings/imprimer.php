<?php
// Inclusion de la base de données
include 'db.php';

if (isset($_GET['article_id'])) {
    $articleId = $_GET['article_id']; // Récupérer l'ID de l'article

    // Récupérer les informations de l'article depuis la base de données
    $stmt = $pdo->prepare("SELECT * FROM stock WHERE article_id = ?");
    $stmt->execute([$articleId]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($article) {
        // Créer le contenu ZPL brut à envoyer à l'imprimante
        $zplContent = 
            "^XA
            ^FO50,50^ADN,36,20^FDArticle: " . $article['article_name'] . "^FS
            ^FO50,100^ADN,36,20^FDID: " . $article['article_id'] . "^FS
            ^FO50,150^ADN,36,20^FDStock: " . $article['warehouse'] . "^FS
            ^XZ";

        // Définir le type de contenu pour l'envoi
        header('Content-Type: application/x-zpl'); // Spécifie que le contenu est en ZPL
        echo $zplContent; // Renvoie le contenu ZPL brut à l'imprimante
        exit();
    } else {
        // Si l'article n'est pas trouvé, retourner une erreur 404
        header("HTTP/1.1 404 Not Found");
        echo "Article non trouvé.";
        exit();
    }
} else {
    echo "Aucun article sélectionné.";
}
?>
