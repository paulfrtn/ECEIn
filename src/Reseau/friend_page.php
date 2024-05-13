<?php
include '../Session/session.php';
error_reporting(E_ERROR | E_PARSE);
$user_id = $_SESSION['user_id'];
$ami_id = $_POST['cardId'];


$demande = "SELECT * from utilisateur where id_utilisateur = $ami_id";
$result = mysqli_query($db_handle, $demande);
$rowed = mysqli_fetch_assoc($result);


$ami = "SELECT DISTINCT * FROM ami where ((id_utilisateur = $ami_id or id_utilisateur_ami= $ami_id) and ami_accept=1)";

$f_result = mysqli_query($db_handle, $ami);

$row = mysqli_fetch_assoc($f_result);
$nb_ami = mysqli_num_rows($f_result);

$oups = "SELECT * from ami where ( (id_utilisateur = $user_id and id_utilisateur_ami = $ami_id ) or (id_utilisateur = $ami_id and id_utilisateur_ami = $user_id) )";
$res_2 = mysqli_query($db_handle, $oups);
$row_2 = mysqli_fetch_assoc($res_2);

?>
<!DOCTYPE html>
<html>

<head>
    <title>LinkECEin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="res_styles.css">
    <script type="text/javascript" src="res_script.js"></script>
</head>

<body>
<div class="friend_up">

<div class="friend_wpp">
    <?php echo '
                    <style>
                    .friend_up .friend_wpp{
                        background-image: url("' . $rowed['utilisateur_background_img'] . '");
                        background-size: cover;
                        background-position: center;
                        background-repeat: no-repeat;
                    }
                    </style>
                    
' ?>
</div>
<button class="leave"></button>
<div class="friend_pic">
    <?php echo '
                    <style>
                    .friend_up .friend_pic{
                        background-image: url("' . $rowed['utilisateur_profile_picture'] . '");
                        background-size: cover;
                        background-position: center;
                        background-repeat: no-repeat;
                    }
                    </style>
                    
' ?>
</div>
<div class="friend_desc">
    <div class="banner_below_left">
        <h4>
            <?php echo $rowed['utilisateur_lastname'] . '  ' . $rowed['utilisateur_firstname'] ?>
        </h4>
        <h6>Etudiant à l'ECE Paris</h6>
        <h6> <a href="../Reseau/reseau.php">Relations :
                <?php echo $nb_ami ?>
            </a> </h6>
    </div>
    <div class="banner_below_center">
        <div class="onAbout">
            <img src="../../images/logos/logo2.jpg" alt="" width="35px" height="35px"> Etudie à ECE Paris
        </div>
        <p><img src="../../images/icones/mail.png" alt="" width="35px" height="20px"> <a
                href="<?php $rowed['utilisateur_mail'] ?>"> <?php echo $rowed['utilisateur_mail'] ?></a></p>
    </div>
    <div class="banner_below_right">
        <button class="friend_button" id="<?php echo $row_2['ami_accept'] ?>">

            <?php

            if (!$row_2['ami_accept'] or ($row_2['ami_accept'] != 1 and $row_2['ami_accept'] != 2)) {
                echo 'Envoyer une demande de relation';
            } elseif ($row_2['id_utilisateur'] == $user_id && $row_2['ami_accept'] == 2) {
                echo 'Retirer la demande';
                echo '<style>
                                .friend_button{
                                    background-color: palevioletred;
                                    box-shadow: 2px 6px 6px rgba(219,112,147, 0.7);
                                    color : white;
                                }
                            </style>';
            } elseif ($row_2['id_utilisateur_ami'] == $user_id && $row_2['ami_accept'] == 2) {
                echo 'Accepter';

            } else {
                echo 'Supprimer la relation';
                echo '<style>
                                .friend_button{
                                    background-color: palevioletred;
                                    box-shadow: 2px 6px 6px rgba(219,112,147, 0.7);
                                    color : white;
                                }
                            </style>';
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['buttonClass'])) {
                    $buttonClass = $_POST['buttonClass'];

                    // Effectuer votre requête SQL en utilisant la classe du bouton
                    // ...
            
                    // Répondre au client avec la réponse souhaitée (par exemple, une confirmation)
                    echo "Requête SQL exécutée avec succès";
                }
            }
            ?>




        </button>
    </div>
</div>

</div>
    <div class="friend_down">
        <?php

        $pseudo_click = "SELECT utilisateur_pseudo FROM utilisateur WHERE id_utilisateur = $ami_id";
        $f_result_click = mysqli_query($db_handle, $pseudo_click);

        if ($f_result_click) {
            $row = mysqli_fetch_array($f_result_click);
            $utilisateur_pseudo = $row['utilisateur_pseudo'];
        } else {
            echo "Erreur lors de l'exécution de la requête : " . mysqli_error($db_handle);
        }




        $cheminFichier = '../../images/xml/' . $utilisateur_pseudo . '.xml';


        if (file_exists($cheminFichier)) {
            $xml = simplexml_load_file($cheminFichier);

            foreach ($xml->formation as $formation) {
                $titre = $formation->titre;
                $dateDebut = $formation->date_debut;
                $dateFin = $formation->date_fin;
                $description = $formation->description;

                echo "<h2>$titre</h2>";
                echo "<p>Date de début : $dateDebut</p>";
                echo "<p>Date de fin : $dateFin</p>";
                echo "<p>Description : $description</p>";
                echo "<hr>";
            }
        } else {
            echo $row_pseudo['utilisateur_pseudo'];

            echo "Le fichier XML n'existe pas.";
        }
        ?>
    </div>
</body>

</html>