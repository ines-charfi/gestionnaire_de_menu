<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
    $bdd = new PDO("mysql:host=$servername;dbname=gestionnaire_de_menu", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    if ($email != "" && $password != "") {
        $req = $bdd->prepare("SELECT * FROM user WHERE email = :email AND password = :password");
        $req->execute(['email' => $email, 'password' => $password]);
        $rep = $req->fetch();
        if ($rep && $rep["password"] != false) {
            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <title>Se connecter</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Registration</a></li>
                <li><a href="login.php">Login</a></li>

            </ul>
        </nav>
        <h1>Login</h1>
    </header>
    <form method="POST" action="menus.php">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Entrez votre email..." required>
        <label for="password">Mot de passe</label>
        <input type="password" placeholder="Entrez votre password" id="password" name="password" required>
        <input type="submit" value="Se connecter" name="ok">
    </form>
</body>

</html>