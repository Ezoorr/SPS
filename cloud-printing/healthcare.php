<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>HealthCare Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <section class="hero">
            <div class="hero-content" id="hero-message">
                <h1 class="animate__animated animate__fadeInDown">Formulaire HealthCare</h1>
                <form id="healthcare-form" method="post" class="form-container fade-in">
                    <div class="form-group">
                        <label>Date de naissance :</label>
                        <input type="date" name="dateDeNaissance" required>
                    </div>
                    <div class="form-group">
                        <label>Nom de naissance :</label>
                        <input type="text" name="nomDeNaissance" required>
                    </div>
                    <div class="form-group">
                        <label>Nom :</label>
                        <input type="text" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label>Prénom :</label>
                        <input type="text" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <label>Sexe :</label>
                        <select name="sexe" required>
                            <option value="">Sélectionnez un sexe</option>
                            <option value="H">Homme</option>
                            <option value="F">Femme</option>
                        </select>
                    </div>
                    <button type="submit" class="btn">Imprimer</button>
                </form>

                <?php
                // Traitement du formulaire
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Récupération des données du formulaire
                    $variables = [
                        'Variable1' => htmlspecialchars(trim($_POST['dateDeNaissance'])),
                        'Variable2' => htmlspecialchars(trim($_POST['nomDeNaissance'])),
                        'Variable3' => htmlspecialchars(trim($_POST['nom'])),
                        'Variable4' => htmlspecialchars(trim($_POST['prenom'])),
                        'Variable5' => htmlspecialchars(trim($_POST['sexe'])),
                    ];

                    // Modèle de base contenant les variables
                    $template = "^II^TS001Variable1,Variable2,Variable3,Variable4,Variable5^FF";

                    // Remplacement des variables par leurs valeurs
                    foreach ($variables as $key => $value) {
                        $template = str_replace($key, $value, $template);
                    }

                    // Affichage du modèle généré pour débogage (facultatif)
                    echo "<pre>Template généré :\n$template</pre>";

                    // Adresse IP de l'imprimante
                    $printerIp = '169.254.13.217'; // Remplacez par l'adresse de votre imprimante
                    $printerPort = 9100; // Port par défaut

                    // Envoi du template à l'imprimante
                    $fp = fsockopen($printerIp, $printerPort, $errno, $errstr, 30);
                    if (!$fp) {
                        echo "<div class='message'>Erreur de connexion à l'imprimante : $errstr ($errno)</div>";
                    } else {
                        fwrite($fp, $template); // Envoi du modèle
                        fclose($fp);
                        echo "<div class='message'>Impression envoyée avec succès !</div>";
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
