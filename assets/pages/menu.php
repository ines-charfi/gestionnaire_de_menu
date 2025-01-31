<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Connexion à la base de données
$host = 'localhost';
$dbname = 'gestionnaire_de_menu';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupérer les plats depuis la base de données
$stmt = $pdo->query("SELECT * FROM plat");
$plats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../pages/style.css">
    <title>Page Admin</title>
</head>
<body>

<header>
    <nav>
        <ul>
            <li><a href="connexion.php">Registration</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

    <h1>Bienvenue sur votre page admin !</h1>

    <div class="plat">
    <a href="#" class="Btn_add"> <img src="../images/icons8-plus-78.png"> Modifier un Menu</a>
    <a href="modifier.php" class="Btn-add"><img src="../images/icons8-plus-78.png" alt="Modifier">Modifier un Plat</a>
    
        <h2>Carte actuelle</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Catégorie</th>
                <th>Action</th>
            </tr>
            <?php foreach ($plats as $plat): ?>
            <tr>
                <td><?php echo htmlspecialchars($plat['id']); ?></a></td>
                <td><?php echo htmlspecialchars($plat['nom']); ?></td>
                <td><?php echo htmlspecialchars($plat['description']); ?></td>
                <td><?php echo htmlspecialchars($plat['prix']); ?>€</td>
                <td><?php echo htmlspecialchars($plat['categorie']); ?></td>
                <td>
                    <a href="modifier.php?id=<?php echo $plat['id']; ?>">Modifier</a>
                    <a href="db.php?action=supprimer&id=<?php echo $plat['id']; ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce plat ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

</body>
</html>