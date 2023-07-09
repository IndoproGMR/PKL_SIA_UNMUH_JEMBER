<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Jenissurat;
use App\Models\Suratmasuk;

class Pdfrender extends BaseController
{
    public function PreviewSurat()
    {
        PagePerm(['Dosen']);


        $postdata = $this->request->getPost();

        $model = model(Suratmasuk::class);
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

        $this->response->setHeader('Content-Type', 'application/pdf');
        return Render_mpdf($html, '01', 'PreviewSurat_-_' . $dataSurat['name'], $data);
    }

    public function PreviewJenisSurat($id)
    {
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

        $this->response->setHeader('Content-Type', 'application/pdf');
        return Render_mpdf($html, '01', 'PreviewSurat - ' . $dataSurat['name'], $data);
    }

    public function DownloadSurat()
    {
        // TODO : Ambil data siapa yang TTD,
        // TODO : buat tamplate TTD,
        // TODO : buat keaman dimana hanya mahasiswa itu sendiri yang dapat membuka

        $postdata = $this->request->getPost();

        $model = model(Suratmasuk::class);
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

        $this->response->setHeader('Content-Type', 'application/pdf');
        return Render_mpdf($html, '01', $dataSurat['name'] . ' - ' . $postdata['id'], $data);
    }
}
