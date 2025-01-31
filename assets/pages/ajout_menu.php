<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'gestionnaire_de_menu';
$username = 'root';
$password = '';
if (isset($_POST['btn_ajouter'])) {
    // Vérifier si les champs sont remplis
    if (isset($_POST['description']) && isset($_POST['prix']) && isset($_POST['catégorie']) && $_POST['description'] != "" && $_POST['prix'] != "" && $_POST['catégorie'] != "") {

        try {
            // Connexion à la base de données avec PDO
            $pdo = new PDO('mysql:host=localhost;dbname=gestionnaire_de_menu', 'root', ''); // Remplace ces valeurs par celles de ta base de données
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Extraction des données du formulaire
            $description = $_POST['description'];
            $prix = $_POST['prix'];
            $catégorie = $_POST['catégorie'];

            // Gestion de l'upload de l'image
            $imageName = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $imageTmpName = $_FILES['image']['tmp_name'];
                $imageName = basename($_FILES['image']['name']);
                $imageDestination = 'uploads/' . $imageName;

                // Vérification de l'extension de l'image (jpg, jpeg, png)
                $validExtensions = ['jpg', 'jpeg', 'png'];
                $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

                if (in_array($imageExtension, $validExtensions)) {
                    // Déplacer l'image dans le dossier "uploads"
                    if (!move_uploaded_file($imageTmpName, $imageDestination)) {
                        $message = "Erreur lors du téléchargement de l'image.";
                    }
                } else {
                    $message = "L'extension de l'image n'est pas valide (jpg, jpeg, png uniquement).";
                }
            }

            // Préparer la requête SQL pour insérer le menu
            $sql = "INSERT INTO menu (description, prix, image, catégorie) VALUES (:description, :prix, :image, :catégorie)";
            $stmt = $pdo->prepare($sql);

            // Lier les paramètres à la requête préparée
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':prix', $prix);
            $stmt->bindParam(':image', $imageName); // Enregistrer le nom de l'image dans la base de données
            $stmt->bindParam(':catégorie', $catégorie);

            // Exécuter la requête
            $stmt->execute();
            // Vérifier si l'insertion réussit
            if ($stmt->execute()) {
                // Si l'insertion réussit, rediriger vers la page de visualisation des menus
                header("location:index.php");
                exit();
            } else {
                // Si l'insertion échoue
                $message = "Échec de l'ajout du menu.";
            }

        } catch (PDOException $e) {
            // Gestion des erreurs de connexion
            $message = "Erreur de connexion à la base de données: " . $e->getMessage();
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Menu</title>
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
    </div>
</body>

</html>
