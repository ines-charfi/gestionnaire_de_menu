<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <div class="menu">
            <div class="menu-content">
                <a href="menus.php">Ajouter un menu</a>
                <h3>liste des menus</h3>
                <div class="liste-menus">
                    <?php
                 
                   //connexion à la base de données avec PDO
                   try {
                       $menus = new PDO("mysql:host=localhost;dbname=gestionnaire_de_menu", "root", "");
                       // Définir le mode d'erreur de PDO pour lancer des exceptions
                       $menus->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                   
                       // Requête pour sélectionner tous les menus et leurs plats associés
                        $menus= $menus->prepare("SELECT * FROM menu ");
                        $menus->execute();
                       // Vérifier si la base de données contient des menus et plats
                       if ($menus->rowCount() == 0) {
                           // Si aucun menu trouvé
                           echo "Aucun menu trouvé";
                       } else {
                           // Sinon, afficher les informations des menus
                           while ($row = $menus->fetch(PDO::FETCH_ASSOC)) {
                               // Affichage des informations de chaque menu
                            echo '
                          
                                <div class="image-menu">
                                    <img src="../images/' . $row['image'] . '" alt="Image du menu">
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