<?php
include '../Session/session.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Page Administrateur</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="administration.css">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            <?php
            include '../Session/session.js';
            ?>
        });
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-md">
        <a class="navbar-brand" href="#"> <a href="accueil.php"><img src="images/logo.png" alt="logo" width="120"> </a>
            <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse"
                data-target="#main-navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main-navigation">
                <ul class="navbar-nav">
                    <?php
                    echo $_SESSION['name'];
                    echo $_SESSION['role'];
                    ?>
                    <li class="nav-item"><a class="nav-link" href="../Accueil/accueil.php">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Reseau/reseau.php">Réseau</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Emplois/emplois.php">Emplois</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Messagerie/chatter.php">Messagerie</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Notifications/notifications.php">Notifications</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Vous
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <?php
                            if ($_SESSION['role'] == "admin") {
                                echo '<p class="dropdown-item">Administrateur</p>';
                            }
                            ?>
                            <a class="dropdown-item" href="../Vous/vous.php">Mon Profil</a>
                            <a class="dropdown-item" href="#" id="exit">Déconnexion</a>
                        </div>
                    </li>
                </ul>
            </div>
    </nav>

    <div class="card">
        <h2>Ajouter un utilisateur</h2>
        <form id="formulaire" action="upload.php" method="post" enctype="multipart/form-data">
            <div class="user-box">
                <input type="text" name="prenom" id="prenom" required="">
                <label for="name">Prénom</label>
            </div>

            <div class="user-box">
                <input type="text" name="nom" id="nom" required="">
                <label for="name">NOM</label>
            </div>

            <div class="user-box">
                <input type="text" name="mail" id="mail" required="">
                <label for="name">adresse e-mail</label>
            </div>

            <div class="user-box">
                <input type="text" name="pseudo" id="pseudo" required="">
                <label for="name">Pseudo</label>
            </div>

            <div class="user-box">
                <input type="password" name="mdp" id="mdp" required="">
                <label for="name">Mot de passe</label>
            </div>
            <div class="user-box">
                <select name="role" id="role" required="">
                    <option value="">Rôle</option>
                    <option value="user">Utilisateur</option>
                    <option value="admin">Administrateur</option>
                </select>
            </div>
            <div id="fichier">
                <label for="profilePicture">Photo de profil : </label>
                <input type="file" id="profilePicture" name="profilePicture">
            </div>
            <div id="fichier">
                <label for="backgroundPicture">Bannière : </label>
                <input type="file" id="backgroundPicture" name="backgroundPicture">
            </div>

            <div class="user-box">
                <div id="dateNaissance">
                    <label for="birthdate">Date de naissance : </label>
                    <div id="vide">AAAAAAAAA.</div>
                    <input type="date" name="birthdate" id="birthdate" required="">
                </div>
            </div>

            <div class="user-box">
                <div class="frame">
                    <button type="submit" name="enter" id="enter" class="custom-btn submit">Créer l'utilisateur</button>
                </div>
            </div>
        </form>
    </div>

</body>

</html>