<?php
$servername = "localhost";
$username = "root";
$password = "";
try {
    $bdd = new PDO("mysql:host=$servername;dbname=gestionnaire_de_menu", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connexion reussi !";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
if (isset($_POST['ok'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $requete = $bdd->prepare("INSERT INTO user VALUES (0, :email, :password)");
    $requete->execute(
        array(

            'email' => $email,
            'password' => $password,

        )
    );

    echo "Inscription réussie!";
    header("Location: http://localhost/gestionmaire_de_menu/assets/pages/login.php");
    exit();
}
?>