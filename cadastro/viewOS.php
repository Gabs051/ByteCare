<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . '/bytecare/templates/header.php');
    require_once __DIR__ . '/../../vendor/tecnickcom/tcpdf/tcpdf.php';
    require_once __DIR__ . '/../../vendor/autoload.php';

    if (!isset($_GET['id'])) {
        die("ID da ordem de serviço não especificado.");
    }

    $orderId = $_GET['id'];

    try {
        $stmt = $connect -> prepare("SELECT * FROM service_order WHERE id = ?");
        $stmt -> bind_param("i", $orderId);
        $stmt -> execute();
        $serviceOrder = $stmt -> get_result() -> fetch_assoc();

        if (!$serviceOrder) {
            die("Ordem de serviço não encontrada.");
        }

        $stmt -> close();
    } catch (Exception $e) {
        die("Erro ao carregar a OS: " . $e -> getMessage());
    }

    try {
        $stmt = $connect -> prepare("SELECT * FROM client WHERE id = ?");
        $stmt -> bind_param("i", $serviceOrder['id_client']);
        $stmt -> execute();
        $client = $stmt -> get_result() -> fetch_assoc();

        if (!$client) {
            die("Ordem de serviço não encontrada.");
        }

        $stmt -> close();
    } catch (Exception $e) {
        die("Erro ao carregar a OS: " . $e -> getMessage());
    }

    $dir = $BASE_URL . 'uploads/';

    $pdf = new TCPDF();
    $pdf -> SetCreator('ByteCare');
    $pdf -> SetAuthor('ByteCare Sistemas');
    $pdf -> SetTitle('Nota de Ordem de Serviço');
    $pdf -> SetHeaderData($dir, 50, "ByteCare Soluções", "CNPJ: 00.000.000/0001-00\nEndereço: Rua Exemplo, 123 - Cidade/Estado");

    $pdf -> SetMargins(10, 20, 10);
    $pdf -> SetHeaderMargin(10);
    $pdf -> SetFooterMargin(10);
    $pdf -> SetAutoPageBreak(TRUE, 15);

    $pdf -> AddPage();

    $pdf -> SetFont('helvetica', '', 12);

    $html = <<<HTML
    <h2 style="text-align:center;">Nota de Ordem de Serviço</h2>
    <table style="width=100%;">
        <tr>
            <td style="width:50%; text-align:left;">
                <strong>Client:</strong> {$client['NAME']} {$client['LASTNAME']}<br>
                <strong>Contato:</strong> {$client['PHONE']}
            </td>
            <td style="width:50%; text-align:right;">
                <strong>Data de Registro:</strong> {$serviceOrder['entry_date']}<br>
                <strong>ID OS:</strong> {$serviceOrder['id']}
            </td>
        </tr>
    </table>
    <hr>
    HTML;

    $html .= <<<HTML
    <table style="width:100%; border-collapse: collapse; margin-top: 10px;">
        <tr style="background-color: #4d4c7d; color: #FFF;">
            <th style="padding: 8px; text-align:left;">Descrição</th>
            <th style="padding: 8px; text-align:left;">Informação</th>
        </tr>
    HTML;

    $rows = [
        'Equipamento' => $serviceOrder['equipment'],
        'Descrição' => $serviceOrder['equipment_description'],
        'Estado do Serviço' => $serviceOrder['stat_service'],
        'Data Prevista de Entrega' => $serviceOrder['expected_delivery_date'],
        'Preço' => $serviceOrder['cust'],
        'Técnico Responsábel' => $serviceOrder['responsible_tech']
    ];

    $alternate = false;
    foreach ($rows as $label => $value) {
        $background = $alternate ? '#F0F0F0' : '#E0E0E0';
        $html .= <<<HTML
        <tr style="background-color: {$background};">
            <td style="padding: 8px;">{$label}</td>
            <td style="padding: 8px;">{$value}</td>           
        </tr>
        HTML;
        $alternate = !$alternate;
    }

    $html .= '</table>';

    $html .= <<<HTML
    <br><br><br>
    <div style="text-align:center;">
        <hr style="width: 60%; margin: auto;">
        <p>Assinatura do Cliente</p>
    </div>
    HTML;

    $pdf -> writeHTML($html);
    $pdf -> OutPut("nota_os_{$orderId}.pdf", 'I');

?>