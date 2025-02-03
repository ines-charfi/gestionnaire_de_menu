<?php
// Vérifier que le bouton ajouter a bien été cliqué
if (isset($_POST['btn_ajouter']) && !empty($_POST['description']) && !empty($_POST['prix']) && !empty($_FILES['image']) && !empty($_POST['catégorie'])) {
    try {
        // Connexion à la base de données avec PDO
        $pdo = new PDO("mysql:host=localhost:3306;dbname=ines-charfi_gestionnaire_de_menu", username:'ines-charfi', password:'ines2610.');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupérer les données du formulaire
        $description = $_POST['description'];
        $prix = $_POST['prix'];
        $image = $_FILES['image'];
        $catégorie = $_POST['catégorie'];

        $imageName = null;

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
                $query = "INSERT INTO plat (description, prix, image, catégorie) VALUES (:description, :prix, :image, :catégorie)";
                $stmt = $pdo->prepare($query);

                // Lier les paramètres à la requête SQL
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':prix', $prix);
                $stmt->bindParam(':image', $imageName); // Enregistrer le nom de l'image dans la base de données
                $stmt->bindParam(':catégorie', $catégorie);
                //var_dump($description, $prix, $imageName, $catégorie); // Déboguer les données

                // Exécuter la requête
                $stmt->execute();

                // Si l'insertion est réussie, redirection vers menus.php
                header("Location: plats.php");
                exit();
            }
        
        } else {
            $message = "L'extension de l'image n'est pas valide. (jpg, jpeg, png uniquement)";
        }
        } else {
                $message = "Erreur lors du téléchargement de l'image.";
        }
        } catch (PDOException $e) {
        // Si une erreur survient, affichez le message d'erreur
        $message = "Menu non ajouté : " . $e->getMessage();
        }
                }
 else {
// Si tous les champs ne sont pas remplis, affichez un message d'erreur
$message = "Veuillez remplir tous les champs !";
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un menu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
        
    <div class="form">
        <a href="plats.php" class="back_btn"><img src="./assets/images/back.jpg" alt="Retour"> Retour</a>
        <h2>Ajouter un plat</h2>

        <?php if (isset($message)) { ?>
            <p class="erreur_message"><?= htmlspecialchars($message) ?></p>
        <?php } ?>

        <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id"
                                value="<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>">

                        <label>Description du menu</label>
                        <textarea name="description" cols="30" rows="10"
                                required><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>

                        <label>Prix</label>
                        <input type="number" step="any" name="prix" value="<?= isset($prix) ? $prix : 0 ?>" required>

                        <label>Catégorie</label>
                        <input type="text" name="catégorie"
                                value="<?= isset($catégorie) ? htmlspecialchars($catégorie) : '' ?>" required>

                        <label>Ajouter une image (facultatif)</label>
                        <input type="file" name="image">
                        <input type="submit" value="Ajouter" name="btn_ajouter">
                        <a class="btn-liste-menu" href="liste_de_plats.php">Liste des plats</a>
                        
        </form>
    </div>
</body>
</html>
