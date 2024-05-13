<?php
include '../Session/session.php';
$user_id = $_SESSION['user_id'];
$fId_n = $_POST['fId_y'];
echo 'user_id'.$user_id;
//echo $fId;

$sql = "DELETE from enregistrer WHERE (id_utilisateur = $user_id and offer_id= $fId_n)";
$result = mysqli_query($db_handle, $sql);


?>
