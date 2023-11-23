<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PDFController extends BaseController
{
    protected $RenderPDF = 'Public';
    // protected $RenderPDF = 'debug';
    function __construct()
    {
        helper('pdfrender');
    }

    // !Preview
    // ? Untuk Semua Orang
    public function PreviewMasterSurat(string $idSurat)
    {
        $prefix = "Data_MasterSurat_" . $idSurat;
        if (cekCacheData($prefix, '')) {
            $model = model('MasterSuratModel');
            $dataSurat =  $model->seeMasterSuratbyID($idSurat);
            setCacheData($prefix, $dataSurat, 600, '');
        } else {
            $dataSurat = getCachaData($prefix, '');
        }

        // cek apakah id yang diminta ada di db ?
        if ($dataSurat['error'] == 'y') {
            return FlashMassage('/', [resMas('surat.n.exist')]);
        }

        $datapenanda = $dataSurat['form'];
        $data = TandaTanganFormater($datapenanda);

        $datajson = '{"foto":"asset/logo/unmuh.png","NoSurat":"Nomer Surat"}';

        $data['NoSurat'] = 'Belum_Memiliki_No_Surat';
        $data['isi'] = $dataSurat['isiSurat'];
        $data['kop'] = 1;

        $html = view('surat/layout', $data);
        $html = replaceHolder($html, $datajson);

        if ($this->RenderPDF == "Public") {
            $this->response->setHeader('Content-Type', 'application/pdf');
            return Render_mpdf($html, '01', 'Preview Surat - ' . $dataSurat['name'], $data);
        }

        d($dataSurat);
        d($datapenanda);
        d($datajson);
        d($data);
        d($html);
    }

    // ? Untuk Staff dan PendaTangan
    public function PreviewMasterSuratStaff(string $idSurat)
    {
        PagePerm(['Dosen']);

        $model = model('MasterSuratModel');
        $dataSurat =  $model->seeMasterSuratbyID($idSurat, 1);

        // cek apakah id yang diminta ada di db ?
        if ($dataSurat['error'] == 'y') {
            return FlashMassage('/', [resMas('surat.n.exist')]);
        }

        // $datapenanda = json_decode($dataSurat['form'], true)['TTD'];

        $datapenanda = $dataSurat['form'];
        $data = TandaTanganFormater($datapenanda);

        $datajson = '{"foto":"asset/logo/unmuh.png","NoSurat":"Nomer Surat"}';

        $data['NoSurat'] = 'Belum_Memiliki_No_Surat';
        $data['isi'] = $dataSurat['isiSurat'];
        $data['kop'] = 1;

        $html = view('surat/layout', $data);
        $html = replaceHolder($html, $datajson);

        if ($this->RenderPDF == "Public") {
            $this->response->setHeader('Content-Type', 'application/pdf');
            return Render_mpdf($html, '01', 'PreviewSurat - ' . $dataSurat['name'], $data);
        }

        d($dataSurat);
        d($datapenanda);
        d($datajson);
        d($data);
        d($html);
    }

    public function PreviewSuratMahasiswa(string $SuratIdentifier)
    {
        PagePerm(['Dosen']);

        $model = model('SuratKeluraModel');
        $dataSurat = $model->cekSuratByIdenti($SuratIdentifier);
        // d($dataSurat);
        // return;

        // cek apakah id yang diminta ada di db ?
        if ($dataSurat['error'] == 'y') {
            return FlashMassage('/', [resMas('surat.n.exist')]);
        }

        // $datapenanda = json_decode($dataSurat['form'], true)['TTD'];
        $datapenanda = $dataSurat['form'];

        $data = TandaTanganFormater($datapenanda);

        $datajson = $dataSurat['DataTambahan'];

        $data['NoSurat'] = $dataSurat['NoSurat'];
        $data['isi'] = $dataSurat['isiSurat'];
        $data['kop'] = 1;

        $html = view('surat/layout', $data);
        $html = replaceHolder($html, $datajson);

        if ($this->RenderPDF == "Public") {
            $this->response->setHeader('Content-Type', 'application/pdf');
            return Render_mpdf($html, '01', 'Preview Surat Mahasiswa - ' . $dataSurat['NoSurat'] . $dataSurat['name'], $data);
        }

        d($dataSurat);
        d($datapenanda);
        d($datajson);
        d($data);
        d($html);
    }

    public function PreviewSuratMahasiswaDenganTTD(string $noSurat)
    {
        PagePerm(['Dosen']);

        $postdata = $noSurat;

        $model = model('SuratKeluraModel');
        $dataSurat = $model->cekSuratByIdenti($postdata);

        // d($dataSurat);
        // return;

        // cek apakah id yang diminta ada di db ?
        if ($dataSurat['error'] == 'y') {
            return FlashMassage('/', [resMas('surat.n.exist')]);
        }

        $namapdf = $dataSurat['name'] . ' - ' . $dataSurat['NoSurat'];

        if ($this->RenderPDF == "Public") {
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
        }

        // !bila pdf tidak ada di server maka akan membuat kan file yang baru
        $model2 = model('TandaTangan');
        $datapenanda = $model2->seeallbyIdenti($dataSurat['SuratIdentifier']);
        $data = TandaTanganFormater($datapenanda);
        // !END


        // !Start cek bila foto yang di upload ada di server
        $datajson = $dataSurat['DataTambahan'];
        if (isset($datajson['foto'])) {
            if (!file_exists($datajson['foto'])) {
                $datajson['foto'] = 'asset/logo/error_img.png';
            }
        }
        // !END

        $data['NoSurat'] = $dataSurat['NoSurat'];
        $data['isi'] = $dataSurat['isiSurat'];
        $data['kop'] = 1;

        $html = view('surat/layout', $data);
        $html = replaceHolder($html, $datajson);


        if ($this->RenderPDF == "Public") {
            $this->response->setHeader('Content-Type', 'application/pdf');
            return Render_mpdf($html, '01', "Preview-Surat: " . $namapdf);
        }

        d($postdata);
        d($dataSurat);
        d($datapenanda);
        d($datajson);
        d($data);
        d($namapdf);
        d($html);
    }

    // ? Untuk Mahasiswa
    public function DownloadSurat()
    {
        $postdata = $this->request->getPost('id');

        $model = model('SuratKeluraModel');
        $dataSurat = $model->cekSuratByIdenti($postdata, userInfo()['NamaUser']);

        // cek apakah id yang diminta ada di db ?
        if ($dataSurat['error'] == 'y') {
            return FlashMassage('/', [resMas('surat.n.exist')]);
        }

        $namapdf = $dataSurat['name'] . ' - ' . $dataSurat['NoSurat'];

        if ($this->RenderPDF == "Public") {
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
        }

        // !bila pdf tidak ada di server maka akan membuat kan file yang baru
        $model2 = model('TandaTangan');
        $datapenanda = $model2->seeallbyIdenti($dataSurat['SuratIdentifier']);
        $data = TandaTanganFormater($datapenanda);
        // !END

        // !Start cek bila foto yang di upload ada di server
        $datajson = $dataSurat['DataTambahan'];
        if (isset($datajson['foto'])) {
            if (!file_exists($datajson['foto'])) {
                $datajson['foto'] = 'asset/logo/error_img.png';
            }
        }
        // !END

        $data['NoSurat'] = $dataSurat['NoSurat'];
        $data['isi'] = $dataSurat['isiSurat'];
        $data['kop'] = 1;

        $html = view('surat/layout', $data);
        $html = replaceHolder($html, $datajson);


        if ($this->RenderPDF == "Public") {
            $this->response->setHeader('Content-Type', 'application/pdf');
            return Render_mpdf($html, '11', $namapdf);
        }

        d($postdata);
        d($dataSurat);
        d($datapenanda);
        d($datajson);
        d($data);
        d($namapdf);
        d($html);
    }



    // !Staff
    public function staffTestMasterSurat($idSurat)
    {
        PagePerm(['Dosen']);

        $model = model('MasterSuratModel');
        $data['datasurat'] = $model->seeMasterSuratbyID($idSurat, 1);
        $data['dataform'] = json_decode($data['datasurat']['form'], true);

        // cek apakah id yang diminta ada di db ?
        if ($data['datasurat']['error'] == 'y') {
            return redirect()->to('/minta-surat');
        }

        $data['dataform'] = json_decode($data['datasurat']['form'], true);

        $data['id'] = $idSurat;

        return view('suratkeluar/pengajaran/Test_Master-surat', $data);
    }


    public function staffTestMasterSuratProses($idSurat)
    {
        PagePerm(['Dosen']);
        // $id = $this->request->getGet('id');

        $model = model('MasterSuratModel');
        $dataSurat = $model->seeMasterSuratbyID($idSurat, 1);

        // cek apakah id yang diminta ada di db ?
        if ($dataSurat['error'] == 'y') {
            return redirect()->to('/');
        }

        $dataform = $this->request->getGet();
        unset($dataform['Za1koo5E']);
        unset($dataform['id']);


        // !memasukan data penanda tangan ke dalam array
        $datapenanda = $dataSurat['form'];


        $datajson = '{"foto":"asset/logo/unmuh.png"}';

        $datajson = json_decode($datajson, true);
        foreach ($dataform as $key => $value) {
            $datajson[$key] = $value;
        }
        $datajson = json_encode($datajson);

        $datapenanda = $dataSurat['form'];
        $data = TandaTanganFormater($datapenanda);

        $data['NoSurat'] = 'Belum_Memiliki_No_Surat';
        $data['isi'] = $dataSurat['isiSurat'];
        $data['kop'] = 1;

        $html = view('surat/layout', $data);
        $html = replaceHolder($html, $datajson);



        if ($this->RenderPDF == "Public") {
            $this->response->setHeader('Content-Type', 'application/pdf');
            return Render_mpdf($html, '01', 'PreviewSurat - ' . $dataSurat['name'], $data);
        }

        d($dataSurat);
        d($datapenanda);
        d($datajson);
        d($data);
        d($html);
    }
}
