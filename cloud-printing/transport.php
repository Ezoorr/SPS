<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Transport & Logistic</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <section class="hero">
            <div class="hero-content" id="hero-message">
                <h1 class="animate__animated animate__fadeInDown">Transport & Logistic</h1>
                <form id="print-form" method="post" enctype="multipart/form-data" class="form-container fade-in">
                    <label for="printer-ip">Adresse IP de la machine :</label>
                    <input type="text" id="printer-ip" name="printer-ip" value="<?php echo isset($_POST['printer-ip']) ? htmlspecialchars($_POST['printer-ip']) : ''; ?>" required>
                    
                    <label for="prn-file">Importer un fichier :</label>
                    <input type="file" id="prn-file" name="prn-file" required value="1">
                    
                    <label for="print-quantity">Quantité d'impression :</label>
                    <input type="number" id="print-quantity" name="print-quantity" min="1" value="<?php echo isset($_POST['print-quantity']) ? (int)$_POST['print-quantity'] : ''; ?>" required>
                    
                    <button type="submit" class="btn">Envoyer</button>
                </form>

                <?php

                // Traitement du formulaire

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $printerIp = $_POST['printer-ip'];
                    $file = $_FILES['prn-file'];
                    $printQuantity = (int)$_POST['print-quantity'];
                    
                    if ($file['error'] == UPLOAD_ERR_OK) {
                        $filePath = $file['tmp_name'];
                        $fileContent = file_get_contents($filePath);
                        
                        for ($i = 0; $i < $printQuantity; $i++) {
                            $fp = fsockopen($printerIp, 9100, $errno, $errstr, 30);
                            if (!$fp) {
                                // Afficher un message d'erreur si la connexion échoue
                                echo "<div class='message'>Erreur de connexion à l'imprimante : $errstr ($errno)</div>";
                                break; // Arrête la boucle en cas d'erreur
                            } else {
                                fwrite($fp, $fileContent);
                                fclose($fp);
                            }
                        }
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
