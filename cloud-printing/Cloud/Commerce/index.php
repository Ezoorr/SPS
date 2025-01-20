<?php 
include '../../header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sélectionner les commandes</title>
    <link rel="stylesheet" href="../../style.css">  
    <style>
        .retail-grid {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .retail-grid-item {
            width: 30%;
            padding: 10px;
            box-sizing: border-box;
            text-align: center;
        }
        .retail-ingredients {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        .retail-item-name {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div id="product-selection">
    <div class="order-container">
        
        <form id="commerce-form" action="order.php" method="post">
            <label for="commerce-type"><i>choisissez le type de commerce :</i></label>
            <select id="commerce-type" name="commerce-type" onchange="toggleCommerce()">
                <option value="warehouse">e-commerce</option>
                <option value="retail">Food</option>
            </select>

            <!-- Section Entrepôt -->
            <div id="warehouse-selection">
            <h1 class="warehouse-title">Men in Black</h1>
                <p class="order-title">Vos Articles (Entrepôt) :</p>
                <div class="order-grid">
                    <div class="order-item">
                        <label>
                            <img src="images/veste.png" alt="A">
                            <div class="item-name">Chapeau</div>
                            <div class="item-price">15€</div>
                            <input type="checkbox" name="order[]" value="A">
                        </label>
                        <div class="warehouse-info"><i>Entrepôt A</i></div>
                    </div>
                    <div class="order-item">
                        <label>
                            <img src="images/teeshirt.png" alt="B">
                            <div class="item-name">Tee-shirt</div>
                            <div class="item-price">20€</div>
                            <input type="checkbox" name="order[]" value="B">
                        </label>
                        <div class="warehouse-info"><i>Entrepôt B</i></div>
                    </div>
                    <div class="order-item">
                        <label>
                            <img src="images/pantalon.png" alt="C">
                            <div class="item-name">Pantalon</div>
                            <div class="item-price">30€</div>
                            <input type="checkbox" name="order[]" value="C">
                        </label>
                        <div class="warehouse-info"><i>Entrepôt A</i></div>
                    </div>
                    <div class="order-item">
                        <label>
                            <img src="images/Chaussue.png" alt="D">
                            <div class="item-name">Chaussure</div>
                            <div class="item-price">50€</div>
                            <input type="checkbox" name="order[]" value="D">
                        </label>
                        <div class="warehouse-info"><i>Entrepôt B</i></div>
                    </div>
                </div>
            </div>

            <!-- Section Retail -->
            
            <div id="retail-selection" style="display:none;">
            <h1 class="warehouse-title">Brother</h1>
                <p class="retail-title">Choisissez votre commande :</p>
                <div class="retail-grid">
                    <div class="retail-grid-item">
                        <label>
                            <img src="images/burger.jpg" alt="burger">
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
                            <label><input type="checkbox" name="Pasta_ingredients[]" value="Crème fraîche"> Crème fraîche </label><br>
                            <label><input type="checkbox" name="Pasta_ingredients[]" value="Parmesan"> Parmesan </label><br>
                            <label><input type="checkbox" name="Pasta_ingredients[]" value="Basilic"> Basilic </label><br>
                        </div>
                    </div>
                </div>

                <label for="retail-address">Adresse de livraison:</label>
                <input type="text" id="retail-address" name="address" placeholder="Votre adresse"><br><br>

                <label for="retail-nom">Nom :</label>
                <input type="text" id="retail-nom" name="nom" placeholder="Votre nom"><br><br>

                <label for="retail-remarks">Remarque client:</label>
                <textarea id="retail-remarks" name="remarks" placeholder="Vos remarques..."></textarea><br><br>

                <button type="submit" class="retail-submit-button">Confirmer la commande</button>
            </div>
        </form>
    </div>
</div>

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

    function toggleCommerce() {
        var selectedCommerce = document.getElementById('commerce-type').value;
        if (selectedCommerce === 'retail') {
            document.getElementById('warehouse-selection').style.display = 'none';
            document.getElementById('retail-selection').style.display = 'block';
        } else {
            document.getElementById('warehouse-selection').style.display = 'block';
            document.getElementById('retail-selection').style.display = 'none';
        }
    }
</script>

</body>
<footer>
    <p>&copy; 2023 Votre Société. Tous droits réservés.</p>
</footer>
</html>