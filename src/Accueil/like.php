<?php
include '../Session/session.php';
include_once '../BDD/script/connectionDB.php';
$post_id = $_POST['post_id'];
$user = $_SESSION['name'];

$sql1 = "SELECT id_utilisateur FROM utilisateur WHERE utilisateur_pseudo = '$user'";
$result = mysqli_query($db_handle, $sql1);
$user_id ="";
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_id = $row["id_utilisateur"];
}

$sql = "INSERT INTO aime (id_post, id_utilisateur, aime_state) VALUES ($post_id, $user_id, 1)";
$result1 = mysqli_query($db_handle, $sql);
?>


