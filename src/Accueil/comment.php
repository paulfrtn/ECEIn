<?php
include '../Session/session.php';
include_once '../BDD/script/connectionDB.php';
$post_id = $_POST['id_post'];
$user = $_SESSION['name'];
var_dump($_POST);

?>


<!DOCTYPE html>
<html>

<head>
    <title>Accueil LinkECEIn</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="Acc_styles.css">
    <script type="text/javascript" src="acc_script.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
    <?php
    $query2 = "
        SELECT p.*, u.* 
        FROM `post` p
        INNER JOIN utilisateur u ON p.id_utilisateur = u.id_utilisateur
        WHERE id_post = '.$post_id.'
        ";

        $result2 = mysqli_query($db_handle, $query2);
        if ($result2->num_rows > 0) {
            $row = $result2->fetch_assoc();
        }

        $like_state = "SELECT * FROM `aime` WHERE  id_post = " . $row['id_post'] . " AND id_utilisateur = " . $user_id . " ";
        $result_like = mysqli_query($db_handle, $like_state);
        $post_like = "";
        if ($result_like->num_rows > 0) {
            $row_like = $result_like->fetch_assoc();
            $post_like = $row_like["aime_state"];
        }

        $nombre_like = "SELECT COUNT(*) AS like_count
                            FROM `aime`
                            WHERE id_post = " . $row['id_post'] . " AND aime_state = 1";
        $result_nombre_like = mysqli_query($db_handle, $nombre_like);
        $post_nombre_like = "";
        if ($result_nombre_like->num_rows > 0) {
            $row_nombre_like = $result_nombre_like->fetch_assoc();
            $post_nombre_like = $row_nombre_like['like_count'];
        }


        echo '
                        <div class="feature-title">
                            
                            <div class="image">';


        echo '
                            <div class="header_publication">
                                <img src=' . $row['utilisateur_profile_picture'] . ' alt="pp" width="50">
                                <h4>' . $row['utilisateur_pseudo'] . '</h4>
                            </div>
                            <div class="body_publication">';
        if (!is_null($row['post_image']) && (strpos($row['post_image'], '.jpg') !== false || strpos($row['post_image'], '.jpeg') !== false || strpos($row['post_image'], '.png') !== false || strpos($row['post_image'], '.gif') !== false)) {
            echo ' <img src="' . $row['post_image'] . '">';
        } elseif (!is_null($row['post_image']) && (strpos($row['post_image'], '.mp4') !== false || strpos($row['post_image'], '.mov') !== false || strpos($row['post_image'], '.avi') !== false || strpos($row['post_image'], '.wmv') !== false)) {
            echo '<video src="' . $row['post_image'] . '" alt="video" width="150" controls>';
        } elseif ($row['post0_event1'] == 2) {
            echo '' . $row['post_content'] . '';
        }
        echo '
                            </div>
                            <p>' . $row['post_content'] . '</p>
                            <div class="footer_publication">
                                <div class="like" data-post-id="' . $row['id_post'] . '">';
        if ($post_like == 1) {
            echo '<img src="../../images/icones/like_ok.png" alt="like" width="30">';
        } else {
            echo '<img src="../../images/icones/like.png" alt="like" width="30">';
        }
        echo '
                                    ' . $post_nombre_like . '
                                </div>
                                <div class="comment">
                                    <img src="../../images/icones/comment.png" alt="comment" width="30">
                                </div>
                                <div class="share">
                                    <img src="../../images/icones/share.png" alt="comment" width="32">
                                </div>
                            </div>
                            </div>
                    </div>';
    ?>
</body>

</html>