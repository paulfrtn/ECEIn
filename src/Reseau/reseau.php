<?php
include '../Session/session.php';
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reseau de connaissance</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="res_styles.css">
    <script type="text/javascript" src="res_script.js"></script>

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
                        <li class="nav-item"><a class="nav-link" href="reseau.php">Réseau</a></li>
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
            <div class="relat_contain">
                <div class="upper_contain">
                    <div class="up_cont_up">
                        <h3>Vos relations</h3>
                    </div>
                    <div class="up_cont_down">
                        <div class="up_cont_d_left">
                            <div class="card" id="menu">
                                <div class="menu_user">
                                    <?php

                                    $user = "SELECT DISTINCT * FROM utilisateur where id_utilisateur = $user_id ";

                                    $f_result = mysqli_query($db_handle, $user);

                                    $row = mysqli_fetch_assoc($f_result);
                                    echo '  <div class="pic_par">
                                <style>
                                .pic_par{
                                    background-image: url("../../images/' . $row['utilisateur_profile_picture'] . '");
                                    background-size: cover;
                                    background-position: center;
                                    background-repeat: no-repeat;
                                }
                                </style></div>
                                        <div class="desc_par">' . $row['utilisateur_lastname'] . '<br>' . $row['utilisateur_firstname'] . '</div> ';

                                    ?>

                                </div>
                                <div class="menu_up">
                                    <a href="reseau.php">
                                        <?php

                                        $ami = "SELECT DISTINCT * FROM ami where ((id_utilisateur = $user_id or id_utilisateur_ami= $user_id) and ami_accept=1)";

                                        $f_result = mysqli_query($db_handle, $ami);

                                        $row = mysqli_fetch_assoc($f_result);
                                        $nb_ami = mysqli_num_rows($f_result);
                                        echo 'Relations : ' . $nb_ami;


                                        ?>
                                    </a>

                                </div>
                                <div class="menu_center">
                                    <a href="request_page.php">
                                        <?php
                                        $request = "SELECT * from ami where id_utilisateur_ami=$user_id and ami_accept=2";
                                        $f_result = mysqli_query($db_handle, $request);
                                        $row = mysqli_fetch_assoc($f_result);
                                        $nb_request = mysqli_num_rows($f_result);
                                        echo 'Demandes : ' . $nb_request;
                                        ?>
                                    </a>

                                </div>
                                
                            </div>
                        </div>
                        <div class="up_cont_d_right">
                        
                            <?php
                            $ami = "SELECT DISTINCT utilisateur.* FROM utilisateur
                        INNER JOIN ami
                        ON utilisateur.id_utilisateur = ami.id_utilisateur_ami OR utilisateur.id_utilisateur = ami.id_utilisateur
                        WHERE (ami.id_utilisateur = $user_id OR ami.id_utilisateur_ami = $user_id) AND ami.ami_accept = 1
                        AND utilisateur.id_utilisateur <> $user_id
                        ";

                            $f_result = mysqli_query($db_handle, $ami);

                            while ($row = mysqli_fetch_assoc($f_result)) {
                                echo '
        <div class="card" id="' . $row['id_utilisateur'] . '">
            <div class="prof_pic">
                <div class="pic id-' . $row['id_utilisateur'] . '"></div>
            </div>
            <div class="prof_txt">
                <div class="prof_name">
                    ' . $row['utilisateur_lastname'] . '<br>' . $row['utilisateur_firstname'] . '
                </div>
                <div class="prof_desc">
                    <br>
                </div>
            </div>
        </div>';

                                echo '<style>
        .card .pic.id-' . $row['id_utilisateur'] . '{
            background-image: url("../../images/' . $row['utilisateur_profile_picture'] . '");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin-left: 1vh;
            margin-right: 1vh;
        }
    </style>';
                            }
                            
                            ?>
                            
                        </div>
                    </div>
                </div>
                <div class="lower_contain">
                    <div class="low_cont_up">
                        <h3>Personnes que vous pouvez connaitre</h3>
                    </div>
                    <div class="low_cont_down">
                        <?php
                        $sql = "
                        SELECT DISTINCT U3.*
FROM utilisateur AS U1
JOIN ami AS A1 ON (A1.id_utilisateur = U1.id_utilisateur OR A1.id_utilisateur_ami = U1.id_utilisateur)
JOIN ami AS A2 ON (A2.id_utilisateur = A1.id_utilisateur_ami OR A2.id_utilisateur_ami = A1.id_utilisateur_ami)
JOIN utilisateur AS U3 ON (U3.id_utilisateur = A2.id_utilisateur OR U3.id_utilisateur = A2.id_utilisateur_ami)
WHERE U1.id_utilisateur = $user_id
    AND U3.id_utilisateur <> $user_id
    AND A1.ami_accept = 1
    AND A2.ami_accept = 1
    AND NOT EXISTS (
        SELECT 1
        FROM ami AS A3
        WHERE (A3.id_utilisateur = U1.id_utilisateur OR A3.id_utilisateur_ami = U1.id_utilisateur)
            AND (A3.id_utilisateur = U3.id_utilisateur OR A3.id_utilisateur_ami = U3.id_utilisateur)
            AND A3.ami_accept = 1
    )
    AND A1.ami_accept <> 2;

    
    
    ";

                        $f_result2 = mysqli_query($db_handle, $sql);

                        while ($row = mysqli_fetch_assoc($f_result2)) {
                            echo '
                            <div class="card" id="' . $row['id_utilisateur'] . '">
                                <div class="prof_pic">
                                    <div class="pic id-' . $row['id_utilisateur'] . '"></div>
                                </div>
                                <div class="prof_txt">
                                    <div class="prof_name">
                                        ' . $row['utilisateur_lastname'] . '<br>' . $row['utilisateur_firstname'] . '
                                    </div>
                                    <div class="prof_desc">
                                        <br>
                                    </div>
                                </div>
                            </div>';

                            echo '<style>
                            .card .pic.id-' . $row['id_utilisateur'] . '{
                                background-image: url("../../images/' . $row['utilisateur_profile_picture'] . '");
                                background-size: cover;
                                background-position: center;
                                background-repeat: no-repeat;
                                margin-left: 1vh;
                                margin-right: 1vh;
                            }
                        </style>';
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
        <?php
    } ?>
    
</body>

</html>