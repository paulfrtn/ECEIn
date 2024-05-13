<!DOCTYPE html>
<html>
<head>
    <title>Exemple de page HTML</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var latestDataElement = document.getElementById("latestData");
            var titreFormation = latestDataElement.getAttribute("data-title");
            var latestDate = latestDataElement.getAttribute("data-date");

            var formationDetails = document.getElementById("formationDetails");
            formationDetails.innerHTML = "";

            var titreElement = document.createElement("h6");
            titreElement.innerText = titreFormation;

            var dateElement = document.createElement("h6");
            dateElement.innerText = "Dernière date : " + latestDate;

            formationDetails.appendChild(titreElement);
            formationDetails.appendChild(dateElement);
        });
    </script>
</head>
<body>
    <div id="formationDetails"></div>
    <?php
    $xmlFile = 'formations.xml'; 

    $xml = simplexml_load_file($xmlFile);

    $latestDate = null;
    $latestTitle = null;

    foreach ($xml->formation as $formation) {
        $dateFin = (string) $formation->date_fin;
        $titreFormation = (string) $formation->titre;

        if ($latestDate === null || $dateFin > $latestDate) {
            $latestDate = $dateFin;
            $latestTitle = $titreFormation;
        }
    }

    echo '<div id="latestData" data-title="' . $latestTitle . '" data-date="' . $latestDate . '"></div>';
    ?>
</body>
</html>
