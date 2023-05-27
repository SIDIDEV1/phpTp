<?php
require('config.php');
session_start();

if (isset($_SESSION['id'])) {
    if (isset($_POST['pseudo'], $_POST['pass'], $_POST['new_pass'])) {
        $pseudo = $_POST['pseudo'];
        $pass = $_POST['pass'];
        $new_pass = $_POST['new_pass'];

        $pass_hache = sha1($pass);
        $new_pass_hache = sha1($new_pass);

        $req = $bdd->prepare('SELECT id FROM membres WHERE id = :id AND pseudo = :pseudo AND pass = :pass');
        $req->execute(array(
            'id' => $_SESSION['id'],
            'pseudo' => $_SESSION['pseudo'],
            'pass' => $pass_hache
        ));
        $resultat = $req->fetch();

        if (!$resultat) {
            echo 'Mauvais identifiant ou mot de passe !';
        } else {
            $req = $bdd->prepare('SELECT id FROM membres WHERE pseudo = :pseudo');
            $req->execute(array('pseudo' => $pseudo));
            $resultat = $req->fetch();

            if ($resultat) {
                echo 'Ce pseudo est déjà utilisé !';
            } else {
                $req = $bdd->prepare('UPDATE membres SET pseudo = :pseudo, pass = :pass WHERE id = :id');
                $req->execute(array(
                    'pseudo' => $pseudo,
                    'pass' => $new_pass_hache,
                    'id' => $_SESSION['id']
                ));
                $_SESSION['pseudo'] = $pseudo;
                echo 'Vos identifiants ont été modifiés avec succès !';
            }
        }
    } else {
?>
        <form action="" method="post">
            Nouveau Pseudo: <input type="text" name="pseudo"><br>
            Ancien mot de passe: <input type="password" name="pass"><br>
            Nouveau mot de passe: <input type="password" name="new_pass"><br>
            <input type="submit" value="Modifier">
        </form>

        <p><?php
            echo '<a href="index.php">Retour</a>';
            ?></p>
<?php
    }
} else {
    echo 'Vous devez être connecté pour accéder à cette page.';
}
?>