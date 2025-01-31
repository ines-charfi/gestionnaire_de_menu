<?php
session_start();

// Vérifier si les produits sont stockés en session, sinon initialiser un tableau vide
if (!isset($_SESSION['plat'])) {
    $_SESSION['plat'] = [
        ['id' => 1, 'nom' => 'Napolitaine', 'description' => 'Sauce tomate, Mozzarella, Chorizo, Basilic frais', 'prix' => 14, 'categorie' => 'Pizza'],
        ['id' => 2, 'nom' => 'Champignons', 'description' => 'Crème fraîche, Mozzarella, Champignons', 'prix' => 15, 'categorie' => 'Pizza'],
        // Ajoutez d'autres produits initiaux ici...
    ];
}

// Ajouter un produit en session
if (isset($_POST['btn-ajouter']) && $_POST['btn-ajouter'] == 'Ajouter') {
    if (!empty($_POST['nom']) && !empty($_POST['description']) && !empty($_POST['prix']) && !empty($_POST['categorie'])) {
        $id = count($_SESSION['plat']) + 1; // Générer un nouvel ID basé sur le nombre actuel de produits
        $plats = [
            'id' => $id,
            'nom' => $_POST['nom'],
            'description' => $_POST['description'],
            'prix' => $_POST['prix'],
            'categorie' => $_POST['categorie'],
        ];
        $_SESSION['plat'][] = $plats; // Ajouter le produit au tableau en session
    }
}

// Modifier un produit en session
if (isset($_POST['btn-ajouter']) && $_POST['btn-ajouter'] == 'Modifier') {
    foreach ($_SESSION['plat'] as &$plats) {
        if ($plats['id'] == $_POST['id']) {
            $plats['nom'] = $_POST['nom'];
            $plats['description'] = $_POST['description'];
            $plats['prix'] = $_POST['prix'];
            $plats['categorie'] = $_POST['categorie'];
        }
    }
}

// Supprimer un produit en session
if (isset($_POST['btn-ajouter']) && $_POST['btn-ajouter'] == 'Supprimer') {
    foreach ($_SESSION['plat'] as $key => $plats) {
        if ($plats['id'] == $_POST['id']) {
            unset($_SESSION['plat'][$key]); // Supprimer le produit du tableau en session
            $_SESSION['plat'] = array_values($_SESSION['plat']); // Réindexer le tableau
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../pages/style.css">
    <title>Modifier</title>
</head>
<body>
    <div class="form">
        <a href="menus.php" class="back_btn"><img src="../images/icons8-flèche-gauche-24.png"> Retour</a>
        <h2>Modifier un produit</h2>
        <p class="erreur_message">Veuillez remplir tous les champs !</p>

        <form action="" method="POST">
            <label>Nom du produit</label>
            <input type="text" name="nom" required>

            <label>Description du produit</label>
            <textarea name="description" cols="30" rows="10" required></textarea>

            <label>Prix</label>
            <input type="number" name="prix" required>

            <label>Catégorie</label>
            <input type="text" name="catégorie" required>

            <label>ID du produit</label>
            <input type="number" name="id" required>

            <input type="submit" value="Ajouter" name="btn-ajouter">
            <input type="submit" value="Modifier" name="btn-ajouter">
            <input type="submit" value="Supprimer" name="btn-ajouter">
        </form>
    </div>
</body>
</html>