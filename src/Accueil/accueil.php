<?php
include '../Session/session.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Accueil LinkECEIn</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="Acc_styles.css">
    <script type="text/javascript" src="acc_script.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            <?php
            include '../Session/session.js';
            ?>

            $('.like').click(function () {
                var post_id = $(this).data('post-id');
                location.reload();
                $.ajax({
                    url: 'like.php',
                    method: 'POST',
                    data: {
                        post_id: post_id
                    }
                });
            });

            $('.comment').click(function () {
                var id_post = $(this).data('post-id');
                console.log(id_post);
                $.ajax({
                    url: 'comment.php',
                    method: 'POST',
                    data: {
                        id_post: id_post
                    }
                });
            });
        });
    </script>

</head>

<body>
    <?php
    if (!isset($_SESSION['name'])) {
        loginForm();
    } else if (!isset($_SESSION['role'])) {
        loginForm();
    } else if (!isset($_SESSION['user_id'])) {
        loginForm();
    } else {
        ?>
                <nav class="navbar navbar-expand-md">
                    <a class="navbar-brand" href="#"> <a href="accueil.php"><img src="../../images/logos/logo.png" alt="logo"
                                width="120"> </a>
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
                                <li class="nav-item"><a class="nav-link" href="accueil.php">Accueil</a></li>
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


                <div class="features">
                    <div class="column">
                    </div>
                    <div class="column1">
                        <div class="columnHead">
                            <h3 class="feature-title">Évènements de la semaine</h3>
                            <div class="container-fluid">
                                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner row w-100 mx-auto">

                                    <?php
                                    $query2 = "
                    SELECT DISTINCT utilisateur.*, post.*
FROM ami
LEFT JOIN utilisateur ON (
(ami.id_utilisateur = utilisateur.id_utilisateur AND ami.id_utilisateur_ami = $user_id)
OR
(ami.id_utilisateur_ami = utilisateur.id_utilisateur OR ami.id_utilisateur_ami = $user_id)
)
LEFT JOIN post ON post.id_utilisateur = utilisateur.id_utilisateur
WHERE (ami.ami_accept = 1 OR post.id_utilisateur = $user_id OR post.id_utilisateur = 1)
AND post.post0_event1 = 1
AND post.post_date >= CURDATE()
AND post.post_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)";






                                    $query3 = "SELECT * from utilisateur where id_utilisateur = $user_id";
                                    $result3 = mysqli_query($db_handle, $query3);
                                    $row3 = mysqli_fetch_assoc($result3);


                                    $result2 = mysqli_query($db_handle, $query2);

                                    $active = true;

                                    while ($row = mysqli_fetch_assoc($result2)) {
                                        echo '
      <div class="carousel-item col-md-15 ' . ($active ? 'active' : '') . '">
        <div class="card">
          <img class="card-img-top img-fluid" src="' . $row['post_image'] . '" alt="logo"">
          <div class="card-body">
            <h4 class="card-title">' . $row['post_content'] . '</h4>
            <p class="card-text">DATE ' . $row['post_date'] . '</p>
          </div>
        </div>
      </div>';

                                        $active = false;
                                    }
                                    ?>
                                    </div>


                                    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="feed">
                        <div class="feedHead">
                            <div class="post">
                                <div class="PostHead">
                                    <a href="../Vous/vous.php">
                                        <img src=" <?php echo $row3['utilisateur_profile_picture'] ?> " alt="logo" width="50">
                                    </a>

                                    <button>Commencer un post</button>
                                </div>

                                <div class="Objet">

                                    <button id="btn-evenement">Photo/Vidéo</button>

                                    <div id="formulaire-container" style="display: none;">
                                        <form action="traiter_formulaire2.php" method="post" enctype="multipart/form-data">


                                            <label for="media">Image ou vidéo :</label>
                                            <input type="file" id="media" name="media" accept="image/*,video/*"><br>

                                            <label for="texte">Texte :</label><br>
                                            <textarea id="texte" name="texte" rows="5" cols="40" required></textarea><br>

                                            <input type="submit" value="Publier la Photo!">
                                        </form>
                                    </div>

                                    <script>
                                        var formulaireVisible1 = false;

                                        document.getElementById("btn-evenement").addEventListener("click", function () {
                                            if (formulaireVisible1) {

                                                document.getElementById("formulaire-container").style.display = "none";
                                                formulaireVisible1 = false;
                                            } else {

                                                document.getElementById("formulaire-container").style.display = "block";
                                                formulaireVisible1 = true;
                                            }
                                        });
                                    </script>


                                    <button id="btn-evenement2">Evenement</button>

                                    <div id="formulaire-container1" style="display: none;">
                                        <form action="traiter_formulaire.php" method="post" enctype="multipart/form-data">
                                            <label for="titre1">Titre :</label>
                                            <input type="text" id="titre1" name="titre1" required><br>

                                            <label for="date1">Date :</label>
                                            <input type="date" id="date1" name="date1" required><br>

                                            <label for="media1">Image ou vidéo :</label>
                                            <input type="file" id="media1" name="media1" accept="image/*,video/*"><br>

                                            <label for="texte1">Texte :</label><br>
                                            <textarea id="texte1" name="texte1" rows="5" cols="40" required></textarea><br>

                                            <input type="submit" value="Publier l'évenement!">
                                        </form>
                                    </div>

                                    <script>
                                        var formulaireVisible2 = false;

                                        document.getElementById("btn-evenement2").addEventListener("click", function () {
                                            if (formulaireVisible2) {

                                                document.getElementById("formulaire-container1").style.display = "none";
                                                formulaireVisible2 = false;
                                            } else {

                                                document.getElementById("formulaire-container1").style.display = "block";
                                                formulaireVisible2 = true;
                                            }
                                        });
                                    </script>



                                    <button id="btn-evenement3">Rédiger un article </button>

                                    <div id="formulaire-container3" style="display: none;">
                                        <form action="traiter_formulaire3.php" method="post" enctype="multipart/form-data">
                                            <label for="titre3">Titre :</label>
                                            <input type="text" id="titre3" name="titre3" required><br>



                                            <label for="texte3">Texte :</label><br>
                                            <textarea id="texte3" name="texte3" rows="5" cols="40" required></textarea><br>

                                            <input type="submit" value="Publier l'article!">
                                        </form>
                                    </div>

                                    <script>
                                        var formulaireVisible2 = false;

                                        document.getElementById("btn-evenement3").addEventListener("click", function () {
                                            if (formulaireVisible2) {

                                                document.getElementById("formulaire-container3").style.display = "none";
                                                formulaireVisible2 = false;
                                            } else {

                                                document.getElementById("formulaire-container3").style.display = "block";
                                                formulaireVisible2 = true;
                                            }
                                        });
                                    </script>


                                </div>
                            </div>
                        </div>

                        <div class="feedBody">
                        <?php
                        $query2 = "
                        SELECT distinct utilisateur.*, post.*
