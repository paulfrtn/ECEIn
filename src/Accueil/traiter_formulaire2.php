<?php
date_default_timezone_set('Europe/Paris');
// Connexion à la base de données
include '../Session/session.php';
$user_id = "3";
$dsn = 'mysql:host=db;port=3300;dbname=ECEInDB';
$username = 'root';
$password = 'mypassword';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Récupération des données du formulaire
$texte = $_POST['texte'];

// Récupération du fichier image
$image = $_FILES['media']['name'];

// Déplacement du fichier vers un emplacement de votre choix
$cheminImage = '../../images/posts/' . $image;
move_uploaded_file($_FILES['media']['tmp_name'], $cheminImage);
$date = date('Y-m-d H:i:s');
// Construction de la requête SQL
$sql = "INSERT INTO post (post_image, post_date, post_content, post0_event1, post_confid, id_utilisateur)
        VALUES (:post_image, :post_date, :post_content, 0, :post_confid, :user_id)";

// Préparation de la requête
$stmt = $pdo->prepare($sql);

// Affectation des valeurs aux paramètres de la requête
$stmt->bindParam(':post_image', $cheminImage);
$stmt->bindParam(':post_date', $date);
$stmt->bindValue(':post_content', $texte);
$stmt->bindValue(':post_confid', 0); // Valeur fixe pour post_confid
$stmt->bindParam(':user_id', $user_id);

// Exécution de la requête
if ($stmt->execute()) {
    // Insertion réussie

    // Rechargement de la page d'accueil
    header('Location: accueil.php');
    exit();
} else {
    // Erreur lors de l'insertion

}
?>