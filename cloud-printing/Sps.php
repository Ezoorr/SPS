<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SPS Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main>
    <section class="hero">
        <div class="hero-content" id="hero-message">
            <h1 class="animate__animated animate__fadeInDown">Formulaire SPS</h1>
            <!-- Conteneur pour les rectangles -->
            <div class="main-sps">
                <div class="rectangle" style="background-image: url('images/adresse.png');" onclick="location.href='SPS/Adresse.php'">
                    <div class="label">Adresse</div>
                </div>

                <div class="rectangle" style="background-image: url('images/SPS.png');" onclick="location.href='SPS/test.php'">
                    <div class="label">SPS</div>
                </div>

                <div class="rectangle" style="background-image: url('images/images_signature.jpg');" onclick="location.href='page3.php'">
                    <div class="label">Consommable</div>
                </div>

                <div class="rectangle" style="background-image: url('images/images_signature.jpg');" onclick="location.href='page4.php'">
                    <div class="label">Rectangle 4</div>
                </div>
            </div>
        </div>
    </section>
</main>

    <footer>
        <p>&copy; 2023 Votre Société. Tous droits réservés.</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>