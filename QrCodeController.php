<?php
require_once __DIR__.'/Codes.php';
require_once __DIR__.'/QrCodes.php';

if (isset($_REQUEST['data']) && ($_REQUEST['url'])) {
    $total = 0;
    $count = $_REQUEST['data'];
    $url = $_REQUEST['url'];
   
    for($i = 1; $i <= $count; $i++) {
            (new Codes())
            ->generateRandomCode()
            ->InsertToDB();

            $total +=1;
    }

   $result =  (new QrCodes())
    ->getCodeFromDB()
    ->generateQrCodes($url);

    echo json_encode(['total' => $total, 'result' => $result]);
}