FROM utilisateur
LEFT JOIN post ON (post.id_utilisateur = utilisateur.id_utilisateur)
LEFT JOIN ami ON (
    (ami.id_utilisateur = utilisateur.id_utilisateur AND ami.id_utilisateur_ami = $user_id)
    OR
    (ami.id_utilisateur_ami = utilisateur.id_utilisateur AND ami.id_utilisateur = $user_id)
)
WHERE (ami.ami_accept = 1 OR post.id_utilisateur = $user_id) AND (post.post0_event1 <> 1)
ORDER BY post.post_date DESC
     
        ";


                        $result2 = mysqli_query($db_handle, $query2);



                        while ($row = mysqli_fetch_assoc($result2)) {

                            $like_state = "SELECT * FROM `aime` WHERE  id_post = " . $row['id_post'] . " AND id_utilisateur = " . $user_id . " ";
                            $result_like = mysqli_query($db_handle, $like_state);
                            $post_like = "";
                            if ($result_like->num_rows > 0) {
                                $row_like = $result_like->fetch_assoc();
                                $post_like = $row_like["aime_state"];
                            }

                            $nombre_like = "SELECT COUNT(*) AS like_count
                            FROM `aime`
                            WHERE id_post = " . $row['id_post'] . " AND aime_state = 1";
                            $result_nombre_like = mysqli_query($db_handle, $nombre_like);
                            $post_nombre_like = "";
                            if ($result_nombre_like->num_rows > 0) {
                                $row_nombre_like = $result_nombre_like->fetch_assoc();
                                $post_nombre_like = $row_nombre_like['like_count'];
                            }


                            echo '
                        <div class="feature-title">
                            
                            <div class="image">';


                            echo '
                            <div class="header_publication">
                                <img src=' . $row['utilisateur_profile_picture'] . ' alt="pp" width="50">
                                <h4>' . $row['utilisateur_pseudo'] . '</h4>
                            </div>
                            <div class="body_publication">';
                            if ($row['post0_event1'] == 0) {
                                echo ' <img src="' . $row['post_image'] . '">';
                            } elseif (!is_null($row['post_image']) && (strpos($row['post_image'], '.mp4') !== false || strpos($row['post_image'], '.mov') !== false || strpos($row['post_image'], '.avi') !== false || strpos($row['post_image'], '.wmv') !== false)) {
                                echo '<video src="' . $row['post_image'] . '" alt="video" width="150" controls>';
                            } elseif ($row['post0_event1'] == 2) {
                                echo '' . $row['post_content'] . '';
                            }
                            echo '
                            </div>
                            <p>' . $row['post_content'] . '</p>
                            <div class="footer_publication">
                                <div class="like" data-post-id="' . $row['id_post'] . '">';
                            if ($post_like == 1) {
                                echo '<img src="../../images/icones/like_ok.png" alt="like" width="30">';
                            } else {
                                echo '<img src="../../images/icones/like.png" alt="like" width="30">';
                            }
                            echo '
                                    ' . $post_nombre_like . '
                                </div>
                                <div class="comment" data-post-id="' . $row['id_post'] . '">
                                <a href="comment.php">
                                    <img src="../../images/icones/comment.png" alt="comment" width="30">
                                </a>
                                </div>
                                <div class="share">
                                    <img src="../../images/icones/share.png" alt="comment" width="32">
                                </div>
                            </div>
                            </div>
                    </div>';
                        }




                        ?>
                        </div>
                    </div>
                    <div class="column2">
                        <div class="columnHead">
                            <h3 class="feature-title">Vos événements</h3>
                        <?php

                        $query1 = "
        SELECT * FROM post
