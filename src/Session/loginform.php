<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Formulaire de Connexion LinkECEIn</title>
    <link rel="stylesheet" href="../Session/loginform.css">

</head>

<body>

    <div class="card">
        <h2>Connexion</h2>

        <form action="../Accueil/accueil.php" method="post">
            <div class="user-box">
                <div id="error-message">
                    <?php
                    if (isset($_SESSION['error_message'])) {
                        echo htmlspecialchars($_SESSION['error_message']);
                        unset($_SESSION['error_message']);
                    }
                    ?>
                </div>
                <input type="text" name="name" id="name" required="">
                <label for="name">Pseudo</label>
            </div>

            <div class="user-box">
                <input type="password" name="password" id="password" required="">
                <label>Mot de passe</label>
            </div>

            <div class="user-box">
                <div class="frame">
                    <button type="submit" name="enter" id="enter" class="custom-btn submit">Se connecter</button>
                </div>
            </div>
        </form>
    </div>

</body>

</html>