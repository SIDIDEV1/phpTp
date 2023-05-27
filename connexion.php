<?php
require('config.php');

if (isset($_POST['pseudo'], $_POST['pass'])) {
    $pseudo = $_POST['pseudo'];
    $pass = $_POST['pass'];

    $pass_hache = sha1($pass);

    $req = $bdd->prepare('SELECT id FROM membres WHERE pseudo = :pseudo AND pass = :pass');
    $req->execute(array(
        'pseudo' => $pseudo,
        'pass' => $pass_hache
    ));
    $resultat = $req->fetch();

    if (!$resultat) {
        echo 'Mauvais identifiant ou mot de passe ! <br>';
        echo '<a href="index.php">Retour</a>';
    } else {
        session_start();
        $_SESSION['id'] = $resultat['id'];
        $_SESSION['pseudo'] = $pseudo;
        echo 'Vous êtes connecté ! <br>';
        echo '<a href="index.php">Retour à l\'accueil</a>';
    }
} else {
?>
    <form action="" method="post">
        Pseudo: <input type="text" name="pseudo"><br>
        Mot de passe: <input type="password" name="pass"><br>
        <input type="submit" value="Se connecter">
    </form>
<?php
}
?>