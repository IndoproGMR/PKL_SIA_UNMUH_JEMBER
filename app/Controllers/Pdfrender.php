<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Jenissurat;
use App\Models\SuratKeluraModel;
use App\Models\SuratMasukModel;

$GLOBALS['RenderPDF'] = 'public';
// $GLOBALS['RenderPDF'] = 'debug';

class Pdfrender extends BaseController
{
    // !all
    public function PreviewJenisSurat($id)
    {
        // PagePerm(['mahasiswa']);

        $model = model(Jenissurat::class);
        $dataSurat = $model->seebyID($id);


        // cek apakah id yang diminta ada di db ?
        if ($dataSurat['error'] == 'y') {
            return redirect()->to('/');
        }

        $datapenanda = json_decode($dataSurat['form'], true)['TTD'];

        // !memasukan data penanda tangan ke dalam array
        $model3 = model('AuthUserGroup');
        foreach ($datapenanda as $key => $value) {

            $infopenada = pecahkan($value);
            $namapenanda['NamaUser'] = $infopenada[1];
            $namapenanda['namaLVL'] = $infopenada[1];
            $namapenanda['Gelar'] = '';
            if ($infopenada[0] == 'Perorangan') {
                $namapenanda = $model3->cekdoseninfo($infopenada[1]);
            }

            $data['ttd'][$key] = [
                'TimeStamp'   => 0,
                'path'        => 'asset/logo/unmuh.png',
                'NamaPenanda' => $namapenanda['NamaUser'] . " " . $namapenanda['Gelar'],
                'namaLVL'     => $namapenanda['namaLVL'],
            ];
        }
        // !END

        // d($data);
        // return


        $datajson = '{"foto":"asset/logo/unmuh.png"}';
        $dataTambahan = ubaharray(json_decode($datajson));

        $data['isi'] = $dataSurat['isiSurat'];
        $data['kop'] = 1;

        $html = view('surat/layout', $data);
        $html = replacetextarray($html, $dataTambahan);

        $this->response->setHeader('Content-Type', 'application/pdf');
        return Render_mpdf($html, '01', 'PreviewSurat - ' . $dataSurat['name'], $data);
    }

    public function DownloadSurat()
    {
        // TODO : buat keaman dimana hanya mahasiswa itu sendiri yang dapat membuka

        $postdata = $this->request->getPost('id');

        $model = model('SuratKeluraModel');
        $dataSurat = $model->cekSuratByNo($postdata);

        $namapdf = $dataSurat['name'] . ' - ' . $postdata;


        // !Start cek apakah file pdf di buat atau belum
        // !bila sudah di buat maka baca binary nya
        if (cekFile(WRITEPATH . 'pdf/' . hash256($namapdf) . ".pdf")) {
            helper('filesystem');
            $namaFile = hash256($namapdf) . ".pdf";
            try {
                $path = WRITEPATH . 'pdf/' . $namaFile;
                $file = new \CodeIgniter\Files\File($path, true);
            } catch (\Throwable $th) {
                try {
                    $path = "../Z_Archive/pdf/" . $namaFile;
                    $file = new \CodeIgniter\Files\File($path, true);
                } catch (\Throwable $th) {
                    return FlashException(resMas('e.server.n.dp.read.fl'));
                }
            }

            $binary = readfile($path);
            return $this->response
                ->setHeader('Content-Type', $file->getMimeType())
                ->setHeader('Content-disposition', 'inline; filename="' . $file->getBasename() . '"')
                ->setStatusCode(200)
                ->setBody($binary);
        }
        // !END


        // !bila pdf tidak ada di server maka akan membuat kan file yang baru
        $model2 = model('TandaTangan');
        $data['ttd'] = $model2->seeallbyIdenti($dataSurat['SuratIdentifier']);



        // !Start cek bila foto qr ada di server
        foreach ($data['ttd'] as $key => $value) {
            $path = cekDir('uploads/QRcodeTTD/' . $data['ttd'][$key]['pendattg_id']) . "/" . $data['ttd'][$key]['qrcodeName'] . ".png";

            if (!cekFile($path)) {
                Render_Qr($data['ttd'][$key]['hash'], $data['ttd'][$key]['qrcodeName'], $data['ttd'][$key]['pendattg_id']);
            }

            $model3 = model('AuthUserGroup');
            $datapenanda = $model3->cekdoseninfo($data['ttd'][$key]['pendattg_id']);

            $data['ttd'][$key]['NamaPenanda'] = $datapenanda['NamaUser'] . " " . $datapenanda['Gelar'];
            $data['ttd'][$key]['path'] = $path;
            $data['ttd'][$key]['namaLVL'] = $datapenanda['namaLVL'];
        }
        // !END

        // !Start cek bila foto yang di upload ada di server
        $dataJsonDecode = json_decode($dataSurat['DataTambahan'], true);
        if (isset($dataJsonDecode['foto'])) {
            if (!file_exists($dataJsonDecode['foto'])) {
                $dataJsonDecode['foto'] = 'asset/logo/error_img.png';
            }
        }
        // !END

        $dataTambahan = ubaharray($dataJsonDecode);

        $data['isi'] = replacetextarray($dataSurat['isiSurat'], $dataTambahan);
        $data['kop'] = 1;

        $html = view('surat/layout', $data);
        $html = replacetextarray($html, $dataTambahan);

        $this->response->setHeader('Content-Type', 'application/pdf');
        return Render_mpdf($html, '11', $namapdf);
    }


