<?php
include_once '../BDD/script/connectionDB.php';

$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$mail = $_POST['mail'];
$pseudo = $_POST['pseudo'];
$mdp = $_POST['mdp'];
$role = ($_POST['role'] == 'admin') ? 1 : 0;
$birthdate = $_POST['birthdate'];

// Enregistrement des images
$target_dir_pic = "../../images/profile_pic/";
$target_dir_wpp = "../../images/wpp/";

$imageProfilType = strtolower(pathinfo($_FILES["profilePicture"]["name"], PATHINFO_EXTENSION));
$new_profil_name = "photoProfile" . $pseudo . "." . $imageProfilType;
$target_profil = $target_dir_pic . $new_profil_name;

$imageBackgroundType = strtolower(pathinfo($_FILES["backgroundPicture"]["name"], PATHINFO_EXTENSION));
$new_background_name = "background" . $pseudo . "." . $imageBackgroundType;
$target_background = $target_dir_wpp . $new_background_name;

// On utilise la fonction hash pour hasher le mot de passe (c'est une sécurité pour éviter de l'avoir directement dans la base de données)
$hashed_mdp = password_hash($mdp, PASSWORD_DEFAULT);

// Enregistrement de l'image pour la photo de profile de l'utilisateur
if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_profil)) {
    $profilePicture = $target_profil;
} else {
    $profilePicture = "";
}

// Enregistrement de l'image pour la bannière de l'utilisateur
if (move_uploaded_file($_FILES["backgroundPicture"]["tmp_name"], $target_background)) {
    $backgroundPicture = $target_background;
} else {
    $backgroundPicture = "";
}

// Préparation de la requête SQL pour inserer ces informations dans la base de données
$stmt = $db_handle->prepare("
                                INSERT INTO 
                                            utilisateur (utilisateur_firstname, utilisateur_lastname, utilisateur_mail, 
                                            utilisateur_pseudo, utilisateur_password, utilisateur_role, utilisateur_profile_picture, 
                                            utilisateur_birthday, utilisateur_background_img)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                                 ");
$stmt->bind_param("sssssssss", $prenom, $nom, $mail, $pseudo, $hashed_mdp, $role, $profilePicture, $birthdate, $backgroundPicture);

// Execution de la requête
$stmt->execute();

$sql = "SELECT id_utilisateur FROM utilisateur WHERE utilisateur_pseudo = '$pseudo'";
$result = mysqli_query($db_handle, $sql);
$data = mysqli_fetch_assoc($result);
$id_utilisateur = $data['id_utilisateur'];

$sql1 = "INSERT INTO ami (id_utilisateur, id_utilisateur_ami, ami_accept, date_accept) VALUES ('$id_utilisateur', '1', '1', current_timestamp())";
$result1 = mysqli_query($db_handle, $sql1);

$xml = new DOMDocument("1.0", "UTF-8");

$formations = $xml->createElement("formations");
$xml->appendChild($formations);

$formation = $xml->createElement("formation");
$formations->appendChild($formation);

$titre = $xml->createElement("titre");
$formation->appendChild($titre);

$date_debut = $xml->createElement("date_debut");
$formation->appendChild($date_debut);

$date_fin = $xml->createElement("date_fin");
$formation->appendChild($date_fin);

$description = $xml->createElement("description");
$formation->appendChild($description);

$xml->save("../../images/xml/".$pseudo.".xml");


$db_handle->close();
header("Location: administration.php");
exit;
?>