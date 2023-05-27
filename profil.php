<?php
require('config.php');
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            background-color: <?php echo isset($_SESSION['theme']) && $_SESSION['theme'] == 'dark' ? '#333' : '#FFF'; ?>;
            color: <?php echo isset($_SESSION['theme']) && $_SESSION['theme'] == 'dark' ? '#FFF' : '#333'; ?>;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_SESSION['id'])) {
        $req = $bdd->prepare('SELECT * FROM membres WHERE id = :id');
        $req->execute(array('id' => $_SESSION['id']));
        $membre = $req->fetch();
    ?>

        <h1>Profil de <?php echo htmlspecialchars($membre['pseudo']); ?></h1>
        <p>Email: <?php echo htmlspecialchars($membre['email']); ?></p>
        <p>Ville: <?php echo htmlspecialchars($membre['ville']); ?></p>
        <p>Travail: <?php echo htmlspecialchars($membre['travail']); ?></p>
        <p>Passions: <?php echo htmlspecialchars($membre['passions']); ?></p>
        <p>Date de naissance: <?php echo htmlspecialchars($membre['date_naissance']); ?></p>
        <p><?php
            echo '<a href="index.php">Retour</a>';
            ?></p>

    <?php
    } else {
        echo 'Vous devez être connecté pour accéder à votre profil.';
    }
    ?>

    <?php
    if (isset($_SESSION['id'])) {
        if (isset($_POST['theme'])) {
            $theme = $_POST['theme'];

            $req = $bdd->prepare('UPDATE membres SET theme = :theme WHERE id = :id');
            $req->execute(array(
                'theme' => $theme,
                'id' => $_SESSION['id']
            ));
            $_SESSION['theme'] = $theme;
            echo 'Votre thème a été modifié avec succès !';
        } else {
            $req = $bdd->prepare('SELECT theme FROM membres WHERE id = :id');
            $req->execute(array(
                'id' => $_SESSION['id']
            ));
            $resultat = $req->fetch();
            $_SESSION['theme'] = $resultat['theme'];
    ?>
            <form action="" method="post">
                Choisir un thème:
                <select name="theme">
                    <option value="light">Light</option>
                    <option value="dark">Dark</option>
                </select>
                <br>
                <input type="submit" value="Modifier">
            </form>
    <?php
        }
    } else {
        echo 'Vous devez être connecté pour accéder à cette page.';
    }
    ?>
</body>

</html>