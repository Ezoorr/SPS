<?php 
include '../header.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>HealthCare Form</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <main>
        <section class="hero">
            <div class="hero-content" id="hero-message">
                <h1 class="animate__animated animate__fadeInDown">Formulaire envoi</h1>
                <form id="healthcare-form" method="post" class="form-container fade-in">
                    <div class="form-group">
                        <label>Nom et prénom :</label>
                        <input type="text" name="Variable1" required>
                    </div>
                    <div class="form-group">
                        <label>Adresse :</label>
                        <input type="text" name="Variable2" required>
                    </div>
                    <div class="form-group">
                        <label>Code postal et Ville :</label>
                        <input type="text" name="Variable3" required>
                    </div>
                    <button type="submit" class="btn">Imprimer</button>
                </form>

                <?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $variable1 = $_POST['Variable1']; // Nom et prénom
    $variable2 = $_POST['Variable2']; // Adresse
    $variable3 = $_POST['Variable3']; // Ville

    // Modèle de base contenant les variables
    $template = "^II^TS001Variable1,Variable2,Variable3^FF";

    // Remplacement des variables par les données saisies
    $template = str_replace("Variable1", $variable1, $template);
    $template = str_replace("Variable2", $variable2, $template);
    $template = str_replace("Variable3", $variable3, $template);

    // Affichage du template pour vérification (optionnel)
    echo "<pre>Template généré :\n$template</pre>";

    // Adresse IP de l'imprimante
    $printerIp = '10.0.20.13'; // Remplacez par l'adresse de votre imprimante
    $printerPort = 9100; // Port par défaut

    // Envoi à l'imprimante
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

   
