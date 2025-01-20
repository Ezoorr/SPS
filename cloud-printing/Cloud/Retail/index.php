<?php 
include '../../header.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sélectionner votre commande</title>
    
    <link rel="stylesheet" href="../../style.css">  

    
</head>
<body>
    <center>
<div id="retail-product-selection">
    <div class="retail-container">
        <form action="order.php" method="post">
            <p class="retail-title">Choisissez votre commande :</p>
            <div class="retail-grid">
                <div class="retail-grid-item">
                    <label>
                        <img src="images/burger.jpg" alt="Burger">
                        <div class="retail-item-name">Burger</div>
                        <div class="retail-price">15€</div>
                        <input type="checkbox" name="order[]" value="Burger" id="retail-burger">
                    </label>
                    <div id="retail-burger-ingredients" class="retail-ingredients" style="display:none;">
                        <label><input type="checkbox" name="Burger_ingredients[]" value="Fromage"> Fromage </label><br>
                        <label><input type="checkbox" name="Burger_ingredients[]" value="Bacon"> Bacon </label><br>
                        <label><input type="checkbox" name="Burger_ingredients[]" value="Salade"> Salade </label><br>
                        <label><input type="checkbox" name="Burger_ingredients[]" value="Oignons"> Oignons </label><br>
                    </div>
                </div>
                <div class="retail-grid-item">
                    <label>
                        <img src="images/pizza.jpg" alt="Pizza">
                        <div class="retail-item-name">Pizza</div>
                        <div class="retail-price">20€</div>
                        <input type="checkbox" name="order[]" value="Pizza" id="retail-pizza">
                    </label>
                    <div id="retail-pizza-ingredients" class="retail-ingredients" style="display:none;">
                        <label><input type="checkbox" name="Pizza_ingredients[]" value="Mozzarella"> Mozzarella </label><br>
                        <label><input type="checkbox" name="Pizza_ingredients[]" value="Pepperoni"> Pepperoni </label><br>
                        <label><input type="checkbox" name="Pizza_ingredients[]" value="Champignons"> Champignons </label><br>
                        <label><input type="checkbox" name="Pizza_ingredients[]" value="Olives"> Olives </label><br>
                    </div>
                </div>
                <div class="retail-grid-item">
                    <label>
                        <img src="images/pasta.jpg" alt="Pasta">
                        <div class="retail-item-name">Pasta</div>
                        <div class="retail-price">25€</div>
                        <input type="checkbox" name="order[]" value="Pasta" id="retail-pasta">
                    </label>
                    <div id="retail-pasta-ingredients" class="retail-ingredients" style="display:none;">
                        <label><input type="checkbox" name="Pasta_ingredients[]" value="Sauce tomate"> Sauce tomate </label><br>
                        <label><input type="checkbox" name="Pasta_ingredients[]" value="Creme fraiche"> Crème fraîche </label><br>
                        <label><input type="checkbox" name="Pasta_ingredients[]" value="Parmesan"> Parmesan </label><br>
                        <label><input type="checkbox" name="Pasta_ingredients[]" value="Basilic"> Basilic </label><br>
                    </div>
                </div>
            </div>

            <label for="retail-address">Adresse de livraison:</label>
            <input type="text" id="retail-address" name="address" placeholder="Votre adresse"><br><br>

            <label for="retail-nom">Nom : </label>
            <input type="text" id="retail-nom" name="nom" placeholder="Votre nom"><br><br>

            <label for="retail-remarks">Remarque client:</label>
            <textarea id="retail-remarks" name="remarks" placeholder="Vos remarques..."></textarea><br><br>

            <button type="submit" class="retail-submit-button">Confirmer la commande</button>
        </form>
    </div>
</div></center>

<script>
    // Script pour afficher/masquer les ingrédients en fonction du menu sélectionné
    document.getElementById('retail-burger').addEventListener('change', function() {
        document.getElementById('retail-burger-ingredients').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('retail-pizza').addEventListener('change', function() {
        document.getElementById('retail-pizza-ingredients').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('retail-pasta').addEventListener('change', function() {
        document.getElementById('retail-pasta-ingredients').style.display = this.checked ? 'block' : 'none';
    });
</script>
</body>
<footer>
        <p>&copy; 2023 Votre Société. Tous droits réservés.</p>
    </footer>
</html>
