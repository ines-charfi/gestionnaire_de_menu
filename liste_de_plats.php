<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>liste des plats</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <div class="menu">
            <div class="menu-content">
                <a href="ajouter_plat.php" class="Btn_add"> <img src="./assets/images/ajouter.jpg"> Ajouter un plat</a>
                <a href="liste_des_catégories.php" class="Btn_add"> <img src="./assets/images/ajouter.jpg"> Ajouter une catégorie</a>
                <h3>liste des plats</h3>
                <div class="liste-menus">
                    <?php
                 
                   //connexion à la base de données avec PDO
                   try {
                       $menus = new PDO("mysql:host=localhost:3306;dbname=ines-charfi_gestionnaire_de_menu", "ines-charfi", "ines2610.");
                       // Définir le mode d'erreur de PDO pour lancer des exceptions
                       $menus->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                   
                       // Requête pour sélectionner tous les menus et leurs plats associés
                        $menus= $menus->prepare("SELECT * FROM plat ");
                        $menus->execute();
                       // Vérifier si la base de données contient des menus et plats
                       if ($menus->rowCount() == 0) {
                           // Si aucun plat trouvé
                           echo "Aucun plat trouvé";
                       } else {
                           // Sinon, afficher les informations des menus
                           while ($row = $menus->fetch(PDO::FETCH_ASSOC)) {
                               // Affichage des informations de chaque plat
                            echo '
                          
                                <div class="image-menu">
                                    <img src="./assets/images/' . $row['image'] . '" alt="Image du menu">
                                </div>
                                <div class="text">
                                    <strong><p class="titre">' . $row['description'] . '</p></strong>
                                    <p class="prix">' . $row['prix'] . ' €</p>
                                    <p class="catégorie">' . $row['catégorie'] . '</p>
                                </div>
                          
                            <hr>';
                        }
                    }
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                }               
                ?>
                </div>


</body>
</html>