<?php
session_start();
if (isset($_SESSION['pseudo'])) {
    echo 'Bonjour ' . $_SESSION['pseudo'];
    echo '<a href="deconnexion.php">Déconnexion</a>';
} else {
    echo '<a href="inscription.php">Inscription</a>';
    echo '<a href="connexion.php">Connexion</a>';
}