    // !Staff
    public function staffTestJenisSurat($id)
    {
        // TODO : buat keaman dimana hanya mahasiswa itu sendiri yang dapat membuka
        PagePerm(['Dosen']);

        $model = model(Jenissurat::class);
        $data['datasurat'] = $model->seebyID($id, 1);
        $data['dataform'] = json_decode($data['datasurat']['form'], true);

        // cek apakah id yang diminta ada di db ?
        if ($data['datasurat']['error'] == 'y') {
            return redirect()->to('/minta-surat');
        }

        $data['dataform'] = json_decode($data['datasurat']['form'], true);

        $data['id'] = $id;

        return view('suratkeluar/pengajaran/Test_Master-surat', $data);
    }

    public function staffTestJenisSuratProses()
    {
        // TODO : buat keaman dimana hanya mahasiswa itu sendiri yang dapat membuka
        PagePerm(['Dosen']);
        $id = $this->request->getGet('id');


        $model = model(Jenissurat::class);
        $dataSurat = $model->seebyID($id, 1);

        // cek apakah id yang diminta ada di db ?
        if ($dataSurat['error'] == 'y') {
            return redirect()->to('/');
        }

        $dataform = $this->request->getGet();
        unset($dataform['Za1koo5E']);
        unset($dataform['LaB7Thol']);
        unset($dataform['id']);


        // !memasukan data penanda tangan ke dalam array
        $datapenanda = json_decode($dataSurat['form'], true)['TTD'];
        $model3 = model('AuthUserGroup');
        foreach ($datapenanda as $key => $value) {

            $infopenada = pecahkan($value);
            $namapenanda['NamaUser'] = $infopenada[1];
            $namapenanda['namaLVL'] = $infopenada[1];
            $namapenanda['Gelar'] = '';
            if ($infopenada[0] == 'Perorangan') {
                $namapenanda = $model3->cekdoseninfo($infopenada[1]);
            }

            $data['ttd'][$key] = [
                'TimeStamp'   => 0,
                'path'        => 'asset/logo/unmuh.png',
                'NamaPenanda' => $namapenanda['NamaUser'] . " " . $namapenanda['Gelar'],
                'namaLVL'     => $namapenanda['namaLVL'],
            ];
        }
        // !END

        $datajson = '{"foto":"asset/logo/unmuh.png"}';



        $dataTambahan = ubaharray(json_decode($datajson));

        $data['isi'] = $dataSurat['isiSurat'];
        $data['kop'] = 1;

        $html = view('surat/layout', $data);
        $html = replacetextarray($html, $dataTambahan);

        $dataTambahan = ubaharray($dataform);
        $html = replacetextarray($html, $dataTambahan);

        if ($GLOBALS['RenderPDF'] !== 'debug') {
            $this->response->setHeader('Content-Type', 'application/pdf');
            return Render_mpdf($html, '01', 'PreviewSurat - ' . $dataSurat['name'], $data);
        }

        d($dataSurat);
        d($dataTambahan);
        d($datajson);
        d($data);
        d($dataSurat);
        d($html);
    }

