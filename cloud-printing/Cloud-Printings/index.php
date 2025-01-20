<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sélectionner les commandes</title>
</head>
<body>
<form action="order.php" method="post">
    <p>Votre commande ?</p>
    <input type="checkbox" name="order[]" value="A"> A<br>
    <input type="checkbox" name="order[]" value="B"> B<br>
    <input type="checkbox" name="order[]" value="C"> C<br>
    <input type="checkbox" name="order[]" value="D"> D<br>
    <input type="checkbox" name="order[]" value="E"> E<br>
    <br>
    <input type="submit" value="Confirmer">
</form>
</body>
</html>
