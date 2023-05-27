<?php
require('config.php');

if (isset($_POST['pseudo'], $_POST['pass'], $_POST['email'])) {
    $pseudo = $_POST['pseudo'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];

    // vérifier si le pseudonyme existe déjà
    $req = $bdd->prepare('SELECT id FROM membres WHERE pseudo = :pseudo');
    $req->execute(array('pseudo' => $pseudo));
    if ($req->fetch()) {
        echo 'Ce pseudonyme est déjà utilisé, veuillez en choisir un autre  <a href="inscription.php">Retour</a>.';
    } else {
        $pass_hache = sha1($pass);

        $req = $bdd->prepare('INSERT INTO membres(pseudo, pass, email, date_inscription) VALUES(:pseudo, :pass, :email, CURDATE())');
        $req->execute(array(
            'pseudo' => $pseudo,
            'pass' => $pass_hache,
            'email' => $email
        ));
        echo 'Inscription réussie, veuillez vous <a href="connexion.php">connecter</a>.';
    }
} else {
?>
    <form action="" method="post">
        Pseudo: <input type="text" name="pseudo"><br>
        Mot de passe: <input type="password" name="pass"><br>
        Email: <input type="text" name="email"><br>
        <input type="submit" value="S'inscrire">
    </form>
<?php
}
?>