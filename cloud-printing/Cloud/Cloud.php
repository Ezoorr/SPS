<?php include('../header.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SPS Form</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<main>
    <section class="hero">
        <div class="hero-content" id="hero-message">
            <h1 class="animate__animated animate__fadeInDown">Formulaire SPS</h1>
            <!-- Conteneur pour les rectangles -->
            <div class="main-sps">
                <div class="rectangle" style="background-image: url('images/ecommerce.jpg');" onclick="location.href='Commerce/index.php'">
                    <div class="label">E-commerce</div>
                </div>

                <div class="rectangle" style="background-image: url('images/delivery.png');" onclick="location.href='Retail/index.php'">
                    <div class="label">Retail</div>
                </div>

                <div class="rectangle" style="background-image: url('images/tl.png');" onclick="location.href='tl/index.php'">
                    <div class="label">T&L</div>
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