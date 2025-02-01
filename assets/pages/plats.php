<?php

if (isset($_POST['btn_ajouter'])) {
    try {
        // Connexion à la base de données avec PDO
        $pdo = new PDO('mysql:host=localhost;dbname=gestionnaire_de_menu', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

    // Récupération des données du formulaire
    $id = $_POST['id'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $image = $_POST['image'];
    $catégorie = $_POST['catégorie'];

    // Vérification que les champs ne sont pas vides
    if (!empty($id) && !empty($description) && !empty($prix) && !empty($image) && !empty($catégorie)) {
        // Préparer la requête SQL pour vérifier si le produit existe déjà
        $stmt = $pdo->prepare("SELECT * FROM plat WHERE id = :id AND description  = :description AND prix = :prix AND image = :image AND catégorie = :catégorie");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':catégorie', $catégorie);
        // Exécuter la requête
        $stmt->execute();

        // Vérification si l'élément existe déjà
        $stmt = $pdo->prepare("SELECT * FROM plat WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            // Si le produit existe déjà
            $message = '<p style="color: #ff800">Le produit existe déjà</p>';
        } else {
            // Ajouter le produit à la base de données si il n'existe pas
            $insertStmt = $pdo->prepare("INSERT INTO plat (id, description , prix, image , catégorie) VALUES (:id, :description,:prix,:image,:catégorie)");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':prix', $prix);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':catégorie', $catégorie);
            $insertStmt->execute();

            $message = '<p style="color:green">Produit ajouté avec succès</p>';
        }
        // Vérifier si un fichier a été téléchargé
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            // Si une image a été téléchargée
            $img_nom = $_FILES['image']['name'];  // Récupérer le nom original de l'image
            $tmp_nom = $_FILES['image']['tmp_name']; // Nom temporaire du fichier
            $time = time(); // Récupérer le timestamp actuel
            // Créer un nouveau nom pour l'image
            $nouveau_nom_img = $time . $img_nom;

            // Déplacer l'image dans le dossier "images-menus"
            $dossier = 'images-menu/';
            $chemin_image = $dossier . $nouveau_nom_img;
            // Déplacer le fichier vers le dossier "images-menus"
            $deplacer_image = move_uploaded_file($tmp_nom, "images-menu/" . $nouveau_nom_ing);


            if (move_uploaded_file($tmp_nom, $chemin_image)) {
                // Connexion à la base de données via PDO
                try {
                    $pdo = new PDO('mysql:host=localhost;dbname=gestionnaire_de_menu', 'root', '');
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Mettre à jour le chemin de l'image dans la base de données
                    $updateImageStmt = $pdo->prepare("UPDATE plat SET image = :image WHERE id = :id");
                    $updateImageStmt->bindParam(':image', $chemin_image);
                    $updateImageStmt->bindParam(':id', $id);
                    $updateImageStmt->execute();
                    echo "L'image a été téléchargée et ajoutée à la base de données.";
                } catch (PDOException $e) {
                    echo 'Erreur de connexion ou de requête : ' . $e->getMessage();
                }
            } else {
                echo "L'image n'a pas pu être téléchargée.";
            }
        }
    } else {
        $message = '<p style="color:#ff800">Veuillez remplir tous les champs</p>';
    }

}

$pdo = null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Gestionnaire_de_menu</title>

</head>

<body>

    <header>
        <h1>Bienvenue sur le gestionnaire de menus!</h1>

    </header>
    <div class="container">
        <a href="menuS.php" class="Btn_add"> <img src="../images/ajouter.jpg"> Ajouter un menu</a>
        <a href="ajouter_plat.php" class="Btn_add"> <img src="../images/ajouter.jpg"> Ajouter un plat</a>
        <?php
        // Affichage du message (succès ou erreur)
        if (isset($message)) {
            echo $message;
        }
        ?>

        <table>
            <tr id="items">
                <th>id</th>
                <th>description</th>
                <th>prix</th>
                <th>image</th>
                <th>catégorie</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>

            <?php

            $pdo = new PDO('mysql:host=localhost;dbname=gestionnaire_de_menu', 'root', '');
            //requête pour afficher la liste de menus
            $stmt = $pdo->prepare("SELECT * FROM plat");
            $stmt->execute();
            $stmt->fetch(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() == 0) {
                echo "Il n'y a pas encore de plat ajouté !";
            } else {
                // Si des  existent, afficher leur liste
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td><?= htmlspecialchars($row['prix']) ?></td>
                        <td><img src="../images/<?= htmlspecialchars($row['image']) ?>" alt="Image du menu" width="50"></td>
                        <td><?= htmlspecialchars($row['catégorie']) ?></td>
                        <td><a href="modifier_plat.php?id=<?= htmlspecialchars($row['id']) ?>"><img src="../images/pen.jpg"
                                    alt="modifier"></a></td>
                        <td><a href="supprimer_plat.php?id=<?= htmlspecialchars($row['id']) ?>"><img src="../images/track.jpg"
                                    alt="supprimer"></a></td>
                    </tr>
                    <?php
                }
            }
            ?>

        </table>
    </div>
</body>

</html>