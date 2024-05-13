<?php
include '../Session/session.php';
include '../BDD/script/connectionDB.php';

$utilisateur = $_POST['utilisateur'];

$query = "
        SELECT utilisateur_mail
        FROM utilisateur
        WHERE id_utilisateur = '$utilisateur'
        ";

$result = mysqli_query($db_handle, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo 'mailto:' . $row['utilisateur_mail'];
}
?>
