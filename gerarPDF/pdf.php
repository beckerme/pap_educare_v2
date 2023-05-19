<?php
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf(['enable_remote' => true]);

$dados = '<h1>TESTE 1 2 3</h1>';

$dompdf->loadHtml($dados);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream('Fatura VeganHome', ["Attachment" => false]);

?>