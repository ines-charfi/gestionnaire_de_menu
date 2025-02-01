<?php

// Vérifier que le bouton modifier a bien été cliqué
if (isset($_POST['btn-modifier']) && !empty($_POST['description']) && !empty($_POST['prix']) && !empty($_POST['catégorie'])) {
    // Connexion à la base de données avec PDO
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=gestionnaire_de_menu', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Extraction des informations envoyées dans des variables par la méthode POST
        $id = $_POST['id'];
        $description = $_POST['description'];
        $prix = $_POST['prix'];
        $catégorie = $_POST['catégorie'];

        // Gestion de l'upload de l'image (si elle est présente)
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $imageTmpName = $_FILES['image']['tmp_name'];
            $imageName = basename($_FILES['image']['name']);
            $imageDestination = 'uploads/' . $imageName;

            // Vérification de l'extension de l'image (ex. jpg, png, etc.)
            $validExtensions = ['jpg', 'jpeg', 'png'];
            $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

            if (in_array($imageExtension, $validExtensions)) {
                // Déplacer l'image dans le dossier "uploads"
                if (move_uploaded_file($imageTmpName, $imageDestination)) {
                    // L'image a été uploadée avec succès, on continue

                    // Requête préparée pour modifier les données dans la table menu
                    $query = "UPDATE plat SET description = :description, prix = :prix, image = :image, catégorie = :categorie WHERE id = :id";
                    $stmt = $pdo->prepare($query);

                    // Lier les paramètres
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':prix', $prix);
                    $stmt->bindParam(':image', $imageName);  // Enregistrer le nom de l'image dans la base de données
                    $stmt->bindParam(':categorie', $catégorie);
                    $stmt->bindParam(':id', $id);

                    // Exécuter la requête
                    $stmt->execute();

                    header("Location: plats.php");
                    exit();
                } else {
                    $message = "Erreur lors du téléchargement de l'image.";
                    exit();
                }
            } else {
                $message = "L'extension de l'image n'est pas valide. (jpg, jpeg, png uniquement)";
            }
        } else {
            // Pas d'image téléchargée, on laisse la valeur de l'image actuelle dans la base de données
            $imageName = null;
        }
    } catch (PDOException $e) {
        $message = $e->getMessage();
    }
} else {
    $message = "Tous les champs sont requis et une image doit être ajoutée.";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un menu</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="form">
        <a href="plats.php" class="back_btn"><img src="../images/back.jpg"> Retour</a>
        <h2>Modifier un plat</h2>
        <p class="erreur_message"><?php if (isset($message)) { ?>
            <p class="erreur_message"><?= htmlspecialchars($message) ?></p>
        <?php } ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>">

            <label>Description du plat</label>
            <textarea name="description" cols="30" rows="10"
                required><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>

            <label>Prix</label>
            <input type="number" step="any" name="prix" value="<?= isset($prix) ? $prix : 0 ?>" required>

            <label>Catégorie</label>
            <input type="text" name="catégorie" value="<?= isset($catégorie) ? htmlspecialchars($catégorie) : '' ?>"
                required>

            <label>Ajouter une image (facultatif)</label>
            <input type="file" name="image">

            <input type="submit" value="Modifier" name="btn-modifier">
            <a class="btn-liste-menu" href="liste_de_plats.php">Liste des plats</a>
        </form>
    </div>
</body>

</html>