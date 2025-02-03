<?php
// Vérifier que le bouton ajouter a bien été cliqué
if (isset($_POST['btn_ajouter']) && !empty($_POST['description']) && !empty($_POST['prix']) && !empty($_FILES['image']) && !empty($_POST['catégorie'])) {
    try {
        // Connexion à la base de données avec PDO
        $pdo = new PDO("mysql:host=localhost:3306;dbname=ines-charfi_gestionnaire_de_menu", 'ines-charfi', 'ines2610.');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupérer les données du formulaire
        $description = $_POST['description'];
        $poids = $_POST['poids'];

                $query = "INSERT INTO ingredients (description, poid,) VALUES (:description, :poid)";
                $stmt = $pdo->prepare($query);

                // Lier les paramètres à la requête SQL
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':prix', $poids);
                //var_dump($description, $poid); // Déboguer les données

                // Exécuter la requête
                $stmt->execute();

                // Si l'insertion est réussie, redirection vers menus.php
                header("Location: liste_de_plats.php");
                exit();
            }
        
        
     catch (PDOException $e) {
        // Si une erreur survient, affichez le message d'erreur
        $message = "ingredient non ajouté : " . $e->getMessage();
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
    <title>Ajouter un ingredient</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
        
    <div class="form">
        <a href="plats.php" class="back_btn"><img src="./assets/images/back.jpg" alt="Retour"> Retour</a>
        <h2>Ajouter un ingredient</h2>

        <?php if (isset($message)) { ?>
            <p class="erreur_message"><?= htmlspecialchars($message) ?></p>
        <?php } ?>

        <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id"
                                value="<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>">

                        
                        
                        <label>Description de l'ingredient</label>
                        <textarea name="description" cols="30" rows="10"
                                required><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>

                        <label>Poids</label>
                        <input type="number" step="any" name="poid" value="<?= isset($poids) ? $poids : 0 ?>" required>

                        
                
                        <input type="submit" value="Ajouter" name="btn_ajouter">
                        <a class="btn-liste-menu" href="listes_des_ingredients.php">Liste des ingredients</a>
                        
        </form>
    </div>
</body>
</html>
