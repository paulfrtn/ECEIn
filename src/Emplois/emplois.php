<?php
include '../Session/session.php';
$user_id = $_SESSION['user_id'];
?>


<!DOCTYPE html>
<html>

<head>
    <title>Offres d'emploi</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="em_styles.css">
    <script type="text/javascript" src="em_script.js"></script>

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
    <?php
    if (!isset($_SESSION['name'])) {
        loginForm();
    } else {
        ?>
        <nav class="navbar navbar-expand-md">
            <a class="navbar-brand" href="#"> <a href="../Accueil/accueil.php"><img src="../../images/logos/logo.png"
                        alt="logo" width="120"> </a>
                <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse"
                    data-target="#main-navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="main-navigation">
                    <ul class="navbar-nav">
                        <?php
                        echo $_SESSION['name'];
                        echo $_SESSION['role'];
                        echo $_SESSION['user_id'];
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
                                <?php
                                if ($_SESSION['role'] == "admin") {
                                    echo '<a href="../Administration/administration.php" class="dropdown-item">Ajouter un utilisateur</a>';
                                }
                                ?>
                                <a class="dropdown-item" href="#" id="exit">Déconnexion</a>

                            </div>
                        </li>
                        <div class="switch">
                            <div class="darkBtn">
                                <input id="dark_Btn" type="checkbox" onclick="toggleDarkMode()">
                                <label for="dark_Btn"></label>
                            </div>
                        </div>
                    </ul>
                </div>
        </nav>

        <div class="mon_container">
            
            <div class="feed">
                <div class="feed_upper_part">
                    <h1>Offres d'emplois</h1>
                </div>
                <div class="feed_lower_part">

                    <?php
                    $offer = "SELECT o.*, u.utilisateur_firstname, u.utilisateur_lastname 
                    FROM offer o 
                    JOIN utilisateur u ON o.id_utilisateur = u.id_utilisateur
                    WHERE NOT EXISTS (
                        SELECT 1 
                        FROM enregistrer e 
                        WHERE e.offer_id = o.offer_id 
                          AND e.id_utilisateur = $user_id
                    )";
                    $result = mysqli_query($db_handle, $offer);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '
        <div class="offer_card" id="' . $row['id_utilisateur'] . '">
            <div class="offer_content"> 
                    <div class ="offer_user"> <div class = "of_name"><h4> Offre de :' . $row['utilisateur_lastname'] . '  ' . $row['utilisateur_firstname'] . '</h4> -  Publiée le ' . $row['offer_date'] . '</div><div class="offer_fav_icon">
                <div class="fav_nicone" id="' .$row['offer_id'].' ">
                    <style>
                        .offer_fav_icon .fav_nicone{
                            background-image: url("../../images/icones/fav_icon_none.png");
                            background-size: cover;
                            background-repeat: no-repeat;
                            background-position: center;
                        }
                    </style>
                </div>
            </div></div>
                    <div class = "of_type_dom_loc"> <p>Type :' . $row['offer_type'] . '</p> <p>  Domaine :' . $row['offer_domain'] . '</p> <p>  Lieu : ' . $row['offer_location'] . '</p>  </div>
                    Description : <br>
                    <div class = "of_desc"> ' . $row['offer_content'] . '</div>
            </div>
            
        </div>
    ';
                    }
                    ?>




                </div>

            </div>
            <div class="fav">
                <div class="fav_upper_part">
                    <h1>Favoris</h1>
                </div>
                <div class="fav_lower_part">
                    <?php
                    $offer = "SELECT o.*, u.utilisateur_firstname, u.utilisateur_lastname 
                    FROM offer o 
                    JOIN utilisateur u  ON o.id_utilisateur = u.id_utilisateur
                    JOIN enregistrer e ON (e.offer_id = o.offer_id and e.id_utilisateur = $user_id)
                    WHERE save_state = 1
                    "                    ;
                    $result = mysqli_query($db_handle, $offer);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '
        <div class="fav_card" id="' . $row['id_utilisateur'] . ' ">
            <div class="fav_content"> 
                <div class ="fav_user"> <div class="fv_name"> <h4> Offre de :' . $row['utilisateur_lastname'] . '  ' . $row['utilisateur_firstname'] . '</h4>   Publiée le ' . $row['offer_date'] . '</div>
                    <div class="fav_fav_icon">
                        <div class="fav_yicone" id="' .$row['offer_id'].' ">
                        <style>
                            .fav_fav_icon .fav_yicone{
                                background-image: url("../../images/icones/fav_icon_yes.png");
                                background-size: cover;
                                background-repeat: no-repeat;
                                background-position: center;
                            }
                        </style>
                        </div>
                    </div>
                </div>
                    <div class = "fv_type_dom_loc"> <p>Type :' . $row['offer_type'] . '</p> <p>  Domaine :' . $row['offer_domain'] . '</p> <p>  Lieu : ' . $row['offer_location'] . '</p>  </div>
                    Description : <br>
                    <div class = "fv_desc"> ' . $row['offer_content'] . '</div>
            </div>
            
        </div>
    ';
                    }
                    ?>




                </div>
            </div>
        </div>
    <?php } ?>
</body>

</html>