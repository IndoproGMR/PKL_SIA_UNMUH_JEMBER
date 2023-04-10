<?php

namespace App\Libraries;

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



class Rendergambar
{
    // lokasi public/{lokasi}
    // class pada css
    public function Render_gambar(String $lokasi, String $class)
    {
        if (file_exists($lokasi)) {
            $type = pathinfo($lokasi, PATHINFO_EXTENSION);
            $data = file_get_contents($lokasi);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            echo "<img src='" . $base64 . "' class='" . $class . "' alt='' loading='lazy'>";
        } else {
            echo "img not found: " . $lokasi;
        }
    }

    // base64 code
    // class pada css
    public function Render_gambar_dari_base64(String $database64, String  $class)
    {
        echo "<img src='" . $database64 . "' class='" . $class . "' alt='' loading='lazy'>";
    }

    // dataqr isi qr code
    // savefile nama file yang disimpan
    public function Render_Qr(String $dataqr, String $savefile)
    {
        $lokasi = "qrcode/$savefile.png";
        $writer = new PngWriter(9);

        // Create QR code
        $qrCode = QrCode::create($dataqr)
            ->setEncoding(new Encoding('UTF-8'))
            ->setSize(500)
            ->setMargin(10)
            // ->compression_level(3)
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow());
        // ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
        // ->setForegroundColor(new Color(0, 0, 0))
        // ->setBackgroundColor(new Color(255, 255, 255));


        // Create generic logo
        $logo = Logo::create($_ENV['logoqr'])
            ->setResizeToWidth(50);

        $result = $writer->write($qrCode, $logo);

        $result->saveToFile(FCPATH . $lokasi);
    }
    public function Render_Qr_temp(String $dataqr, String $savefile)
    {
        $lokasi = "qrtemp/$savefile.png";
        $writer = new PngWriter();

        // Create QR code
        $qrCode = QrCode::create($dataqr)
            ->setEncoding(new Encoding('UTF-8'))
            ->setSize(300)
            ->setMargin(10)
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow());
        // ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
        // ->setForegroundColor(new Color(0, 0, 0))
        // ->setBackgroundColor(new Color(255, 255, 255));


        // Create generic logo
        $logo = Logo::create($_ENV['logoqr'])
            ->setResizeToWidth(50);

        $result = $writer->write($qrCode, $logo);

        $result->saveToFile(FCPATH . $lokasi);
    }

    // lokasi page yang di render 
    // 00 = tidak di save dan view
    // 01 = tidak di save tapi di view
    // 10 = di save tapi tidak ada view
    // 11 = di save dan di view
    // nama file yang disimpan
    public function Render_pdf(String $htmlpage, String $saveorview, String $namapdf, $data = null)
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
}
