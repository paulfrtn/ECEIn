<?php
session_start();
include '../BDD/script/connectionDB.php'; // Include your db connection script
if(isset($_SESSION['name'])) {
    $text = mysqli_real_escape_string($db_handle, $_POST['text']); // Escape special characters in string
    
    $conversationId = $_POST['conversationId']; // Get the conversation ID from POST data
    
    $username = $_SESSION['name'];
    $sql1 = "SELECT id_utilisateur FROM utilisateur WHERE utilisateur_pseudo = '$username'";
    $result = mysqli_query($db_handle, $sql1);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_char = $row["id_utilisateur"];
        $user_id = intval($user_char);
    }

    $sql = "INSERT INTO messages (user_receptor, user_sender, message, user_pseudo) VALUES ('$conversationId', '$user_id', '$text', '$username')";
    if(mysqli_query($db_handle, $sql)){
        echo "Message posted successfully!";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($db_handle);
    }
}
?>

<!--

session_start();
include '../BDD/script/connectionDB.php'; // Include your db connection script
if (isset($_SESSION['name'])) {
    $text = mysqli_real_escape_string($db_handle, $_POST['text']); // Escape special characters in string

    $conversationId = $_POST['conversationId']; // Get the conversation ID from POST data

    $username = $_SESSION['name'];
    $sql1 = "SELECT id_utilisateur FROM utilisateur WHERE utilisateur_pseudo = '$username'";
    $result = mysqli_query($db_handle, $sql1);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row["id_utilisateur"];
    }

    $sql2 = "INSERT INTO chatter (id_utilisateur, id_utilisateur_chatter, chat_content) VALUES ('$user_id', '$conversationId', '$text')";
    if (mysqli_query($db_handle, $sql2)) {
        echo "Message posted successfully!";
    } else {
        echo "ERROR: Could not able to execute $sql2. " . mysqli_error($db_handle);
    }
}

 -->