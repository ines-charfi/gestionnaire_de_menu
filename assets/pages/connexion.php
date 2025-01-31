<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/pages/style.css">
    <title>Inscription</title>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="connexion.php">Registration</a></li>
            <li><a href="login.php">Login</a></li>
            
        </ul>
    </nav>
    <h1>Registration</h1>
</header>
<?php 
$servername = "localhost";
$username = "root";
$password = "";

try {
    $bdd = new PDO("mysql:host=$servername;dbname=gestionnaire_de_menu", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e){
    echo "Erreur : ".$e->getMessage();
}
?>

<form method="POST" action="traitement.php">
    <label for="email">Votre email</label>
    <input type="text" id="email" name="email" placeholder="Entrez votre email" required>
    <label for="password">Votre mot de passe</label>
    <input type="password" id="password" name="password" placeholder="Entrez votre password">
    <input type="submit" value="S'inscrire" name="ok">
</form>
</body>
</html>