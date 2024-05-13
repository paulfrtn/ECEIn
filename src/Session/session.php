<?php
include_once '../BDD/script/connectionDB.php';


session_start();

if (isset($_GET['logout'])) {

    $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>" .
        $_SESSION['name'] . "</b> a quitté la session de chat.</span><br></div>";

    session_destroy();
    sleep(1);
    header("Location: ../Accueil/accueil.php");
}

if (isset($_POST['enter'])) {
    if ($_POST['name'] != "") {
        $username = stripslashes(htmlspecialchars($_POST['name']));
        $password = $_POST['password'];

        $name = $db_handle->prepare("SELECT * FROM utilisateur WHERE utilisateur_pseudo = ?");
        $name->bind_param("s", $username);
        $name->execute();
        $result = $name->get_result();

        if ($result->num_rows > 0) {
            $_user = $result->fetch_assoc();
            if(password_verify($password, $_user['utilisateur_password'])){
                $_SESSION['name'] = $username;
                $id = $_user['id_utilisateur'];
                $role = $_user['utilisateur_role'];

                $_SESSION['user_id'] = $id;
                if ($role == 1) {
                    $_SESSION['role'] = "admin";
                } else {
                    $_SESSION['role'] = "user";
                }
            }else {
                $_SESSION['error_message'] = 'Mot de passe incorrect';
            }
        } else {
            $_SESSION['error_message'] = 'Nom d\'utilisateur incorrect';
        }
    } else {
        echo '<span class="error">Veuillez saisir votre nom</span>';
    }
}

function loginForm()
{
    include '../Session/loginform.php';
}

?>