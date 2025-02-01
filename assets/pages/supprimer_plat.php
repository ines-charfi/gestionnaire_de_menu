<?php
// Connexion à la base de données 
$host = 'localhost'; // Hôte de la base de données
$dbname = 'gestionnaire_de_menu'; // Nom de votre base de données
$username = 'root'; // Votre nom d'utilisateur
$password = ''; // Votre mot de passe

try {
    // Créer la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Activer la gestion des erreurs PDO
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}

// Récupération de l'ID dans l'URL
$id = $_GET['id'];

try {
    // Préparer la requête de suppression avec PDO
    $stmt = $pdo->prepare("DELETE FROM plat WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Lier l'ID au paramètre :id
    $stmt->execute(); // Exécuter la requête de suppression
    if ($stmt->execute()) {
        // Si la suppression a réussi, redirection vers la page index.php
        header("Location: plats.php");
        exit(); // Toujours utiliser exit() après une redirection
    } else {
        // Si la suppression a échoué
        echo "Erreur lors de la suppression du plat.";
    }
} catch (PDOException $e) {
    // Gestion des erreurs
    echo "Erreur : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de suppression</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form">
        <h2>Confirmation de suppression</h2>
        <p>Êtes-vous sûr de vouloir supprimer ce plat ?</p>
        
        <!-- Vérification de l'ID avant de l'afficher avec htmlspecialchars() -->
        <?php if ($id !== null): ?>
            <form action="delete_plat.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                <input type="submit" name="confirm" value="Oui, supprimer" class="btn-confirm">
            </form>
        <?php else: ?>
            <p>Identifiant du menu manquant.</p>
        <?php endif; ?>
        
        <a href="plats.php" class="btn-liste-menu">Non, annuler</a>
    </div>
</body>
</html>