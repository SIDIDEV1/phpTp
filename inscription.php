<?php
require('config.php');

if (isset($_POST['pseudo'], $_POST['pass'], $_POST['email'], $_POST['date_naissance'], $_POST['ville'], $_POST['travail'], $_POST['passions'])) {
    $pseudo = $_POST['pseudo'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    $date_naissance = $_POST['date_naissance'];
    $ville = $_POST['ville'];
    $travail = $_POST['travail'];
    $passions = $_POST['passions'];

    $req = $bdd->prepare('SELECT id FROM membres WHERE pseudo = :pseudo');
    $req->execute(array('pseudo' => $pseudo));
    $resultat = $req->fetch();
    if ($resultat) {
        echo 'Ce pseudo est déjà utilisé !';
        exit();
    }

    $req = $bdd->prepare('SELECT id FROM membres WHERE email = :email');
    $req->execute(array('email' => $email));
    $resultat = $req->fetch();
    if ($resultat) {
        echo 'Cet e-mail est déjà utilisé !';
        exit();
    }

    $pass_hache = sha1($pass);

    $req = $bdd->prepare('INSERT INTO membres(pseudo, pass, email, date_naissance, ville, travail, passions, date_inscription) VALUES(:pseudo, :pass, :email, :date_naissance, :ville, :travail, :passions, CURDATE())');
    $req->execute(array(
        'pseudo' => $pseudo,
        'pass' => $pass_hache,
        'email' => $email,
        'date_naissance' => $date_naissance,
        'ville' => $ville,
        'travail' => $travail,
        'passions' => $passions
    ));

    $last_id = $bdd->lastInsertId();

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $infosfichier = pathinfo($_FILES['avatar']['name']);
        $extension_upload = $infosfichier['extension'];
        $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
        if (in_array($extension_upload, $extensions_autorisees)) {
            move_uploaded_file($_FILES['avatar']['tmp_name'], 'avatars/' . $last_id . '.' . $extension_upload);

            $req = $bdd->prepare('UPDATE membres SET avatar = :avatar WHERE id = :id');
            $req->execute(array(
                'avatar' => 'avatars/' . $last_id . '.' . $extension_upload,
                'id' => $last_id
            ));
            echo 'Inscription réussie, veuillez vous <a href="connexion.php">connecter</a>.';
        } else {
            echo 'Erreur: Le type de fichier est invalide. Seules les images jpg, jpeg, gif et png sont autorisées.';
        }
    } else {
        echo 'Erreur: Vous devez choisir une image pour votre avatar.';
    }
} else {
?>
    <form action="" method="post" enctype="multipart/form-data">
        Pseudo: <input type="text" name="pseudo"><br>
        Mot de passe: <input type="password" name="pass"><br>
        Email: <input type="text" name="email"><br>
        Date de naissance: <input type="date" name="date_naissance"><br>
        Ville: <input type="text" name="ville"><br>
        Travail: <input type="text" name="travail"><br>
        Passions: <input type="text" name="passions"><br>
        Avatar: <input type="file" name="avatar"><br>
        <input type="submit" value="S'inscrire">
    </form>
<?php
}
?>