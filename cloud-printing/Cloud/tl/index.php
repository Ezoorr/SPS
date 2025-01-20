<?php
include('../../header.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'envoi</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../../style.css">
</head>
<body>
<form action="order.php" method="POST">
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <tr>
            <th colspan="2">1. Compte</th>
        </tr>
        <tr>
            <td>Compte :</td>
            <td>
                <select id="compte" name="compte">
                    <option value="27297500">BROTHER FRANCE</option>
                </select>
            </td>
        </tr>
    </table>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <th colspan="2">2. Expéditeur</th>
        </tr>
        
        <tr>
            <td>Nom :</td>
            <td><input type="text" name="exp_nom" value=""></td>
        </tr>
        <tr>
            <td>Prénom :</td>
            <td><input type="text" name="exp_prenom" value=""></td>
        </tr>

        <tr>
            <td>Adresse :</td>
            <td><input type="text" name="exp_adresse" value="165 avenue du Bois de la Pie"></td>
        </tr>
        <tr>
            <td>Ville :</td>
            <td><input type="text" name="exp_ville" value="ROISSY EN FRANCE"></td>
        </tr>
        <tr>
            <td>Code postal :</td>
            <td><input type="text" name="exp_cp" value="95700"></td>
        </tr>
    </table>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <th colspan="2">3. Destinataire</th>
        </tr>
        <tr id="pro_fields" style="display: none;">
            <td>Raison sociale :</td>
            <td><input type="text" name="dest_raison_sociale"></td>
        </tr>
        <tr id="pro_name" style="display: none;">
            <td>Société :</td>
            <td><input type="text" name="dest_nom"></td>
        </tr>
        <tr>
            <td>Nom et prénom :</td>
            <td><input type="text" name="dest_prenom"></td>
        </tr>

        <tr>
            <td>Adresse :</td>
            <td><input type="text" name="dest_adresse"></td>
        </tr>
        <tr>
            <td>Ville :</td>
            <td><input type="text" name="dest_ville"></td>
        </tr>
        <tr>
            <td>Code postal :</td>
            <td><input type="text" name="dest_cp"></td>
        </tr>
    </table>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <th colspan="2">4. Colis</th>
        </tr>
        <tr>
            <td>Nombre de colis :</td>
            <td><input type="number" name="colis_nombre" value="1"></td>
        </tr>
        <tr>
            <td>Poids unitaire (kg) :</td>
            <td><input type="number" step="0.01" name="colis_poids" value=""></td>
        </tr>
        <tr>
            <td>Date d'envoi :</td>
            <td><input type="date" name="colis_date" value="2024-12-30"></td>
        </tr>
    </table>

    <div style="margin-top: 20px; text-align: center;">
        <button type="submit">Valider et imprimer l'étiquette</button>
    </div>
</form>

<script>
    function toggleProFields() {
        const destType = document.getElementById('dest_type').value;
        const proFields = document.getElementById('pro_fields');
        const proName = document.getElementById('pro_name');

        if (destType === 'pro') {
            proFields.style.display = 'table-row';
            proName.style.display = 'table-row';
        } else {
            proFields.style.display = 'none';
            proName.style.display = 'none';
        }
    }
</script>

<footer>
        <p>&copy; 2023 Votre Société. Tous droits réservés.</p>
    </footer>
</body>
</html>
