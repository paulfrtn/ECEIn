<?php
ob_start();
include '../Session/session.php';
//error_reporting(E_ERROR | E_PARSE);
$user_id = $_SESSION['user_id'];

echo 'user_id ='.$user_id;
$friend_id = $_POST['card_ID'];
$friend_accept = $_POST['buttonId'];
/*echo $friend_id;
echo 'et';
echo $friend_accept;*/
//echo $user_id;
if ($friend_accept == 1) {
    echo 'oui';
    $sql1 = "DELETE FROM ami WHERE ((id_utilisateur =  $user_id AND id_utilisateur_ami =  $friend_id) OR (id_utilisateur = $friend_id  AND id_utilisateur_ami = $user_id ))";
    $result1 = mysqli_query($db_handle, $sql1);
}
if ($friend_accept == 2) {
    //Accepter amitié
    echo 'non';
    $sql3 = "DELETE FROM ami WHERE id_utilisateur =  $user_id AND id_utilisateur_ami =  $friend_id";
    $result3 = mysqli_query($db_handle, $sql3);
}
if ($friend_accept == 2) {
    //Accepter amitié
    echo 'non';
    $sql = "UPDATE ami SET ami_accept = 1 WHERE (id_utilisateur_ami =  $user_id  AND id_utilisateur =  $friend_id)";
    $result = mysqli_query($db_handle, $sql);
}

if (!$friend_accept) {
    echo 'bizarre';
    $currentDate = date('Y-m-d H:i:s');
    $sql2 = "INSERT INTO ami (id_utilisateur, id_utilisateur_ami, ami_accept, date_accept) VALUES (' $user_id ', ' $friend_id ', 2, ' $currentDate ')";
    $result2 = mysqli_query($db_handle, $sql2);
    
}


ob_end_flush();

?>