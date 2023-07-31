<?php
require __DIR__ . '/vendor/autoload.php';

define('UPLOAD_DIR', 'pdfs/');
if (isset($_POST['data'])) {
  $name = sha1(microtime());
  $data = $_POST['data'];

  @file_put_contents("texto.txt", $data);
  $mpdf = new \Mpdf\Mpdf();

  $mpdf->WriteHTML('<columns column-count="5" vAlign="J" column-gap="7" />');
  // Write some HTML code:
  $mpdf->WriteHTML($data);

  // Output a PDF file directly to the browser
  $mpdf->Output('pdfs/'.$name.'.pdf', \Mpdf\Output\Destination::FILE);



  // define('UPLOAD_DIR', 'pdfs/');
  // use Dompdf\Dompdf;
  // use Dompdf\Options;

  // if (isset($_POST['data'])) {
  //   $name = sha1(microtime());
  //   $data = $_POST['data'];

  //   @file_put_contents("texto.txt", $data);

  //   $options = new Options();
  //   $options->setIsRemoteEnabled(true);


  //   $dompdf = new Dompdf($options);
  //   $dompdf->setBasePath($_SERVER['DOCUMENT_ROOT']);

  //   $context = stream_context_create([
  //     'ssl' => [
  //     'verify_peer' => FALSE,
  //     'verify_peer_name' => FALSE,
  //     'allow_self_signed'=> TRUE
  //     ]
  //     ]);

  //     $dompdf->setHttpContext($context);

  //   $dompdf->loadHtml($data);
  //   $dompdf->setPaper('A4', 'landscape');

  //   $dompdf->render();

  //   $pdf= $dompdf->output();

  //   @file_put_contents(UPLOAD_DIR.$name.".pdf", $pdf);
  //   echo json_encode(UPLOAD_DIR.$name.".pdf");

}
