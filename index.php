<?php
require('config.php');
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            background-color: <?php echo $_SESSION['theme'] == 'dark' ? '#333' : '#FFF'; ?>;
            color: <?php echo $_SESSION['theme'] == 'dark' ? '#FFF' : '#333'; ?>;
        }

        img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <?php

    if (isset($_SESSION['pseudo'])) {
        $req = $bdd->prepare('SELECT avatar FROM membres WHERE pseudo = :pseudo');
        $req->execute(array(
            'pseudo' => $_SESSION['pseudo']
        ));
        $resultat = $req->fetch();
        $avatar_path = $resultat['avatar'];

        echo 'Bonjour ' . $_SESSION['pseudo'] . '<br>';
        echo '<img src="' . $avatar_path . '" alt="Avatar"><br>';
        echo '<a href="profil.php">Mon profil</a><br>';
        echo '<a href="changer_identifiants.php">Changer information</a><br>';
        echo '<a href="deconnexion.php">Déconnexion</a>';
    } else {
        echo '<a href="inscription.php">Inscription</a><br>';
        echo '<a href="connexion.php">Connexion</a>';
    }
    ?>
</body>

</html>