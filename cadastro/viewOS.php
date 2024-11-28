<?php 
    require_once __DIR__ . '/../../vendor/tecnickcom/tcpdf/tcpdf.php';
    require_once __DIR__ . '/../../vendor/autoload.php';

    session_start();

    $db_host = "localhost";
    $db_name = "bytecare";
    $db_user = "gabs";
    $db_pass = "gabs123";

    // Conexão com o banco de dados
    $connect = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }

    ob_start();

    if (!isset($_GET['id'])) {
        error_log("ID da ordem de serviço não especificado.");
        header("Location: error_page.php");
        exit();
    }

    $orderId = intval($_GET['id']);

    try {
        $stmt = $connect -> prepare("SELECT * FROM service_order WHERE id = ?");
        $stmt -> bind_param("i", $orderId);
        $stmt -> execute();
        $serviceOrder = $stmt -> get_result() -> fetch_assoc();
        $stmt -> close();

        if (!$serviceOrder) {
            error_log("Ordem de serviço não encontrada. ID: {$orderId}");
            header("Location: error_page.php");
            exit;
        }

        $stmt = $connect -> prepare("SELECT * FROM client WHERE id = ?");
        $stmt -> bind_param("i", $serviceOrder['id_client']);
        $stmt -> execute();
        $client = $stmt -> get_result() -> fetch_assoc();
        $stmt -> close();

        if (!$client) {
            error_log("Cliente não encontrado para a ordem de serviço. ID: {$orderId}");
            header("Location: error_page.php");
        }
        
    } catch (Exception $e) {
        die("Erro ao carregar dados: " . $e -> getMessage());
        header("Location: error_page.php");
        exit;
    }

    $logoPath = $_SERVER['DOCUMENT_ROOT'] . '/bytecare/uploads/logo.jpg';

    $pdf = new TCPDF();
    $pdf -> SetCreator('ByteCare');
    $pdf -> SetAuthor('ByteCare Sistemas');
    $pdf -> SetTitle('Nota de Ordem de Serviço');
    $pdf -> SetPrintHeader(false);
    $pdf -> SetPrintFooter(false);

    $pdf -> AddPage();

    if (file_exists($logoPath)) {
        $pdf -> Image($logoPath, 95, 10, 20);
    } else {
        die("Erro: Logo não encontrada no camninho especificado.");
    }

    $pdf -> SetFont('Helvetica', '', 12);
    $pdf -> SetXY(10, 40);
    $pdf -> Cell(0, 10, "ByteCare Soluções", 0, 1, 'C');
    $pdf -> Cell(0, 10, "CNPJ: 00.000.000/0001-00\nEndereço: Rua Exemplo, 123 - Cidade/Estado", 0, 1, 'C');

    $pdf -> SetMargins(10, 20, 10);
    /*$pdf -> SetHeaderMargin(0);
    $pdf -> SetFooterMargin(0);*/
    $pdf -> SetAutoPageBreak(TRUE, 20);

    $html = <<<HTML
    <h2 style="text-align:center;">Nota de Ordem de Serviço</h2>
    <table style="width=100%; margin: 0 auto; border-collapse: collapse;">
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
        'Técnico Responsável' => $serviceOrder['responsible_tech']
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
        <p style="font-size: 12px;">
            Assinatura do Cliente: <span style="display: inline-block; border-bottom: 1px solid black; width: 300px;">__________________________________________</span>
        </p>
    </div>
    HTML;

    $pdf -> writeHTML($html);

    if (ob_get_length()) {
        ob_end_clean();
    }
    $pdf -> Output("nota_os_{$orderId}.pdf", 'I');

?>