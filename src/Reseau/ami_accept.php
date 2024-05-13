<?php
include '../Session/session.php';
$user_id = $_SESSION['user_id'];
$fId = $_POST['fId'];
echo 'user_id'.$user_id;
//echo $fId;

$sql = "UPDATE ami SET ami_accept = 1 WHERE  (id_utilisateur_ami = $user_id AND id_utilisateur = $fId)";
$result = mysqli_query($db_handle, $sql);


?>
