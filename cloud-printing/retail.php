<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test SPS Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <section class="hero">
            <div class="hero-content" id="hero-message">
                <h1 class="animate__animated animate__fadeInDown">Formulaire Test SPS</h1>
                <form id="test-sps-form" method="post" class="form-container fade-in">
                    <div class="form-group">
                        <label>Texte à imprimer :</label>
                        <input type="text" name="texte" required>
                    </div>
                    <button type="submit" class="btn">Imprimer</button>
                </form>

                <?php
                // Traitement du formulaire
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Récupération du texte du formulaire
                    $texte = $_POST['texte'];

                    // Format du template avec la variable Texte_5
                    $template = '^II^TS001' . $texte . '^FF';

                    // Adresse IP de l'imprimante
                    $printerIp = '10.0.20.10'; // Remplacez par l'adresse de votre imprimante
                    $printerPort = 9100; // Port par défaut

                    // Envoi à l'imprimante
                    $fp = fsockopen($printerIp, $printerPort, $errno, $errstr, 30);
                    if (!$fp) {
                        echo "<div class='message'>Erreur de connexion à l'imprimante : $errstr ($errno)</div>";
                    } else {
                        fwrite($fp, $template);
                        fclose($fp);
                        echo "<div class='message'>Impression envoyée avec succès avec le texte : $texte !</div>";
                    }
                }
                ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Votre Société. Tous droits réservés.</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>
