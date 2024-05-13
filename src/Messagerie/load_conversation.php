<?php
include '../Session/session.php';
include '../BDD/script/connectionDB.php'; // Include your db connection script
$conversationId = $_POST['conversationId']; // Get the conversation ID from POST data

$username = $_SESSION['name'];
$sql1 = "SELECT id_utilisateur FROM utilisateur WHERE utilisateur_pseudo = '$username'";
$result = mysqli_query($db_handle, $sql1);
$user_id ="";

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_id = $row["id_utilisateur"];
    
}

$sql2 = "SELECT * FROM messages WHERE ((user_receptor = $conversationId AND user_sender = $user_id) OR (user_receptor = $user_id AND user_sender = $conversationId)) ORDER BY timestamp ASC";
$result = mysqli_query($db_handle, $sql2);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $date = new Datetime($row["timestamp"]);
        $heure = $date->format('H:i:s');
        echo '<div class="msgln"><span class="chat-time">' . $heure . '</span> <b class="username">' . $row['user_pseudo'] . ' <br> </b> ' . stripslashes(htmlspecialchars($row["message"])) . '<br></div>';
    }
} else {
    
}
?>