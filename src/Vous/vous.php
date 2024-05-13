<?php
include '../Session/session.php';
$user_id = $_SESSION['user_id'];

$ami = "SELECT DISTINCT * FROM ami where ((id_utilisateur = $user_id or id_utilisateur_ami= $user_id) and ami_accept=1)";
$user = "SELECT * FROM utilisateur where id_utilisateur = $user_id";
$pseudo = "SELECT utilisateur_pseudo FROM utilisateur where id_utilisateur = $user_id";

$f_result = mysqli_query($db_handle, $ami);
$f_result_user = mysqli_query($db_handle, $user);
$f_result_pseudo = mysqli_query($db_handle, $pseudo);

$row = mysqli_fetch_assoc($f_result);
$row_user = mysqli_fetch_assoc($f_result_user);
$nb_ami = mysqli_num_rows($f_result);
if($f_result_pseudo->num_rows > 0){
    $row_pseudo = mysqli_fetch_assoc($f_result_pseudo);
    $user_pseudo = $row_pseudo['utilisateur_pseudo'];
}
//echo '<h6> <a href="../Reseau/reseau.html">' . $nb_ami . ' relations</a>  </h6>';


?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titreFormation = $_POST['titreFormation'];
    $dateDebut = $_POST['dateDebut'];
    $dateFin = $_POST['dateFin'];
    $descriptionFormation = $_POST['descriptionFormation'];

    if (!empty($titreFormation) && !empty($dateDebut) && !empty($dateFin) && !empty($descriptionFormation)) {
        $xmlString = file_get_contents('../../images/xml/'.$user_pseudo.'.xml');
        $xml = new SimpleXMLElement($xmlString);

        $newFormation = $xml->addChild('formation');
        $newFormation->addChild('titre', $titreFormation);
        $newFormation->addChild('date_debut', $dateDebut);
        $newFormation->addChild('date_fin', $dateFin);
        $newFormation->addChild('description', $descriptionFormation);

        $xml->asXML('../../images/xml/'.$user_pseudo.'.xml');

    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Votre profil</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="you_styles.css">
    <script type="text/javascript" src="you_script.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="jsPDF-master\src\jspdf.js"></script>
    <script src="jsPDF-master\src\jspdf.plugin.autotable.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fpdf/1.82/fpdf.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            <?php
            include '../Session/session.js';
            ?>
            var latestDataElement = document.getElementById("latestData");
            var titreFormation = latestDataElement.getAttribute("data-title");
            var latestDate = latestDataElement.getAttribute("data-date");

            var formationDetails = document.getElementById("formationDetails");
            formationDetails.innerHTML = "";

            var titreElement = document.createElement("h6");
            titreElement.innerText = titreFormation;

            var dateElement = document.createElement("h6");
            dateElement.innerText = "Date de fin : " + latestDate;

            formationDetails.appendChild(titreElement);
            formationDetails.appendChild(dateElement);
        });

        var formulaireVisible = false;

function toggleFormulaire() {
  var formulaire = document.getElementById("formulaire");

  if (formulaireVisible) {
    formulaire.style.display = "none";
    formulaireVisible = false;
  } else {
    formulaire.style.display = "block";
    formulaireVisible = true;
  }
}

