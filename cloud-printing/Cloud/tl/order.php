<?php
$statusFile = "db/status.json";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $compte = $_POST['compte'] ?? '';
    $exp_raison_sociale = $_POST['exp_raison_sociale'] ?? '';
    $exp_nom = $_POST['exp_nom'] ?? '';
    $exp_prenom = $_POST['exp_prenom'] ?? '';
    $exp_tel = $_POST['exp_tel'] ?? '';
    $exp_email = $_POST['exp_email'] ?? '';
    $exp_adresse = $_POST['exp_adresse'] ?? '';
    $exp_ville = $_POST['exp_ville'] ?? '';
    $exp_cp = $_POST['exp_cp'] ?? '';

    $dest_type = $_POST['dest_type'] ?? '';
    $dest_raison_sociale = $_POST['dest_raison_sociale'] ?? '';
    $dest_nom = $_POST['dest_nom'] ?? '';
    $dest_prenom = $_POST['dest_prenom'] ?? '';
    $dest_tel = $_POST['dest_tel'] ?? '';
    $dest_email = $_POST['dest_email'] ?? '';
    $dest_adresse = $_POST['dest_adresse'] ?? '';
    $dest_ville = $_POST['dest_ville'] ?? '';
    $dest_cp = $_POST['dest_cp'] ?? '';

    $colis_nombre = $_POST['colis_nombre'] ?? 1;
    $colis_poids = $_POST['colis_poids'] ?? 0;
    $colis_nom = $_POST['colis_nom'] ?? '';
    $colis_date = $_POST['colis_date'] ?? date("Y-m-d");

    // Générer un fichier ZPL
    $filename = strtoupper(substr(uniqid(), -4)) . ".prn"; // Nom unique pour le fichier ZPL
    $zpl_data = generateZPL(
        $compte,
        $exp_raison_sociale,
        $exp_nom,
        $exp_prenom,
        $exp_tel,
        $exp_email,
        $exp_adresse,
        $exp_ville,
        $exp_cp,
        $dest_type,
        $dest_raison_sociale,
        $dest_nom,
        $dest_prenom,
        $dest_tel,
        $dest_email,
        $dest_adresse,
        $dest_ville,
        $dest_cp,
        $colis_nombre,
        $colis_poids,
        $colis_nom,
        $colis_date
    );
    file_put_contents("order/data/{$filename}", $zpl_data);

    // Ajouter le fichier à la file d'attente
    file_put_contents("db/list.txt", $filename . "\n", FILE_APPEND);

    echo json_encode(['message' => 'Commande enregistrée avec succès.'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else {
    echo json_encode(['error' => 'Requête invalide.'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

function generateZPL(
    $compte,
    $exp_raison_sociale,
    $exp_nom,
    $exp_prenom,
    $exp_tel,
    $exp_email,
    $exp_adresse,
    $exp_ville,
    $exp_cp,
    $dest_type,
    $dest_raison_sociale = '',
    $dest_nom = '',
    $dest_prenom,
    $dest_tel,
    $dest_email,
    $dest_adresse,
    $dest_ville,
    $dest_cp,
    $colis_nombre,
    $colis_poids,
    $colis_nom,
    $colis_date
) {
    $exp_nom = $_POST['exp_nom'] ?? '';
    $exp_prenom = $_POST['exp_prenom'] ?? '';
    $exp_adresse = $_POST['exp_adresse'] ?? '';
    $exp_ville = $_POST['exp_ville'] ?? '';
    $exp_cp = $_POST['exp_cp'] ?? '';
    
    $dest_type = $_POST['dest_type'] ?? 'part';
    $dest_raison_sociale = $_POST['dest_raison_sociale'] ?? '';
    $dest_nom = $_POST['dest_nom'] ?? '';
    $dest_prenom = $_POST['dest_prenom'] ?? '';
    $dest_adresse = $_POST['dest_adresse'] ?? '';
    $dest_ville = $_POST['dest_ville'] ?? '';
    $dest_cp = $_POST['dest_cp'] ?? '';
    
    $colis_nombre = $_POST['colis_nombre'] ?? 1;
    $colis_poids = $_POST['colis_poids'] ?? '0';
    $colis_date = $_POST['colis_date'] ?? date('Y-m-d');
    
    // Création du code ZPL avec les données dynamiques
    $zpl = "^XA\n";
    $zpl .= "^SZ2^JMA\n";
    $zpl .= "^MCY^PMN\n";
    $zpl .= "^PW1787\n";
    $zpl .= "~JSN\n";
    $zpl .= "^JZY\n";
    $zpl .= "^LH0,0^LRN\n";
    $zpl .= "^XZ\n";
    
    $zpl .= "^XA\n";
    $zpl .= "^FT41,241\n";
    $zpl .= "^CI0\n";
    $zpl .= "^FT550,200\n";
    $zpl .= "^A0N,110,149^FDBROTHER ^FS\n";
    $zpl .= "^FT377,460\n";
    $zpl .= "^A0N,84,88^FDINFORMATION DE LIVRAISON^FS\n";
    
    // Informations expéditeur
    $zpl .= "^FT41,679\n";
    $zpl .= "^A0N,51,69^FDExpediteur:^FS\n";
    $zpl .= "^FT144,776\n";
    $zpl .= "^A0N,51,69^FD{$exp_nom} {$exp_prenom}^FS\n";
    $zpl .= "^FT144,849\n";
    $zpl .= "^A0N,51,69^FD{$exp_adresse}^FS\n";
    $zpl .= "^FT144,918\n";
    $zpl .= "^A0N,51,69^FD{$exp_cp}^FS\n";
    $zpl .= "^FT339,918\n";
    $zpl .= "^A0N,51,69^FD{$exp_ville}^FS\n";
    
    // Informations destinataire
    $zpl .= "^FT41,1148\n";
    $zpl .= "^A0N,51,69^FDDestinataire:^FS\n";
  
        $zpl .= "^FT144,1243\n";
        $zpl .= "^A0N,51,69^FD{$dest_prenom}^FS\n";
  
    $zpl .= "^FT144,1316\n";
    $zpl .= "^A0N,51,69^FD{$dest_adresse}^FS\n";
  
    $zpl .= "^FT144,1385\n";
    $zpl .= "^A0N,51,69^FD{$dest_ville} {$dest_cp}^FS\n";
    
    // Informations colis
    $zpl .= "^FT144,1602\n";
    $zpl .= "^A0N,51,69^FD{$colis_nombre} x {$colis_poids} kg^FS\n";
    $zpl .= "^FT144,1692\n";
    $zpl .= "^A0N,51,69^FDDate d'envoi: {$colis_date}^FS\n";
    
    // Ajout du code-barres et du texte
    $zpl .= "^FT258,2240\n";
    $zpl .= "^BY4^BCN,274,N,N^FD>:>8(00) 0 5>5907654>6 3>521000003>6 9^FS\n";
    $zpl .= "^FT228,2340\n";
    $zpl .= "^A0N,84,113^FD(00) 0 5907654 321000003 9^FS\n";
    $zpl .= "^GB1715,2466,4^FS\n";
    // Code de fin
    $zpl .= "^PQ1,0,1,Y\n";
    $zpl .= "^XZ\n";
    
    return $zpl;
}

?>
