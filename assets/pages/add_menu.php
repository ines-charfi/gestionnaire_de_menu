<?php
// Connexion à la base de données
$host = 'localhost';  // Votre hôte
$dbname = 'gestionnaire_de_menu';  // Nom de la base de données
$username = 'root';  // Utilisateur
$password = '';  // Mot de passe

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $catégorie = $_POST['catégorie'];

    
    }

    // Préparer la requête SQL
    // Requête SQL sans l'utilisation de bindParam()
    $sql = "INSERT INTO menu (description, prix, image, catégorie) VALUES (:description, :prix, :image, :catégorie)";
    $stmt = $pdo->prepare($sql);

     // Lier les paramètres à la requête préparée
     $stmt->bindParam(':description', $description);
     $stmt->bindParam(':prix', $prix);
     $stmt->bindParam(':image', $imageName); // Enregistrer le nom de l'image dans la base de données
     $stmt->bindParam(':catégorie', $catégorie);
// Exécuter la requête
   $stmt->execute();
    echo "Le menu a été ajouté avec succès";

// Vérification si l'exécution a réussi
if ($stmt->rowCount() > 0) {
    echo "Le menu a été ajouté avec succès.";
} else {
    echo "Une erreur est survenue lors de l'ajout du menu.";
}
    
    // Si une image a été téléchargée, déplacer le fichier vers le dossier des images
    $image = $_SERVER['DOCUMENT_ROOT'] . '/gestionmaire_de_menu/images/' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $image);
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $fileType = mime_content_type($_FILES['image']['tmp_name']);
    
    if (!in_array($fileType, $allowedTypes)) {
        die('Le fichier téléchargé n\'est pas une image valide.');
    }
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        die("Erreur lors du téléchargement de l'image : " . $_FILES['image']['error']);
    }
            
?>

<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ajouter un menu</title>
        <link rel="stylesheet" href="style.css">

        
    </head>
    <body>
    <div class="form">
        <a href="index.php" class="back_btn"><img src="../images/back.jpg" alt="Retour"> Retour</a>
        <h2>Ajouter un menu</h2>

        <?php if (isset($message)) { ?>
            <p class="erreur_message"><?= htmlspecialchars($message) ?></p>
        <?php } ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <label>Description du menu</label>
            <textarea name="description" cols="30" rows="10" required><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>

            <label>Prix</label>
            <input type="number" step="any" name="prix" value="<?= isset($prix) ? htmlspecialchars($prix) : '' ?>" required>

            <label>Catégorie</label>
            <input type="text" name="catégorie" value="<?= isset($catégorie) ? htmlspecialchars($catégorie) : '' ?>" required>

            <label>Ajouter une image (facultatif)</label>
            <input type="file" name="image">

            <input type="submit" value="Ajouter" name="btn-ajouter">
            <a class="btn-liste-menu" href="menu.php">Liste de menu</a>
        </form>
        
    </body>
    
</html>

