$("#exit").click(function () {
    var exit = confirm("Voulez-vous vraiment mettre fin à la session ?");
    if (exit == true) {
        window.location = "../Accueil/accueil.php?logout=true";
    }
});