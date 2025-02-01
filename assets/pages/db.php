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

// Vérifier l'action demandée
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // Ajouter un produit
    if ($action == "ajouter" && $_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['nom']) && !empty($_POST['description']) && !empty($_POST['prix']) && !empty($_POST['catégorie'])) {
            $nom = $_POST['nom'];
            $description = $_POST['description'];
            $prix = $_POST['prix'];
            $categorie = $_POST['catégorie'];

            $stmt = $pdo->prepare("INSERT INTO plat (nom, description, prix, catégorie) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$nom, $description, $prix, $catégorie])) {
                $_SESSION['message'] = "Produit ajouté avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de l'ajout.";
            }
        } else {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
        }
        header("Location: menus.php");
        exit;
    }

    // Modifier un produit
    if ($action == "modifier" && $_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['id']) && !empty($_POST['nom']) && !empty($_POST['description']) && !empty($_POST['prix']) && !empty($_POST['catégorie'])) {
            $id = $_POST['id'];
            $nom = $_POST['nom'];
            $description = $_POST['description'];
            $prix = $_POST['prix'];
            $catégorie = $_POST['categorie'];

            $stmt = $pdo->prepare("UPDATE plat SET nom = ?, description = ?, prix = ?, catégorie = ? WHERE id = ?");
            if ($stmt->execute([$nom, $description, $prix, $catégorie, $id])) {
                $_SESSION['message'] = "Produit modifié avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la modification.";
            }
        } else {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
        }
        header("Location: menus.php");
        exit;
    }

    // Supprimer un produit
    if ($action == "supprimer" && isset($_GET['id'])) {
        $id = $_GET['id'];

        $stmt = $pdo->prepare("DELETE FROM plat WHERE id = ?");
        if ($stmt->execute([$id])) {
            $_SESSION['message'] = "Produit supprimé avec succès.";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression.";
        }
        header("Location: menus.php");
        exit;
    }
}
?>
