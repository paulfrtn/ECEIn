<?php
include '../Session/session.php';

    $user_id = $_SESSION['user_id'];
    $tri = $_POST['choix'];

    if($tri==2){
        $query = "
        SELECT u.*, p.*
        FROM ami a
        LEFT JOIN utilisateur u ON (
            (a.id_utilisateur = u.id_utilisateur AND a.id_utilisateur_ami = $user_id)
            OR 
            (a.id_utilisateur_ami = u.id_utilisateur AND a.id_utilisateur = $user_id)
            OR
            (a.id_utilisateur = u.id_utilisateur AND a.id_utilisateur_ami = 25)
            OR
            (a.id_utilisateur_ami = u.id_utilisateur AND a.id_utilisateur = 25)
        )
        LEFT JOIN post p ON p.id_utilisateur = u.id_utilisateur
        WHERE (a.ami_accept = 1 AND p.post0_event1 = 1) OR (p.post0_event1 = 1 AND u.id_utilisateur = 25)
        ORDER BY p.post_date ASC
    ";
    }
    elseif($tri==3){
        $query = "
        SELECT u.*, p.*
        FROM ami a
        LEFT JOIN utilisateur u ON (
            (a.id_utilisateur = u.id_utilisateur AND a.id_utilisateur_ami = $user_id)
            OR 
            (a.id_utilisateur_ami = u.id_utilisateur AND a.id_utilisateur = $user_id)
            OR
            (a.id_utilisateur = u.id_utilisateur AND a.id_utilisateur_ami = 25)
            OR
            (a.id_utilisateur_ami = u.id_utilisateur AND a.id_utilisateur = 25)
        )
        LEFT JOIN post p ON p.id_utilisateur = u.id_utilisateur
        WHERE (a.ami_accept = 1 AND p.post0_event1 = 1) OR (p.post0_event1 = 1 AND u.id_utilisateur = 25)
        ORDER BY u.utilisateur_lastname ASC
    ";
    }
    else{
        $query = "
        SELECT u.*, p.*
        FROM ami a
        LEFT JOIN utilisateur u ON (
            (a.id_utilisateur = u.id_utilisateur AND a.id_utilisateur_ami = $user_id)
            OR 
            (a.id_utilisateur_ami = u.id_utilisateur AND a.id_utilisateur = $user_id)
            OR
            (a.id_utilisateur = u.id_utilisateur AND a.id_utilisateur_ami = 25)
            OR
            (a.id_utilisateur_ami = u.id_utilisateur AND a.id_utilisateur = 25)
        )
        LEFT JOIN post p ON p.id_utilisateur = u.id_utilisateur
        WHERE (a.ami_accept = 1 AND p.post0_event1 = 1) OR (p.post0_event1 = 1 AND u.id_utilisateur = 25)
        ORDER BY p.post_date DESC
    ";
    }

    $result = mysqli_query($db_handle, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="notification">
            <h2>'.$row['utilisateur_firstname'].' '.$row['utilisateur_lastname'].'</h2>
            <p>'.$row['post_content'].'</p>
            <p class="date">Publié le '.$row['post_date'].'</p>
        </div>';
    }
?>