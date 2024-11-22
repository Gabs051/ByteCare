<?php
require_once __DIR__ . '/../../vendor/autoload.php';


$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);
$pdf->Write(0, 'Teste de PDF');
$pdf->Output('teste.pdf', 'I');