WHERE (id_utilisateur = $user_id) AND post0_event1  =1

    ";

                        $result1 = mysqli_query($db_handle, $query1);

                        while ($row = mysqli_fetch_assoc($result1)) {
                            echo '
                        <div class="feature-title">
                            <div class="image">';


                            if (strpos($row['post_image'], '.jpg') !== false || strpos($row['post_image'], '.jpeg') !== false || strpos($row['post_image'], '.png') !== false || strpos($row['post_image'], '.gif') !== false) {
                                echo '<img src="' . $row['post_image'] . '" alt="logo" width="150">';
                            } elseif (strpos($row['post_image'], '.mp4') !== false || strpos($row['post_image'], '.mov') !== false || strpos($row['post_image'], '.avi') !== false || strpos($row['post_image'], '.wmv') !== false) {
                                echo '<video src="' . $row['post_image'] . '" alt="video" width="150" controls>';
                            }

                            echo '
                                <div class="feedbody">
                                    <p>' . $row['post_content'] . '</p>
                                </div>
                            </div>
                        </div>
                        <p class="date">Publié le : ' . $row['post_date'] . '</p>
                    ';
                        }

                        ?>

                        </div>
                    </div>
                    <div class="column">
                    </div>
                </div>

                <footer class="page-footer">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.3706925053507!2d2.2860177756499986!3d48.85114130121773!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e67151e3c16d05%3A0x1e3446766ada1337!2s10%20Rue%20Sextius%20Michel%2C%2075015%20Paris!5e0!3m2!1sen!2sfr!4v1685744650557!5m2!1sen!2sfr"
                                width="300" height="200" style="border-radius:10px; border: none;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            
                            <p>ECEIn est un réseau social interne a l'ECE, <br> il vous permet en tant que professeur ou étudiant de communiquer, <br> partager des offres de stage et bien plus encore...</p>
                    </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <h6 class="text-uppercase font-weight-bold">Contact</h6>
                            <p>
                                37, quai de Grenelle, 75015 Paris, France <br>
                                info@webDynamique.ece.fr <br> +33 01 02 03 04 05 <br>
                                +33 01 03 02 05 04
                            </p>
                        </div>
                    </div>
                </footer>
        <?php
    } ?>
</body>

</html>