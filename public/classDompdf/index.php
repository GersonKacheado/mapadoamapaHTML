<?php
	require_once("dompdf/dompdf_config.inc.php");

	$dompdf = new DOMPDF(["enable_remote" => true]);

	$html = "<h1>Modelo em PDF</h1>";
	$dompdf->load_html($html);
	$dompdf->load_html($html);

	ob_start();
	require_once"../../view/atendidos.php"; 
	$dompdf->load_html(ob_get_clean());
	$dompdf->set_paper('A4', 'landscape');
	$dompdf->render();
	$dompdf->stream("saida.pdf", array("Attachment" => false));



?>


