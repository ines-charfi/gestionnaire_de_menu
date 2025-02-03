<?php
 $dbname = "ines-charfi_gestionnaire_de_menu";
 $host = "localhost:3306";
 $username = "ines-charfi";
 $password = "ines2610.";

if (isset($_POST['btn_ajouter'])) {
    try {
        // Connexion à la base de données avec PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

    // Récupération des données du formulaire
    $id = $_POST['id'];
    $description = $_POST['description'];
    $poids = $_POST['poids'];
  

    // Vérification que les champs ne sont pas vides
    if (!empty($id) && !empty($description) && !empty($poids) ) {
        // Préparer la requête SQL pour vérifier si le produit existe déjà
        $stmt = $pdo->prepare("SELECT * FROM ingredients WHERE id = :id AND description  = :description AND poids = :poids ");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':poids', $poids);
      
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
            $insertStmt = $pdo->prepare("INSERT INTO ingredients (id, description , poids) VALUES (:id, :description,:poids)");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':prix', $poids);
            
            $insertStmt->execute();

            $message = '<p style="color:green">Produit ajouté avec succès</p>';
        }
       
                // Connexion à la base de données via PDO
                $dbname = "ines-charfi_gestionnaire_de_menu";
                $host = "localhost:3306";
                $username = "ines-charfi";
                $password = "ines2610.";
                try {
                    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                
                   
                } catch (PDOException $e) {
                    echo 'Erreur de connexion ou de requête : ' . $e->getMessage();
                }
            } 
        }
    else {
        $message = '<p style="color:#ff800">Veuillez remplir tous les champs</p>';
    }

    // Fermer la connexion

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
    <a href="index.php" class="back_btn"><img src="./assets/images/back.jpg"> Retour</a>
        <h1>liste des ingredients</h1>

    </header>
    <div class="container">
        <a href="ajouter_ingredient.php" class="Btn_add"> <img src="./assets/images/ajouter.jpg"> Ajouter un ingredient</a>
        <a href="ajouter_plat.php" class="Btn_add"> <img src="./assets/images/ajouter.jpg"> Ajouter un plat</a>
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
                <th>poids</th>
               
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>

            <?php
             $dbname = "ines-charfi_gestionnaire_de_menu";
             $host = "localhost:3306";
             $username = "ines-charfi";
             $password = "ines2610.";

            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            //requête pour afficher la liste de menus
            $stmt = $pdo->prepare("SELECT * FROM ingredients");
            $stmt->execute();
            $stmt->fetch(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() == 0) {
                echo "Il n'y a pas encore d'ingredient ajouté !";
            } else {
                // Si des  existent, afficher leur liste
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td><?= htmlspecialchars($row['poids']) ?></td>
            
                        <td><a href="modifier_plat.php?id=<?= htmlspecialchars($row['id']) ?>"><img src="./assets/images/pen.jpg"
                                    alt="modifier"></a></td>
                        <td><a href="supprimer_plat.php?id=<?= htmlspecialchars($row['id']) ?>"><img src="./assets/images/track.jpg"
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