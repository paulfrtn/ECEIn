<?php
include '../Session/session.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Messagerie</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="chatter_styles.css">
    <script type="text/javascript" src="chatter_script.js"></script>
    <?php
    include_once '../BDD/script/connectionDB.php';
    ?>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript">
        // jQuery Document
        $(document).ready(function () {
            var selectedConversation = ""; // Variable pour stocker l'identifiant de la conversation sélectionnée

            // Gestionnaire d'événements pour la soumission du formulaire de message
            $("#message-form").on("submit", function (e) {
                e.preventDefault(); // Empêche le rechargement de la page lors de la soumission du formulaire

                if (selectedConversation !== "") {
                    var message = $("#usermsg").val(); // Récupère le contenu du message

                    $.post("post.php", { text: message, conversationId: selectedConversation }).done(function () {
                        $("#usermsg").val(""); // Efface le champ de saisie du message
                        loadConversation(selectedConversation); // Recharge la conversation pour afficher le nouveau message
                    });
                } else {
                    // Gérer le cas où aucune conversation n'est sélectionnée
                    alert("Veuillez sélectionner une conversation.");
                }
            });

            $("#mail").on("mousedown", "a", function (e) {
                if (selectedConversation !== "") {
                    e.preventDefault(); // Empêche le comportement par défaut du lien (rafraîchissement de la page)
                    var link = this;

                    $.ajax({
                        url: "mail.php",
                        method: "POST",
                        data: { utilisateur: selectedConversation },
                        cache: false,
                        success: function (data) {
                            $(link).attr('href', data);
                        }
                    });
                } else {
                    // Gérer le cas où aucune conversation n'est sélectionnée
                    e.preventDefault();
                    alert("Veuillez sélectionner une conversation.");
                }
            });





            // Gestionnaire d'événements pour la sélection d'une conversation
            $(".conversation").click(function () {
                var conversationId = $(this).data("conversation-id"); // Récupère l'identifiant de la conversation à partir de l'attribut "data-conversation" de la div

                if (selectedConversation !== conversationId) {

                    selectedConversation = conversationId; // Met à jour l'identifiant de la conversation sélectionnée
                    loadConversation(selectedConversation); // Charge la conversation correspondante dans la chatbox


                    // Request contact details
                    $.get("contact_details.php", { id: conversationId }).done(function (data) {
                        $(".menu").html(data); // Update the content of the 'menu' div
                    }).fail(function () {
                        console.log("Erreur lors de la récupération des détails du contact.");
                    });
                }
            });


            // Fonction pour charger une conversation dans la chatbox
            function loadConversation(conversationId) {
                var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; // Hauteur de défilement avant la requête

                $.ajax({
                    url: "load_conversation.php",
                    method: "POST",
                    data: { conversationId: conversationId },
                    cache: false,
                    success: function (data) {
                        $("#chatbox").html(data); // Insère le log de chat dans la #chatbox div
                        // Auto-scroll
                        var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; // Hauteur de défilement après la requête
                        if (newscrollHeight > oldscrollHeight) {
                            $("#chatbox").animate({ scrollTop: newscrollHeight }, "normal"); // Défilement automatique
                        }
                    },
                    error: function () {
                        console.log("Erreur lors du chargement de la conversation.");
                    }
                });
            }
            setInterval(function () {
                if (selectedConversation !== "") {
                    loadConversation(selectedConversation);
                }
            }, 500);
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
        <a class="navbar-brand" href="#"> <a href="../Accueil/accueil.php"><img src="../../images/logos/logo.png" alt="logo"
                        width="120"> </a>
                <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse"
                    data-target="#main-navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="main-navigation">
                    <ul class="navbar-nav">
                        <?php echo $_SESSION['name'];
                                echo $_SESSION['user_id']; ?>

                        <li class="nav-item"><a class="nav-link" href="../Accueil/accueil.php">Accueil</a></li>
                        <li class="nav-item"><a class="nav-link" href="../Reseau/reseau.php">Réseau</a></li>
                        <li class="nav-item"><a class="nav-link" href="../Emplois/emplois.php">Emplois</a></li>
                        <li class="nav-item"><a class="nav-link" href="chatter.php">Messagerie</a></li>
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
            <div class="historique">
                <div class="histoHead">
                    <h4>Messagerie</h4>

                </div>
                <div class="histoBody">

                    <?php
                    $counter = 0;
                    $username = $_SESSION['name'];
                    $user_id = $_SESSION['user_id'];

                    $ami = "SELECT * FROM ami where ((id_utilisateur = $user_id or id_utilisateur_ami= $user_id) and ami_accept=1)";
                    $f_result = mysqli_query($db_handle, $ami);

                    while ($row = mysqli_fetch_assoc($f_result)) {
                        if ($row['id_utilisateur'] == $user_id) {
                            $id_ami = $row['id_utilisateur_ami'];
                        } elseif ($row['id_utilisateur_ami'] == $user_id) {
                            $id_ami = $row['id_utilisateur'];
                        } else {
                        }
                        $user_ami = "SELECT * FROM utilisateur where id_utilisateur = $id_ami";
                        $f_result2 = mysqli_query($db_handle, $user_ami);
                        while ($row2 = mysqli_fetch_assoc($f_result2)) {
                            $counter++;
                            echo '

                            <div class="conversation" data-conversation-id="' . $row2['id_utilisateur'] . '">
                        <img src="'.$row2['utilisateur_profile_picture'].'" alt="contact1" width="60">
                        <div class="infoMess">
                            <h5>
                                ' . $row2['utilisateur_pseudo'] . '
                            </h5>
                            <p>(' . $row2['utilisateur_firstname'] . ' ' . $row2['utilisateur_lastname'] . ')</p>
                        </div>
                    </div>';
                        }


                    }
                    ?>
                </div>

            </div>

            <div class="wrapper">
                <div class="menu">
                </div>
                <div class="chatbox" id="chatbox">
                </div>
                <form name="message" id="message-form" action="">
                    <input name="usermsg" type="text" id="usermsg" />
                    <div class="actionMess">
                        <div class="joindre">
                            <div id="visio"><a
                                    href="https://teams.microsoft.com/l/meetup-join/19%3ameeting_Y2MwNjFkZTItM2NlNi00ZDAxLWJiMTUtYWMwMDZlYzQ4YTgz%40thread.v2/0?context=%7b%22Tid%22%3a%22a2697119-66c5-4126-9991-b0a8d15d367f%22%2c%22Oid%22%3a%229ecaaa49-f285-4ff9-af90-7e12f65dfd84%22%7d"
                                    target="_blank"> <img src="../../images/icones/visio.png" alt="visio" width="40"> </a></div>
                            <div id="phone"><a href=""> <img src="../../images/icones/phone.png" alt="tel" width="30"> </a></div>
                            <div id="mail"><a href=""> <img src="../../images/icones/mail.png" alt="mail" width="30"> </a></div>
                        </div>
                        <div id="send"><button name="submitmsg" type="submit" id="submitmsg"> <img src="../../images/icones/send.png"
                                    alt="send" width="30"></button> </div>
                    </div>
                </form>
            </div>
        </div>

        <?php
    } ?>

</body>

</html>