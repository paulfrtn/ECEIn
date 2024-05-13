<?php
require('../../lib/fpdf185/fpdf.php');



$xmlString = file_get_contents('formations.xml');
$xml = new SimpleXMLElement($xmlString);


$pdf = new FPDF();
$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Mon CV', 0, 1, 'C');
$pdf->Ln(10);


$formationCount = 1;
foreach ($xml->formation as $formation) {
    $titreFormation = $formation->titre;
    $dateDebut = $formation->date_debut;
    $dateFin = $formation->date_fin;
    $descriptionFormation = $formation->description;

    
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, "Formation $formationCount", 0, 1);

    
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, $titreFormation, 0, 1);
    $pdf->Cell(0, 10, "Du $dateDebut au $dateFin", 0, 1);
    $pdf->Cell(0, 10, $descriptionFormation, 0, 1);
    $pdf->Ln();

    $formationCount++;
}


$pdf->Output('cv.pdf', 'F');


echo 'CV généré avec succès : <a href="cv.pdf">Télécharger le CV</a>';


?>