$(document).ready(function() {
  function chargerFormations() {
    $.ajax({
      type: "GET",
      url: '<?php echo '../../images/xml/'.$user_pseudo.'.xml'; ?>',
      dataType: "xml",
      success: function(xml) {

          $('#listeFormations').empty();

          $(xml).find('formation').each(function() {
            var titreFormation = $(this).find('titre').text();
            var dateDebut = $(this).find('date_debut').text();
            var dateFin = $(this).find('date_fin').text();
            var descriptionFormation = $(this).find('description').text();
  
            var nouvelleFormation = $('<div class="activ">');
            nouvelleFormation.append('<h4>' + titreFormation + '</h4>');
            nouvelleFormation.append('<p>Date de début : ' + dateDebut + '</p>');
            nouvelleFormation.append('<p>Date de fin : ' + dateFin + '</p>');
            nouvelleFormation.append('<p>Description : ' + descriptionFormation + '</p>');
            nouvelleFormation.append('</div>');
  
            $('#listeFormations').append(nouvelleFormation);
          });
        
      }
    });
  }

  chargerFormations();

  $('#enregistrer').click(function(e) {
    e.preventDefault();
    var titreFormation = $('#titre-formation').val();
    var dateDebut = $('#date-debut').val();
    var dateFin = $('#date-fin').val();
    var descriptionFormation = $('#description-formation').val();

    if (titreFormation === "" || dateDebut === "" || dateFin === "" || descriptionFormation === "") {
      alert("Veuillez remplir tous les champs du formulaire.");
      return;
    }

    var formationData = {
      titreFormation: titreFormation,
      dateDebut: dateDebut,
      dateFin: dateFin,
      descriptionFormation: descriptionFormation
    };

    $.ajax({
      url: 'vous.php',
      type: 'POST',
      data: formationData,
      success: function(response) {
        alert('Enregistrement réussi dans le fichier XML');
        location.reload();
        $('#formFormation')[0].reset();
        chargerFormations();
      },
      error: function(xhr, status, error) {
        alert('Erreur lors de l\'enregistrement : ' + error);
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
                <a class="navbar-brand" href="#"> <a href="../Accueil/accueil.php"><img src="../../images/logos/logo.png" alt="logo"
                        width="120"> </a>
                        <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse"
                            data-target="#main-navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="main-navigation">
                            <ul class="navbar-nav">
                                <?php echo $user_pseudo;?>

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

                    <div class="header_contain">
                        <div class="my_banner">
                        <?php
                        echo ' <style>
                .header_contain .my_banner {
                    width: 100%;
                    margin-left: 0;
                    height: 45vh;
                    transition: 1s;
                    background-image: url("' . $row_user['utilisateur_background_img'] . '");
                    background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center;
                    border-top-left-radius: 10px;
                    border-top-right-radius: 10px;
                  }
                </style>';


                        ?>
                        </div>
                        <div class="profile_pic">

                        <?php
                        echo ' <style>
                .header_contain .profile_pic {
                    display: flex;
                    flex-direction: column;
                    width: 20vh;
                    height: 40vh;
                    border-radius: 50%;
                    border: 5px solid #e7f0f1;
                    margin-top: -15vh;
                    margin-left: 5vh;
                    transition: 1s;
                    background-image: url("' . $row_user['utilisateur_profile_picture'] . '");
                    background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center;
                    transition: 1s;
                  }
                </style>';


                        ?>
                        </div>
                        <div class="banner_below">
                            <div class="banner_below_left">
                            <?php
                            echo '<h4>' . $row_user['utilisateur_lastname'] . '  ' . $row_user['utilisateur_firstname'] . '</h4>';
                            ?>


                            <?php
                            $xmlFile = '../../images/xml/'.$user_pseudo.'.xml';

                            $xml = simplexml_load_file($xmlFile);

                            $latestDate = null;
                            $latestTitle = null;

                            foreach ($xml->formation as $formation) {
                                $dateFin = (string) $formation->date_fin;
                                $titreFormation = (string) $formation->titre;

                                if ($latestDate === null || $dateFin > $latestDate) {
                                    $latestDate = $dateFin;
                                    $latestTitle = $titreFormation;
                                }
                            }

                            echo '<div id="latestData" data-title="' . $latestTitle . '" data-date="' . $latestDate . '"></div>';
                            echo '<h6> <a href="../Reseau/reseau.php">' . $nb_ami . ' relations</a>  </h6>';
                            ?>


                            </div>
                            <div class="banner_below_center">
                                <div class="onAbout">
                                    <a>
                                        <div id="formationDetails"></div>
                                    </a>

                                </div>
                                <p><img src="../../images/icones/mail.png" alt="" width="35px" height="30px"> <a
                                        href="<?php $row_user['utilisateur_mail'] ?>"> <?php echo $row_user['utilisateur_mail'] ?></a></p>
                                </div>
                            <div class="banner_below_right">
                                <button class="modif_btn">Modifier</button>

                                <button onclick="window.open('cv_generator.php')">Générer CV</button>



                            </div>
                        </div>
                    </div>
                    <div class="main_contain">
                        <div class="main" id="formation">
                            <div class="form_head">
                                <h1>Activités</h1>


                                <div class="add_form">
                                    <button onclick="toggleFormulaire()">Ajouter</button>
                                </div>

                            </div>



                            <form id="formulaire" style="display: none;">
                                <label for="titre-formation">Titre de la formation:</label>
                                <input type="text" id="titre-formation" name="titre-formation"><br>

                                <label for="date-debut">Date de début:</label>
                                <input type="date" id="date-debut" name="date-debut"><br>

                                <label for="date-fin">Date de fin:</label>
                                <input type="date" id="date-fin" name="date-fin"><br>

                                <label for="description-formation">Description de la formation:</label><br>
                                <textarea id="description-formation" name="description-formation" rows="4" cols="50"></textarea><br>

                                <button id="enregistrer" onclick="enregistrerFormation()">Enregistrer</button>

                            </form>
                            <div id="listeFormations"></div>




                        </div>
                <?php
    } ?>
</body>

</html>