    public function staffPreviewJenisSurat($id)
    {
        // TODO : buat keaman dimana hanya mahasiswa itu sendiri yang dapat membuka
        PagePerm(['Dosen']);

        $model = model(Jenissurat::class);
        $dataSurat = $model->seebyID($id, 1);

        // cek apakah id yang diminta ada di db ?
        if ($dataSurat['error'] == 'y') {
            return redirect()->to('/');
        }


        $datapenanda = json_decode($dataSurat['form'], true)['TTD'];

        // !memasukan data penanda tangan ke dalam array
        $model3 = model('AuthUserGroup');
        foreach ($datapenanda as $key => $value) {

            $infopenada = pecahkan($value);
            $namapenanda['NamaUser'] = $infopenada[1];
            $namapenanda['namaLVL'] = $infopenada[1];
            $namapenanda['Gelar'] = '';
            if ($infopenada[0] == 'Perorangan') {
                $namapenanda = $model3->cekdoseninfo($infopenada[1]);
            }

            $data['ttd'][$key] = [
                'TimeStamp'   => 0,
                'path'        => 'asset/logo/unmuh.png',
                'NamaPenanda' => $namapenanda['NamaUser'] . " " . $namapenanda['Gelar'],
                'namaLVL'     => $namapenanda['namaLVL'],
            ];
        }
        // !END

        $datajson = '{"foto":"asset/logo/unmuh.png"}';
        $dataTambahan = ubaharray(json_decode($datajson));

        $data['isi'] = $dataSurat['isiSurat'];
        $data['kop'] = 1;

        $html = view('surat/layout', $data);
        $html = replacetextarray($html, $dataTambahan);

        if ($GLOBALS['RenderPDF'] !== 'debug') {
            $this->response->setHeader('Content-Type', 'application/pdf');
            return Render_mpdf($html, '01', 'PreviewSurat - ' . $dataSurat['name'], $data);
        }

        d($dataSurat);
        d($dataTambahan);
        d($datajson);
        d($data);
        d($dataSurat);
        d($html);
    }

    public function staffPreviewSurat()
    {
        // TODO : buat keaman dimana hanya mahasiswa itu sendiri yang dapat membuka
        PagePerm(['Dosen']);


        $postdata = $this->request->getPost('id');

        $model = model(SuratKeluraModel::class);
        $dataSurat = $model->cekSuratByNo($postdata);


        // !memasukan data penanda tangan ke dalam array
        $datapenanda = json_decode($dataSurat['form'], true)['TTD'];
        $model3 = model('AuthUserGroup');
        foreach ($datapenanda as $key => $value) {

            $infopenada = pecahkan($value);
            $namapenanda['NamaUser'] = $infopenada[1];
            $namapenanda['namaLVL'] = $infopenada[1];
            $namapenanda['Gelar'] = '';
            if ($infopenada[0] == 'Perorangan') {
                $namapenanda = $model3->cekdoseninfo($infopenada[1]);
            }

            $data['ttd'][$key] = [
                'TimeStamp'   => 0,
                'path'        => 'asset/logo/unmuh.png',
                'NamaPenanda' => $namapenanda['NamaUser'] . " " . $namapenanda['Gelar'],
                'namaLVL'     => $namapenanda['namaLVL'],
            ];
        }
        // !END

        $dataJsonDecode = json_decode($dataSurat['DataTambahan'], true);

        if (isset($dataJsonDecode['foto'])) {
            if (!file_exists($dataJsonDecode['foto'])) {
                $dataJsonDecode['foto'] = 'asset/logo/error_img.png';
            }
        }

        $dataTambahan = ubaharray($dataJsonDecode);

        $data['isi'] = replacetextarray($dataSurat['isiSurat'], $dataTambahan);
        $data['kop'] = 1;

        $html = view('surat/layout', $data);
        $html = replacetextarray($html, $dataTambahan);

        if ($GLOBALS['RenderPDF'] !== 'debug') {
            $this->response->setHeader('Content-Type', 'application/pdf');
            return Render_mpdf($html, '01', 'PreviewSurat_-_' . $dataSurat['name'], $data);
        }

        d($dataJsonDecode);
        d($html);
    }


    // !Archive
    public function staffViewSurat()
    {
        $postdata = $this->request->getPost('id');
        $model = Model(SuratMasukModel::class);
        $namaFile = $model->seefilebyid($postdata);
        helper('filesystem');
        try {
            $path = WRITEPATH . $namaFile;
            $file = new \CodeIgniter\Files\File($path, true);
        } catch (\Throwable $th) {
            try {
                $path = "../Z_Archive/" . $namaFile;
                $file = new \CodeIgniter\Files\File($path, true);
            } catch (\Throwable $th) {
                return FlashException('file Tidak ada didalam server');
            }
        }
        $binary = readfile($path);

        return $this->response
            ->setHeader('Content-Type', $file->getMimeType())
            ->setHeader('Content-disposition', 'inline; filename="' . $file->getBasename() . '"')
            ->setStatusCode(200)
            ->setBody($binary);
    }

    // !========================================================================
    public function TestMPDF()
    {
        $datajson = '{"foto":"asset/logo/unmuh.png"}';
        $dataTambahan = ubaharray(json_decode($datajson));

        $data['isi'] = '<h1>TEST MPDF</h1><hr>';
        $data['kop'] = 1;

        $html = view('surat/layout', $data);
        $html = replacetextarray($html, $dataTambahan);


        if ($GLOBALS['RenderPDF'] !== 'debug') {
            $this->response->setHeader('Content-Type', 'application/pdf');
            return Render_mpdf($html, '01', 'PreviewSurat - TEST MPDF', $data);
        }

        // d($dataJsonDecode);
        d($html);
    }
}
