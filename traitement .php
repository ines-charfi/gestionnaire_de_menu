<?php
 $dbname = "ines-charfi_gestionnaire_de_menu";
 $host = "3306";
 $username = "ines-charfi";
 $password = "ines2610.";
try {
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
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
    header("Location:login.php");
    exit();
}
?>