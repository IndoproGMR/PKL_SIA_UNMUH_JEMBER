<?php
// library qr
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

// library pdf
use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\Writer\WebPWriter;
use PhpParser\Node\Stmt\Return_;

// dataqr isi qr code
// savefile nama file yang disimpan
function Render_Qr(String $dataqr, String $savefile)
{
    $dir      = "uploads/QRcodeTTD/" . userInfo()['id'];
    $lokasi   = cekDir($dir) . "/$savefile.png";
    // $writer = new PngWriter(9);
    $writer = new WebPWriter(100);
    try {

        // Create QR code
        $qrCode = QrCode::create($dataqr)
            ->setEncoding(new Encoding('UTF-8'))
            ->setSize(500)
            ->setMargin(10)
            // ->compression_level(3)
            // ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            // ->setForegroundColor(new Color(0, 0, 0))
            // ->setBackgroundColor(new Color(255, 255, 255))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow());


        // Create generic logo
        $logo = Logo::create($_ENV['logoqr'])
            ->setResizeToWidth(150);

        $result = $writer->write($qrCode, $logo);

        $result->saveToFile(FCPATH . $lokasi);
    } catch (Exception $e) {
        return false;
    }
    return true;
}

/** 
 * $htmlpage di ambil dari view() yang berada di controller
 * lokasi page yang di render 
 * 00 = tidak di save dan view;
 * 01 = tidak di save tapi di view;
 * 10 = di save tapi tidak ada view;
 * 11 = di save dan di view;
 * nama file yang disimpan
 */
function Render_mpdf(String $htmlpage, String $saveorview, String $namapdf)
{
    $namahash = hash256($namapdf);
    $lokasi = cekDir(WRITEPATH . "pdf/") . "$namahash.pdf";


    $mpdf = new \Mpdf\Mpdf(['tempDir' => WRITEPATH . 'temp']);
    $mpdf->WriteHTML($htmlpage);
    $mpdf->SetTitle($namapdf);
    switch ($saveorview) {
        case '00':
            // no save no view
            return FlashException('Mode PDF di set ke No View dan No Save');
            break;

        case '01':
            // no save but view
            return $mpdf->Output($namapdf, 'I');
            break;

        case '10':
            // save but no view
            if (!cekFile($lokasi)) {
                $mpdf->OutputFile($lokasi);
            }
            return FlashException('Mode PDF di set ke Only Save', 'set');
            break;

        case '11':
            // save and view
            if (!cekFile($lokasi)) {
                $mpdf->OutputFile($lokasi);
            }
            return $mpdf->Output($namapdf, 'I');
            break;

        default:
            return FlashException('Mode PDF di set ke No View dan No Save');
            break;
    }
}




// !! Deprecated
/** 
 * lokasi page yang di render 
 * 00 = tidak di save dan view;
 * 01 = tidak di save tapi di view;
 * 10 = di save tapi tidak ada view;
 * 11 = di save dan di view;
 * nama file yang disimpan
 */
function Render_pdf(String $htmlpage, String $saveorview, String $namapdf, $data = null)
{
    // data tidak boleh kosong
    $data['defaultdata'] = "data dummy";

    $lokasi = "pdf/$namapdf.pdf";
    // instantiate and use the dompdf class
    $dompdf = new Dompdf();

    $dompdf->loadHtml(view($htmlpage, $data));

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();
    $output = $dompdf->output();

    // Output the generated PDF to Browser

    switch ($saveorview) {
        case '00':
            // no save no view
            echo "no view";
            break;
        case '01':
            // no save but view
            $dompdf->stream($namapdf, array("Attachment" => false));
            break;
        case '10':
            // save but no view
            file_put_contents($lokasi, $output);
            break;
        case '11':
            // save and view
            $dompdf->stream($namapdf, array("Attachment" => false));
            file_put_contents($lokasi, $output);
            break;

        default:
            echo "no view";
            break;
    }
}



// lokasi public/{lokasi}
// class pada css
function Render_gambar(String $lokasi, String $class)
{
    if (file_exists($lokasi)) {
        $type = pathinfo($lokasi, PATHINFO_EXTENSION);
        $data = file_get_contents($lokasi);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        Render_gambar_dari_base64($base64, $class);
    } else {
        echo "img not found: " . $lokasi;
    }
}

// base64 code
// class pada css
function Render_gambar_dari_base64(String $database64, String  $class)
{
    echo "<img src='" . $database64 . "' class='" . $class . "' alt='' loading='lazy'>";
}

function Render_TTD(String $LokasiGambar, $data)
{
    echo $data['tanggal'];
    echo '</br>';
    Render_gambar($LokasiGambar, "fotottd");
    echo '</br>';
    echo $data['nama'];
}
