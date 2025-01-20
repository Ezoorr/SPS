<?php
include 'db.php'; // Inclusion de la connexion à la base de données
include '../header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commande d'Articles</title>
</head>
<body>
    <h1>Commande d'Articles</h1>
    <form action="generer_bons.php" method="post">
        <label for="article">Sélectionnez un ou plusieurs articles :</label>
        <select name="article_id[]" id="article" multiple size="5">
            <?php
            // Récupérer les articles depuis la base de données
            $stmt = $pdo->query("SELECT article_id, article_name FROM stock");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                echo "<option value='" . $row['article_id'] . "'>" . $row['article_name'] . "</option>";
                
            }
            ?>
        </select>
        <button type="submit">Passer la commande</button>
    </form>
</body>
</html>
