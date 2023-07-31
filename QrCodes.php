<?php
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/phpqrcode/qrlib.php');
require_once(__DIR__ . '/Database.php');

class QrCodes
{
    const PNG_TEMP_DIR = 'assets/files/temp';
    const UPLOAD_DIR =  'assets/files/pdfs/';
    private $sql;
    private $randomCodes = [];
   

    public function __construct()
    {
        if(is_null($this->sql)){
            $this->sql = Database::getInstance();
        } 
    }

    public function getCodeFromDB()
    {
        if (!is_null($this->sql)) {
            $query = "SELECT code from qrcode  where is_used = 0 ";

            if ($result = mysqli_query($this->sql, $query)) {
                if (mysqli_num_rows($result) > 0) {

                    while ($cRecord = mysqli_fetch_assoc($result)) {
                        array_push($this->randomCodes, $cRecord);
                    }

                    return $this;
                }

                $this->randomCodes = Null;
                return $this;
            }
        }

        return $this;
    }

    public function generateQrCodes($url = '')
    {
        $name = sha1(microtime());
        if (!is_null($this->randomCodes)) {

            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML('<columns column-count="5" vAlign="J" column-gap="6" />');

            foreach ($this->randomCodes as $value) {
                $code = $value['code'];
                $link = ($url !='' && !empty($url)) ? rtrim($url, '/').'/'.$code : $code;
                $errorCorrectionLevel = 'L';
                // user data
                $filename = self::PNG_TEMP_DIR . '\test' . md5($value['code'] . '|' . $errorCorrectionLevel . '|') . '.png';
                QRcode::png($link, $filename, $errorCorrectionLevel,6);

                // Write some HTML code:
                $mpdf->WriteHTML("
                    <table>
                    <tbody>
                        <tr>
                            <td>
                                <img src='$filename' alt='$filename'>
                                <p style='font-weight:bold;font-size:10px;'>$code</p>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                    ");

                $insertQuery = "UPDATE qrcode SET is_used = 1 where code ='" . $code . "'";
                mysqli_query($this->sql, $insertQuery);
            }
            // Output a PDF file directly to the browser
            $mpdf->Output(self::UPLOAD_DIR . $name . '.pdf', \Mpdf\Output\Destination::FILE);
            //    @file_put_contents(UPLOAD_DIR.$name.".pdf", $pdf);
              return self::UPLOAD_DIR.$name.'.pdf';
        }
    }
}


