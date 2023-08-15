<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Jenissurat;
use App\Models\SuratKeluraModel;
use App\Models\SuratMasukModel;

// $GLOBALS['RenderPDF'] = 'public';
$GLOBALS['RenderPDF'] = 'debug';

class Pdfrender extends BaseController
{
    // !all
    public function PreviewJenisSurat($id)
    {
        // TODO : Ambil data siapa yang TTD,
        // TODO : buat tamplate TTD,
        // TODO : buat keaman dimana hanya mahasiswa itu sendiri yang dapat membuka
        // PagePerm(['mahasiswa']);
        // $getdata = $this->request->getGet();

        $model = model(Jenissurat::class);
        $dataSurat = $model->seebyID($id);

        // cek apakah id yang diminta ada di db ?
        if ($dataSurat['error'] == 'y') {
            return redirect()->to('/');
        }

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

    public function DownloadSurat()
    {
        // TODO : Ambil data siapa yang TTD,
        // TODO : buat tamplate TTD,
        // TODO : buat keaman dimana hanya mahasiswa itu sendiri yang dapat membuka

        $postdata = $this->request->getPost();

        $model = model(SuratKeluraModel::class);
        $dataSurat = $model->cekSuratByNo($postdata['id']);

        $dataJsonDecode = json_decode($dataSurat['DataTambahan'], true);

        if (isset($dataJsonDecode['foto'])) {
            if (!file_exists($dataJsonDecode['foto'])) {
                $dataJsonDecode['foto'] = 'asset/logo/error_img.png';
            }
        }

        $dataTambahan = ubaharray($dataJsonDecode);

        $data['isi'] = replacetextarray($dataSurat['isiSurat'], $dataTambahan);
        $data['kop'] = 1;
        $namapdf = $dataSurat['name'] . ' - ' . $postdata['id'];

        $html = view('surat/layout', $data);
        $html = replacetextarray($html, $dataTambahan);

        if ($GLOBALS['RenderPDF'] !== 'debug') {
            $this->response->setHeader('Content-Type', 'application/pdf');
            return Render_mpdf($html, '11', $namapdf);
        }

        d($dataJsonDecode);
        d($html);
    }


    // !Staff
    public function staffPreviewJenisSurat($id)
    {
        // TODO : Ambil data siapa yang TTD,
        // TODO : buat tamplate TTD,
        // TODO : buat keaman dimana hanya mahasiswa itu sendiri yang dapat membuka
        PagePerm(['Dosen']);
        // $getdata = $this->request->getGet();

        $model = model(Jenissurat::class);
        $dataSurat = $model->seebyID($id, 1);

        // cek apakah id yang diminta ada di db ?
        if ($dataSurat['error'] == 'y') {
            return redirect()->to('/');
        }

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
        // TODO : Ambil data siapa yang TTD,
        // TODO : buat tamplate TTD,
        // TODO : buat keaman dimana hanya mahasiswa itu sendiri yang dapat membuka
        PagePerm(['Dosen']);


        $postdata = $this->request->getPost();

        $model = model(SuratKeluraModel::class);
        $dataSurat = $model->cekSuratByNo($postdata['id']);

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

    public function staffViewSurat()
    {
        $postdata = $this->request->getPost('id');
        $model = Model(SuratMasukModel::class);
        $namaFile = $model->seebyid($postdata)['NamaFile'];
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

        // d($postdata);
        // d($model->seebyid($postdata));
        // d($path);
        // d($file);
        // d($binary);

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
