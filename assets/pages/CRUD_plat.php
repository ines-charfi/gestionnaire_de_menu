<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Connexion à la base de données
$host = 'localhost';
$dbname = 'gestionnaire_de_menu';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier si un ID est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les infos du produit correspondant
    $stmt = $pdo->prepare("SELECT * FROM plat WHERE id = ?");
    $stmt->execute([$id]);
    $plat = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$plat) {
        die("Produit introuvable.");
    }
} else {
    die("ID du produit non spécifié.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Modifier</title>
</head>
<body>
    <div class="form">
        <a href="menus.php" class="back_btn"><img src="../images/icons8-flèche-gauche-24.png"> Retour</a>
        <h2>Modifier un produit</h2>
        <p class="erreur_message">Veuillez remplir tous les champs !</p>

        <form action="db.php?action=ajouter" method="POST">
            <label>id</label>
            <input type="hidden" name="id"
                    value="<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>">


            <label>Nom du produit</label>
            <input type="text" name="nom" required>
            
            <label>Description du produit</label>
            <textarea name="description" required></textarea>
            
            <label>Prix</label>
            <input type="number" step="0.01" name="prix" required>
            
            <label>Catégorie</label>
            <input type="text" name="catégorie" required>

            <input type="submit" value="Ajouter">
        </form>

        <form action="db.php?action=modifier" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($plat['id']); ?>">
            
            <label>Nom</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($plat['nom']); ?>" required>
            
            <label>Description</label>
            <textarea name="description" required><?= htmlspecialchars($plat['description']); ?></textarea>
            
            <label>Prix</label>
            <input type="number" step="0.01" name="prix" value="<?= htmlspecialchars($plat['prix']); ?>" required>
            
            <label>Catégorie</label>
            <input type="text" name="catégorie" value="<?= htmlspecialchars($plat['catégorie']); ?>" required>

            <input type="submit" value="Modifier">
        </form>


    </div>
</body>
</html>