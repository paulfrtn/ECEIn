<?php
include '../Session/session.php';
$user_id = $_SESSION['user_id'];
$fId_n = $_POST['fId_n'];
echo 'user_id'.$user_id;
//echo $fId;

$sql = "INSERT INTO enregistrer (offer_id,id_utilisateur,save_state) VALUE ($fId_n,$user_id,1)";
$result = mysqli_query($db_handle, $sql);


?>
